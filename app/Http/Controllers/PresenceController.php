<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\Employee;
use App\Models\Shift;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Carbon\Carbon;


class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     return view('Admin.Absensi.index');
    // }

    public function index(Request $request)
    {
        // 1. Ambil filter dari request, default-nya adalah hari ini (WIB)
        $tanggalFilter = $request->get('tanggal', Carbon::today('Asia/Jakarta')->toDateString());
        $statusFilter = $request->get('status');
        $shiftFilter = $request->get('shift');

        $shifts = Shift::all();

        // 2. Query dasar absensi dengan eager loading ke employee dan shift
        $query = Presence::with(['employee.shift']);

        // 3. Jalankan sistem filter dinamis
        if ($tanggalFilter) {
            $query->where('tanggal', $tanggalFilter);
        }
        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }
        if ($shiftFilter) {
            $query->whereHas('employee', function($q) use ($shiftFilter) {
                $q->where('shift_id', $shiftFilter);
            });
        }

        $presences = $query->orderBy('jam_masuk_asli', 'desc')->get();

        // Ambil data master shift untuk list filter di view (Opsional jika ada model Shift)
        // $shifts = Shift::all(); 

        return view('Admin.Absensi.index', compact('presences', 'tanggalFilter', 'statusFilter', 'shiftFilter', 'shifts'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Presence $presence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presence $presence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presence $presence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presence $presence)
    {
        //
    }

    public function dashboard() {

        $hariIni = Carbon::today('Asia/Jakarta')->toDateString();

        // 1. HITUNG STATISTIK HARI INI
        $hadirHariIni      = Presence::where('tanggal', $hariIni)->where('status', 'Tepat Waktu')->count();
        $terlambatHariIni  = Presence::where('tanggal', $hariIni)->where('status', 'Terlambat')->count();
        $izinHariIni       = Presence::where('tanggal', $hariIni)->where('status', 'Izin')->count();

        // Hitung sisa karyawan untuk status dinamis "Belum Datang" hari ini
        $totalKaryawan     = \App\Models\Employee::count(); 
        $belumAbsenHariIni = $totalKaryawan - ($hadirHariIni + $terlambatHariIni + $izinHariIni);
        $belumAbsenHariIni = $belumAbsenHariIni < 0 ? 0 : $belumAbsenHariIni;

        // ========================================================
        // 2. OTOMATISASI DATA GRAFIK (TERPISAH ALPA & IZIN)
        // ========================================================
        $grafikLabels     = [];
        $grafikTepatWaktu = [];
        $grafikTerlambat  = [];
        $grafikIzin       = []; // Array baru khusus Izin
        $grafikAlpa       = []; // Array baru khusus Alpa

        for ($i = 6; $i >= 0; $i--) {
            $tanggalTarget = Carbon::today('Asia/Jakarta')->subDays($i);
            $grafikLabels[] = $tanggalTarget->isoFormat('dddd');
            $tanggalString = $tanggalTarget->toDateString();

            // Data Tepat Waktu & Terlambat (Tetap sama)
            $grafikTepatWaktu[] = Presence::where('tanggal', $tanggalString)->where('status', 'Tepat Waktu')->count();
            $grafikTerlambat[]  = Presence::where('tanggal', $tanggalString)->where('status', 'Terlambat')->count();
            
            // Data Izin (Hari ini maupun kemarin tinggal ambil dari DB)
            $grafikIzin[]       = Presence::where('tanggal', $tanggalString)->where('status', 'Izin')->count();

            // Data Alpa (Kondisional khusus Hari Ini vs Hari Kemarin)
            if ($tanggalString === $hariIni) {
                // Hari ini: Ambil dari sisa karyawan yang belum absen lewat rumus hitung manual
                $grafikAlpa[] = $belumAbsenHariIni;
            } else {
                // Hari kemarin: Ambil langsung dari hasil record Cron Job malam lalu
                $grafikAlpa[] = Presence::where('tanggal', $tanggalString)->where('status', 'Alpa')->count();
            }
        }

        return view('Admin.dashboard', compact(
            'hadirHariIni', 'terlambatHariIni', 'izinHariIni', 'belumAbsenHariIni',
            'grafikLabels', 'grafikTepatWaktu', 'grafikTerlambat', 'grafikIzin', 'grafikAlpa'
        ));
    
    }

    public function cetakLaporan(Request $request) {
        $tglAwal  = $request->get('tanggal_awal');
        $tglAkhir = $request->get('tanggal_akhir');

        // Tarik data agregasi count presensi karyawan
        $employees = Employee::withCount([
            'presence as total_tepat_waktu' => function ($query) use ($tglAwal, $tglAkhir) {
                $query->whereBetween('tanggal', [$tglAwal, $tglAkhir])
                      ->where('status', 'Tepat Waktu');
            },
            'presence as total_terlambat' => function ($query) use ($tglAwal, $tglAkhir) {
                $query->whereBetween('tanggal', [$tglAwal, $tglAkhir])
                      ->where('status', 'Terlambat');
            },
            'presence as total_izin' => function ($query) use ($tglAwal, $tglAkhir) {
                $query->whereBetween('tanggal', [$tglAwal, $tglAkhir])
                      ->where('status', 'Izin');
            },
            'presence as total_alpa' => function ($query) use ($tglAwal, $tglAkhir) {
                $query->whereBetween('tanggal', [$tglAwal, $tglAkhir])
                      ->where('status', 'Alpa');
            }
        ])->get();

        $periodeText = Carbon::parse($tglAwal)->translatedFormat('d F Y') . ' s/d ' . Carbon::parse($tglAkhir)->translatedFormat('d F Y');
        $tanggalCetak = Carbon::now('Asia/Jakarta')->translatedFormat('d F Y');

        // Buat data array untuk dilempar ke dalam view PDF
        $data = [
            'employees' => $employees,
            'periodeText' => $periodeText,
            'tanggalCetak' => $tanggalCetak
        ];

        $pdf = DomPDF::loadView('Admin.laporan', $data)
                    ->setPaper('a4', 'portrait');
                    
        return $pdf->stream('Laporan-Presensi-Macawa-' . $tglAwal . '-ke-' . $tglAkhir . '.pdf');
    }

}
