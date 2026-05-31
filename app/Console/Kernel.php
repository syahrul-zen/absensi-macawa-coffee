<?php

namespace App\Console;

use App\Models\Presence;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Models\Employee;
use App\Models\Absensi;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function() {
            $hariIni = Carbon::today('Asia/Jakarta')->toDateString();
            
            // 1. Ambil semua karyawan yang hari ini tidak ada di tabel absensi
            // Asumsi: Di model Employee Anda memiliki relasi bernama 'absences' atau 'absensi'
            $karyawanBolos = Employee::whereDoesntHave('presence', function($query) use ($hariIni) {
                $query->where('tanggal', $hariIni);
            })->get();

            // 2. Masukkan mereka ke data absensi sebagai Alpa
            foreach ($karyawanBolos as $k) {
                Presence::create([
                    'employee_id'      => $k->id,
                    'tanggal'          => $hariIni,
                    'status'           => 'Alpa',
                    'keterangan'       => 'Tanpa keterangan (Sistem Otomatis)',
                    'jam_masuk_asli'   => null,
                    'jam_pulang_asli'  => null,
                ]);
            }
        })->dailyAt('23:50');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
