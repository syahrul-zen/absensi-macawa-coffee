<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\Cordiant;
use App\Models\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\File;

use Carbon\Carbon;

class AbsensiController extends Controller
{
    // Atribut :
    // private $kafeLat = -1.6163592044640247;
    private $kafeLat = -1.6127401062230906;

    private $kafeLon = 103.57861034160142;

    private $radiusMaksimal = 50; // Satuan meter

    public function index()
    {
        return view('absen');
    }

    public function proses(Request $request)
    {
        $validate = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Hitung ulang jarak di sisi backend untuk verifikasi lokasi :
        // 2. Hitung ulang jarak di sisi Backend untuk keamanan ganda
        // $jarak = $this->hitungJarakHaversine($validate['latitude'], $validate['longitude'], $this->kafeLat, $this->kafeLon);

        $kordinat = Cordiant::first();

        $jarak = $this->hitungJarakHaversine($validate['latitude'], $validate['longitude'], $kordinat->latitude, $kordinat->longitude);



        if ($jarak <= $this->radiusMaksimal) {
            return back()->with('success', 'Absen Berhasil! Jarak kamu '.round($jarak).' meter dari kafe.');
            // Di sini nantinya kamu bisa masukkan logika Insert ke Database
        } else {
            return back()->with('error', 'Absen Gagal! Kamu berada '.round($jarak).' meter di luar area kafe.');
        }
    }

    private function hitungJarakHaversine($lat1, $lon1, $lat2, $lon2)
    {

        $earthRadius = 6371000; // Jari-jari bumi

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // return hasil dalam meter.

    }

    // public function absenMasuk(Request $request)
    // {
    //     // 1. Validasi Input Koordinat dari Geolocation Browser
    //     $validate = $request->validate([
    //         'latitude' => 'required|numeric',
    //         'longitude' => 'required|numeric',
    //     ]);

    //     $karyawan = Auth::guard('employee')->user();

    //     $shift = $karyawan->shift;
    //     $hariIni = Carbon::today()->toDateString();
    //     $jamSekarang = Carbon::now('Asia/Jakarta');


    //     // 2. Validasi Ganda Kehadiran Hari Ini
    //     $adaAbsen = Presence::where('employee_id', $karyawan->id)->where('tanggal', $hariIni)->first();
    //     if ($adaAbsen) {
    //         return redirect()->back()->with('error', 'Anda sudah melakukan absensi hari ini.');
    //     }

    //     $kordinat = Cordiant::first();

    //     // 3. Verifikasi Lokasi GPS Radius dengan Haversine
    //     // $jarak = $this->hitungJarakHaversine($validate['latitude'], $validate['longitude'], $this->kafeLat, $this->kafeLon);
    //     $jarak = $this->hitungJarakHaversine($validate['latitude'], $validate['longitude'], $kordinat->latitude, $kordinat->longitude);

    //     if ($jarak > $this->radiusMaksimal) {
    //         return redirect()->back()->with('error', 'Absen Gagal! Anda berada ' . round($jarak) . ' meter di luar radius Macawa Coffee.');
    //     }


    //     // 4. Hitung Aturan Keterlambatan (Toleransi 15 Menit)
    //     $jamMasukShift = Carbon::createFromFormat('H:i:s', $shift->jam_masuk, 'Asia/Jakarta');

    //     $batasToleransi = $jamMasukShift->copy()->addMinutes(15);


    //     if ($jamSekarang->greaterThan($batasToleransi)) {
    //         $status = 'Terlambat';

    //     } else {
    //         $status = 'Tepat Waktu';
    //     }

    //     // 5. Insert ke Database
    //     Presence::create([
    //         'employee_id' => $karyawan->id,
    //         'tanggal' => $hariIni,
    //         'jam_masuk_asli' => $jamSekarang->toTimeString(),  
    //         'status' => $status, 
    //         'latitude_masuk' => $validate['latitude'],
    //         'longitude_masuk' => $validate['longitude'],
    //         'jarak_masuk_meter' => round($jarak),
    //     ]);

    //     return redirect()->back()->with('success', 'Absen masuk berhasil! Jarak Anda ' . round($jarak) . ' meter dari kafe. Status: ' . $status);
    // }

    public function absenMasuk(Request $request)
    {
        // 1. Validasi Input Koordinat & Data Gambar Base64
        $validate = $request->validate([
            'latitude'   => 'required|numeric',
            'longitude'  => 'required|numeric',
            'image_data' => 'required', // Wajib mengirimkan foto swafoto
        ], [
            'image_data.required' => 'Absen Gagal! Anda wajib mengambil foto swafoto terlebih dahulu.',
        ]);

        $karyawan = Auth::guard('employee')->user();
        $shift = $karyawan->shift;
        $hariIni = Carbon::today()->toDateString();
        $jamSekarang = Carbon::now('Asia/Jakarta');

        // 2. Validasi Ganda Kehadiran Hari Ini
        $adaAbsen = Presence::where('employee_id', $karyawan->id)->where('tanggal', $hariIni)->first();
        if ($adaAbsen) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi hari ini.');
        }

        $kordinat = Cordiant::first();

        // 3. Verifikasi Lokasi GPS Radius dengan Haversine
        $jarak = $this->hitungJarakHaversine($validate['latitude'], $validate['longitude'], $kordinat->latitude, $kordinat->longitude);

        if ($jarak > $this->radiusMaksimal) {
            return redirect()->back()->with('error', 'Absen Gagal! Anda berada ' . round($jarak) . ' meter di luar radius Macawa Coffee.');
        }

        // 4. Hitung Aturan Keterlambatan (Toleransi 15 Menit)
        $jamMasukShift = Carbon::createFromFormat('H:i:s', $shift->jam_masuk, 'Asia/Jakarta');
        $batasToleransi = $jamMasukShift->copy()->addMinutes(15);

        if ($jamSekarang->greaterThan($batasToleransi)) {
            $status = 'Terlambat';
        } else {
            $status = 'Tepat Waktu';
        }

        // --- PROSES DECODE DAN PENYIMPANAN FOTO MASUK ---
        $rawDataGambar = $request->input('image_data');
        
        // Bersihkan header Base64 bawaan browser
        $cleanDataGambar = str_replace('data:image/jpeg;base64,', '', $rawDataGambar);
        $cleanDataGambar = str_replace(' ', '+', $cleanDataGambar);
        
        // Ubah kembali string menjadi file biner gambar murni
        $fileBinerGambar = base64_decode($cleanDataGambar);
        
        // Bikin nama file unik (Contoh: masuk-karyawan1-20260619142500.jpg)
        $namaFileUnik = 'masuk-karyawan' . $karyawan->id . '-' . date('YmdHis') . '.jpg';
        
        // Tentukan folder tujuan di direktori public/uploads/absensi
        $targetPathFolder = public_path('uploads/absensi');
        
        // Buat folder otomatis menggunakan File facade jika belum ada
        if (!File::exists($targetPathFolder)) {
            File::makeDirectory($targetPathFolder, 0755, true);
        }
        
        // Tulis file gambar fisik ke dalam folder
        file_put_contents($targetPathFolder . '/' . $namaFileUnik, $fileBinerGambar);
        // ------------------------------------------------

        // 5. Insert ke Database (Termasuk Kolom Foto)
        Presence::create([
            'employee_id'       => $karyawan->id,
            'tanggal'           => $hariIni,
            'jam_masuk_asli'    => $jamSekarang->toTimeString(),  
            'status'            => $status, 
            'latitude_masuk'    => $validate['latitude'],
            'longitude_masuk'   => $validate['longitude'],
            'jarak_masuk_meter' => round($jarak),
            'foto_masuk'        => $namaFileUnik, // Sesuaikan nama kolom ini dengan nama di tabel migrasi Anda (misal: foto_masuk atau foto)
        ]);

        return redirect()->back()->with('success', 'Absen masuk berhasil! Jarak Anda ' . round($jarak) . ' meter dari kafe. Status: ' . $status);
    }


    // public function absenPulang(Request $request)
    // {
    //     // 1. Validasi input koordinat GPS saat pulang
    //     $validate = $request->validate([
    //         'latitude_pulang' => 'required|numeric',
    //         'longitude_pulang' => 'required|numeric',
    //     ]);

    //     $karyawan = Auth::guard('employee')->user();
    //     $shift = $karyawan->shift; // Mengambil data shift karyawan
    //     $hariIni = Carbon::today('Asia/Jakarta')->toDateString();
    //     $jamSekarang = Carbon::now('Asia/Jakarta');

    //     // 2. Cari data absen masuk milik karyawan hari ini
    //     $absensi = Presence::where('employee_id', $karyawan->id)
    //         ->where('tanggal', $hariIni)
    //         ->whereNull('jam_pulang_asli')
    //         ->first();

    //     if (!$absensi) {
    //         return redirect()->back()->with('error', 'Data absen masuk tidak ditemukan atau Anda sudah mencatat absen pulang hari ini.');
    //     }

    //     $kordinat = Cordiant::first();

    //     // 3. Verifikasi Lokasi GPS Radius dengan Haversine
    //     // $jarak = $this->hitungJarakHaversine($validate['latitude_pulang'], $validate['longitude_pulang'], $this->kafeLat, $this->kafeLon);
    //     $jarak = $this->hitungJarakHaversine($validate['latitude_pulang'], $validate['longitude_pulang'], $kordinat->latitude, $kordinat->longitude);


    //     if ($jarak > $this->radiusMaksimal) {
    //         return redirect()->back()->with('error', 'Absen Gagal! Anda berada ' . round($jarak) . ' meter di luar radius Macawa Coffee.');
    //     }


    //     // 3. ATURAN BLOKIR: Cek apakah waktu sekarang kurang dari 15 menit sebelum jam pulang shift
    //     $jamPulangShift = Carbon::createFromFormat('H:i:s', $shift->jam_pulang, 'Asia/Jakarta');
    //     $batasMinimalPulang = $jamPulangShift->copy()->subMinutes(15); // Jam pulang dikurangi 15 menit

    //     // Jika jam sekarang lebih awal (lessThan) dari batas minimal pulang, maka ditolak
    //     if ($jamSekarang->lessThan($batasMinimalPulang)) {
    //         $sisaMenit = $jamSekarang->diffInMinutes($batasMinimalPulang);
    //         return redirect()->back()->with('error', 'Absen Pulang Ditolak! Anda belum diperbolehkan pulang awal. Silakan tunggu ' . $sisaMenit . ' menit lagi.');
    //     }

    //     // 4. Jika lolos validasi waktu, update data ke database beserta koordinat GPS pulang
    //     $absensi->update([
    //         'jam_pulang_asli' => $jamSekarang->toTimeString(),
    //         'latitude_pulang' => $validate['latitude_pulang'],  // Sesuaikan dengan nama kolom DB Anda
    //         'longitude_pulang' => $validate['longitude_pulang'], // Sesuaikan dengan nama kolom DB Anda
    //         'jarak_pulang_meter' => round($jarak)
    //     ]);

    //     return redirect()->back()->with('success', 'Absen pulang berhasil dicatat pada ' . $jamSekarang->format('H:i') . '. Selamat beristirahat, terima kasih atas kerja kerasnya hari ini!');
    // }

    
    public function absenPulang(Request $request)
    {
        // 1. Validasi input koordinat GPS saat pulang & Data Gambar Base64
        $validate = $request->validate([
            'latitude_pulang'  => 'required|numeric',
            'longitude_pulang' => 'required|numeric',
            'image_data'       => 'required', // Wajib mengirimkan foto swafoto pulang
        ], [
            'image_data.required' => 'Absen Gagal! Anda wajib mengambil foto swafoto terlebih dahulu.',
        ]);

        $karyawan = Auth::guard('employee')->user();
        $shift = $karyawan->shift; // Mengambil data shift karyawan
        $hariIni = Carbon::today('Asia/Jakarta')->toDateString();
        $jamSekarang = Carbon::now('Asia/Jakarta');

        // 2. Cari data absen masuk milik karyawan hari ini
        $absensi = Presence::where('employee_id', $karyawan->id)
            ->where('tanggal', $hariIni)
            ->whereNull('jam_pulang_asli')
            ->first();

        if (!$absensi) {
            return redirect()->back()->with('error', 'Data absen masuk tidak ditemukan atau Anda sudah mencatat absen pulang hari ini.');
        }

        $kordinat = Cordiant::first();

        // 3. Verifikasi Lokasi GPS Radius dengan Haversine
        $jarak = $this->hitungJarakHaversine($validate['latitude_pulang'], $validate['longitude_pulang'], $kordinat->latitude, $kordinat->longitude);

        if ($jarak > $this->radiusMaksimal) {
            return redirect()->back()->with('error', 'Absen Gagal! Anda berada ' . round($jarak) . ' meter di luar radius Macawa Coffee.');
        }

        // 4. ATURAN BLOKIR: Cek apakah waktu sekarang kurang dari 15 menit sebelum jam pulang shift
        $jamPulangShift = Carbon::createFromFormat('H:i:s', $shift->jam_pulang, 'Asia/Jakarta');
        $batasMinimalPulang = $jamPulangShift->copy()->subMinutes(15); // Jam pulang dikurangi 15 menit

        // Jika jam sekarang lebih awal (lessThan) dari batas minimal pulang, maka ditolak
        if ($jamSekarang->lessThan($batasMinimalPulang)) {
            $sisaMenit = $jamSekarang->diffInMinutes($batasMinimalPulang);
            return redirect()->back()->with('error', 'Absen Pulang Ditolak! Anda belum diperbolehkan pulang awal. Silakan tunggu ' . $sisaMenit . ' menit lagi.');
        }

        // --- PROSES DECODE DAN PENYIMPANAN FOTO PULANG ---
        $rawDataGambar = $request->input('image_data');
        
        // Bersihkan header Base64 bawaan browser
        $cleanDataGambar = str_replace('data:image/jpeg;base64,', '', $rawDataGambar);
        $cleanDataGambar = str_replace(' ', '+', $cleanDataGambar);
        
        // Ubah kembali string menjadi file biner gambar murni
        $fileBinerGambar = base64_decode($cleanDataGambar);
        
        // Bikin nama file unik (Contoh: pulang-karyawan1-20260619143000.jpg)
        $namaFileUnik = 'pulang-karyawan' . $karyawan->id . '-' . date('YmdHis') . '.jpg';
        
        // Tentukan folder tujuan di direktori public/uploads/absensi
        $targetPathFolder = public_path('uploads/absensi');
        
        // Buat folder otomatis jika belum ada di server Anda
        if (!File::exists($targetPathFolder)) {
            File::makeDirectory($targetPathFolder, 0755, true);
        }
        
        // Tulis file gambar fisik ke dalam folder public tersebut
        file_put_contents($targetPathFolder . '/' . $namaFileUnik, $fileBinerGambar);
        // -------------------------------------------------

        // 5. Update data ke database beserta koordinat GPS dan nama file foto pulang
        $absensi->update([
            'jam_pulang_asli'    => $jamSekarang->toTimeString(),
            'latitude_pulang'    => $validate['latitude_pulang'],  
            'longitude_pulang'   => $validate['longitude_pulang'], 
            'jarak_pulang_meter' => round($jarak),
            'foto_pulang'        => $namaFileUnik, // Sesuaikan nama kolom ini dengan nama di tabel migrasi Anda (misal: foto_pulang)
        ]);

        return redirect()->back()->with('success', 'Absen pulang berhasil dicatat pada ' . $jamSekarang->format('H:i') . '. Selamat beristirahat, terima kasih atas kerja kerasnya hari ini!');
    }
    
    public function absenIzin(Request $request) {
        $validated = $request-> validate([
            'file_izin' => 'file|max:2100|nullable',
            'keterangan' => 'required|max:210'
        ]);

        $karyawan = Auth::guard('employee')->user();
        $hariIni = Carbon::today('Asia/Jakarta')->toDateString();

        $absensi = Presence::where('employee_id', $karyawan->id)
            ->where('tanggal', $hariIni)
            ->first();

        if ($request->file('file_izin')) {
            $file = $request->file('file_izin');
    
            $renameFile = time().'-'.$file->getClientOriginalName();
    
            $file->move(public_path('File'), $renameFile);
    
            $validated['file_izin'] = $renameFile;        
        }

        Presence::create([
            'employee_id' => $karyawan->id,
            'tanggal' => $hariIni,
            'file_izin' => $validated['file_izin'],
            'keterangan' => $validated['keterangan'],
            'status' => 'Izin'
        ]);

        return back()->with('success', 'Permohonan izin berhasil diajukan!');

    }

}
