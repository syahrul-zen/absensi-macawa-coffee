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

    // public function home() {

    //     $karyawan = Auth::guard('employee')->user();
    //     $shift = $karyawan->shift;

    //     // return $shift;
    
    //     // Mengunci pencatatan ke zona waktu lokal Indonesia Barat (WIB)
    //     $hariIni = Carbon::today('Asia/Jakarta')->toDateString();
    //     $jamSekarang = Carbon::now('Asia/Jakarta')->toTimeString();

    //     // Cari data absensi karyawan hari ini
    //     $absensiHariIni = Presence::where('employee_id', $karyawan->id)
    //         ->where('tanggal', $hariIni)
    //         ->first();

    //     // Cek Apakah berada di dalam rentang waktu shift
    //     // Karyawan hanya bisa absen dari jam_masuk shift sampai jam_pulang shift
    //     // $isDalamJamShift = ($jamSekarang >= $shift->jam_masuk && $jamSekarang <= $shift->jam_pulang);

    //     // return $isDalamJamShift;

    //     $jamSekarang = Carbon::now('Asia/Jakarta')->toTimeString(); // "23:46:00"

    //     // Cek apakah shift ini melewati tengah malam (Contoh: 23:41 > 00:42)
    //     if ($shift->jam_masuk > $shift->jam_pulang) {
    //         // Logika untuk Shift Malam (Melewati Tengah Malam)
    //         $isDalamJamShift = ($jamSekarang >= $shift->jam_masuk || $jamSekarang <= $shift->jam_pulang);
    //     } else {
    //         // Logika untuk Shift Normal (Pagi/Siang di hari yang sama)
    //         $isDalamJamShift = ($jamSekarang >= $shift->jam_masuk && $jamSekarang <= $shift->jam_pulang);
    //     }

    //     return view('Karyawan.absensi', [
    //         'karyawan' => $karyawan->load('shift'), 
    //         'shift' => $shift, 
    //         'absensiHariIni' => $absensiHariIni, 
    //         'isDalamJamShift' => $isDalamJamShift
    //     ]);
    // }

    
    public function home() {

        $karyawan = Auth::guard('employee')->user();
        $shift = $karyawan->shift;

        // Mengunci pencatatan ke zona waktu lokal Indonesia Barat (WIB)
        $hariIni = Carbon::today('Asia/Jakarta')->toDateString();
        $sekarang = Carbon::now('Asia/Jakarta');
        $jamSekarang = $sekarang->toTimeString();

        // Cari data absensi karyawan hari ini
        $absensiHariIni = Presence::where('employee_id', $karyawan->id)
            ->where('tanggal', $hariIni)
            ->first();

        // 1. LOGIKA UNTUK ABSEN MASUK ($isDalamJamShift)
        if ($shift->jam_masuk > $shift->jam_pulang) {
            // Shift Malam (misal: 23:41 - 00:42)
            $isDalamJamShift = ($jamSekarang >= $shift->jam_masuk || $jamSekarang <= $shift->jam_pulang);
        } else {
            // Shift Normal (misal: 08:00 - 16:00)
            $isDalamJamShift = ($jamSekarang >= $shift->jam_masuk && $jamSekarang <= $shift->jam_pulang);
        }

        // 2. LOGIKA UNTUK ABSEN PULANG ($isBolehPulang: Min 15 Menit Sebelum Jam Pulang)
        // Buat objek Carbon jam_pulang berdasarkan tanggal hari ini
        $jamPulangCarbon = Carbon::createFromFormat('H:i:s', $shift->jam_pulang, 'Asia/Jakarta');
        
        // Jika shift malam dan saat ini kita ada di sebelum tengah malam (misal jam 23:50), 
        // berarti jam_pulang (misal 00:42) berada di keesokan harinya (+1 hari)
        if ($shift->jam_masuk > $shift->jam_pulang && $jamSekarang >= $shift->jam_masuk) {
            $jamPulangCarbon->addDay();
        }

        // Hitung batas awal boleh pulang (Kurangi 15 menit)
        $batasAwalPulang = $jamPulangCarbon->copy()->subMinutes(15);

        // Karyawan boleh pulang jika waktu saat ini sudah melewati/sama dengan $batasAwalPulang
        $isBolehPulang = $sekarang->greaterThanOrEqualTo($batasAwalPulang);

        return view('Karyawan.absensi', [
            'karyawan' => $karyawan->load('shift'), 
            'shift' => $shift, 
            'absensiHariIni' => $absensiHariIni, 
            'isDalamJamShift' => $isDalamJamShift,
            'isBolehPulang' => $isBolehPulang // Pass variabel baru ke view
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

        $daftarShift = Shift::latest()->get();

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
            'tahun',
            'daftarShift'
        ));
    }

    public function ubahShiftMandiri(Request $request)
    {
        // 1. Validasi Input ID Shift
        $validate = $request->validate([
            'shift_id' => 'required|exists:shifts,id', // Pastikan nama tabel database Anda adalah 'shifts'
        ], [
            'shift_id.required' => 'Gagal! Anda wajib memilih salah satu shift yang tersedia.',
            'shift_id.exists'   => 'Gagal! Pilihan shift kerja tidak valid atau tidak terdaftar.',
        ]);

        $karyawan = Auth::guard('employee')->user();
        $hariIni = Carbon::today('Asia/Jakarta')->toDateString();

        // 2. ATURAN BLOKIR GANDA: Cek apakah hari ini sudah melakukan absensi (Masuk/Izin)
        $sudahAbsenHariIni = Presence::where('employee_id', $karyawan->id)
            ->where('tanggal', $hariIni)
            ->exists();

        if ($sudahAbsenHariIni) {
            return redirect()->back()->with('error', 'Perubahan Ditolak! Anda tidak diperbolehkan mengganti shift karena telah melakukan presensi atau mengajukan izin hari ini.');
        }

        // 3. Cek apakah shift yang dipilih sama dengan shift yang aktif sekarang
        if ($karyawan->shift_id == $validate['shift_id']) {
            return redirect()->back()->with('error', 'Jadwal shift yang Anda pilih masih sama dengan shift aktif saat ini.');
        }

        // 4. Eksekusi Perubahan Data ke Tabel Karyawan (Employees)
        // Menggunakan query langsung ke model User Karyawan yang sedang login
        $karyawan->update([
            'shift_id' => $validate['shift_id']
        ]);

        // Ambil nama shift baru untuk kebutuhan teks notifikasi sukses
        $shiftBaru = Shift::find($validate['shift_id']);

        return redirect()->back()->with('success', 'Jadwal kerja berhasil diperbarui! Shift aktif Anda sekarang: ' . $shiftBaru->nama_shift . ' 💾');
    }
    
}
