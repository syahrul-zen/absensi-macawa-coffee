<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Shift;
use App\Models\User;
use App\Models\Presence;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.Karyawan.index', [
            'shifts' => Shift::all(),
            'employees' => Employee::with('shift')->latest()->get(),
            'dataOwner' => User::find(2)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:150',
            'email' => 'required|email|max:100|unique:employees,email', // unik di tabel karyawans
            'password' => 'required|string|min:8',
            'jabatan' => 'required|in:Barista,Kitchen Staff,Cashier',
            'shift_id' => 'required|exists:shifts,id', // wajib ada di tabel shifts
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar sebagai karyawan.',
            'password.required' => 'Password login wajib ditentukan.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'jabatan.required' => 'Pilih salah satu jabatan posisi.',
            'shift_id.required' => 'Tentukan alokasi shift kerja utama.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Eksekusi penyimpanan data karyawan baru
        Employee::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password wajib di-hash/enkripsi demi keamanan
            'jabatan' => $request->jabatan,
            'shift_id' => $request->shift_id,
        ]);

        return redirect()->back()->with('success', 'Anggota kru baru berhasil didaftarkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */ 
    public function update(Request $request, Employee $karyawan)
    {

        $validatedData = $request->validate([
            'nama' => 'required|string|max:150',
            'email' => 'required|email|max:100|unique:employees,email,'.$karyawan->id,
            'password' => 'nullable|string|min:8',
            'jabatan' => 'required|in:Barista,Kitchen Staff,Cashier',
            'shift_id' => 'required|exists:shifts,id',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh karyawan lain.',
            'password.min' => 'Password baru minimal harus 8 karakter.',
            'jabatan.required' => 'Pilih posisi jabatan karyawan.',
            'shift_id.required' => 'Tentukan alokasi shift kerja utama.',
        ]);

        // Siapkan array data yang akan diupdate
        $updateData = [
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'shift_id' => $request->shift_id,
        ];

        // Jika input password diisi, enkripsi lalu masukkan ke data update
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $karyawan->update($updateData);

        return redirect()->back()->with('success', 'Data karyawan '.$karyawan->nama.' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $karyawan)
    {

        $nama = $karyawan->nama;

        $karyawan->delete();

        return back()->with('success', 'Data Karyawan '.$nama.' berhasil dihapus');
    }

    public function home() {

        $karyawan = Auth::guard('employee')->user();
        $shift = $karyawan->shift;

        // Mengunci pencatatan ke zona waktu lokal Indonesia Barat (WIB)
        $hariIni = Carbon::today('Asia/Jakarta')->toDateString();
        $jamSekarang = Carbon::now('Asia/Jakarta')->toTimeString();

        // Cari data absensi karyawan hari ini
        $absensiHariIni = Presence::where('employee_id', $karyawan->id)
            ->where('tanggal', $hariIni)
            ->first();

        // Cek Apakah berada di dalam rentang waktu shift
        // Karyawan hanya bisa absen dari jam_masuk shift sampai jam_pulang shift
        $isDalamJamShift = ($jamSekarang >= $shift->jam_masuk && $jamSekarang <= $shift->jam_pulang);



        return view('Karyawan.absensi', [
            'karyawan' => $karyawan->load('shift'), 
            'shift' => $shift, 
            'absensiHariIni' => $absensiHariIni, 
            'isDalamJamShift' => $isDalamJamShift
        ]);
    }

    public function setAdmin(Request $request) {

        // 1. Ambil data admin yang sedang login
        $admin = User::first();

        // Gunakan Validator manual agar bisa membungkus error ke dalam 'adminAccount'
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|unique:admin,email,' . $admin->id .'|unique:employees,email',
            'password' => 'nullable|max:10', // Ini adalah kolom password (saat ini) untuk konfirmasi
        ], [
            'email.unique' => 'Alamat email ini sudah digunakan oleh akun lain.',
            'password.required' => 'Anda wajib memasukkan password saat ini untuk konfirmasi keamanan.',
        ]);

        // Jika validasi gagal, lempar ke 'adminAccount'
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'adminAccount')
                ->withInput();
        }
        // Simpan perubahan (Hanya email yang berubah)
        
        $admin->email = $request->email;
        $admin->save();

        return redirect()->back()->with('success', 'Akun admin berhasil diperbarui!');
    }

    public function setOwner(Request $request) {

        // 1. Ambil data admin yang sedang login
        $admin = User::find(2);

        // Gunakan Validator manual agar bisa membungkus error ke dalam 'adminAccount'
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|unique:admin,email,' . $admin->id .'|unique:employees,email',
            'password' => 'nullable|max:10', // Ini adalah kolom password (saat ini) untuk konfirmasi
        ], [
            'email.unique' => 'Alamat email ini sudah digunakan oleh akun lain.',
            'password.required' => 'Anda wajib memasukkan password saat ini untuk konfirmasi keamanan.',
        ]);

        // Jika validasi gagal, lempar ke 'adminAccount'
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'ownerAccount')
                ->withInput();
        }
        // Simpan perubahan (Hanya email yang berubah)
        
        $admin->email = $request->email;
        $admin->save();

        return redirect()->back()->with('success', 'Akun Owner berhasil diperbarui!');
    }

    public function riwayat(Request $request) {
        // $karyawan = auth()->user();
        $karyawan = Auth::guard('employee')->user();
    
        // Ambil filter bulan & tahun dari request, default ke bulan & tahun sekarang (Mei 2026)
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);

        // 1. Ambil list riwayat absensi untuk tabel utama (70%)
        $riwayatAbsensi = Presence::where('employee_id', $karyawan->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        // 2. Hitung statistik untuk ringkasan sidebar (30%)
        $totalHadir = $riwayatAbsensi->whereIn('status', ['Tepat Waktu', 'Terlambat'])->count();
        $totalIzin  = $riwayatAbsensi->where('status', 'Izin')->count();
        $totalAlpa  = $riwayatAbsensi->where('status', 'Alpa')->count();
        
        return view('Karyawan.riwayat', compact(
            'riwayatAbsensi', 
            'totalHadir', 
            'totalIzin', 
            'totalAlpa', 
            'bulan',
            'tahun'
        ));
    }
    
}
