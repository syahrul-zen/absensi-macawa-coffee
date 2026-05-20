<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    // Atribut :
    private $kafeLat = -1.6163592044640247;

    private $kafeLon = 103.57786081791659;

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
        $jarak = $this->hitungJarakHaversine($validate['latitude'], $validate['longitude'], $this->kafeLat, $this->kafeLon);

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
}
