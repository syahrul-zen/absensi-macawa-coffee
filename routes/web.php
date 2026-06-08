<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ShiftController;

use Carbon\Carbon;


use App\Models\Employee;
use App\Models\Presence;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/dashboard', function () {
//     return view('Admin.dashboard');
// });


Route::get('/', [PresenceController::class, 'dashboard'])->middleware('isAdmin');

Route::resource('/shift', ShiftController::class)->middleware('isAdmin')->except(['create', 'show', 'edit']);
Route::resource('/karyawan', EmployeeController::class)->middleware('isAdmin')->except(['create', 'show', 'edit']);
Route::resource('/presensi', PresenceController::class)->middleware('isAdmin')->except(['create', 'store', 'edit', 'update', 'destroy']);

// Route::get('/', [AbsensiController::class, 'index']);
Route::post('/absen/proses', [AbsensiController::class, 'proses'])->middleware('isAdmin');
Route::get('/laporan', [PresenceController::class, 'cetakLaporan'])->middleware('isAdmin');
Route::put('/set-admin', [EmployeeController::class, 'setAdmin'])->middleware('isAdmin');
Route::put('/set-owner', [EmployeeController::class, 'setOwner'])->middleware('isAdmin');

// ======================================================================

// Karyawan :
Route::get('/home', [EmployeeController::class, 'home'])->middleware('isEmployee');
Route::post('/absen-masuk', [AbsensiController::class, 'absenMasuk'])->middleware('isEmployee');
Route::post('/absen-pulang', [AbsensiController::class, 'absenPulang'])->middleware('isEmployee');
Route::post('/absen-izin', [AbsensiController::class, 'absenIzin'])->middleware('isEmployee');
Route::get('/riwayat-absensi', [EmployeeController::class, 'riwayat'])->middleware('isEmployee');

// =====================================================================

Route::get("/login", [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Route::get('/test', function() {
   
//     $hariIni = Carbon::today('Asia/Jakarta')->toDateString();

//     $karyawanBolos = Employee::whereDoesntHave('presence', function($query) use ($hariIni) {
//                 $query->where('tanggal', $hariIni);
//             })->get();

//     foreach ($karyawanBolos as $k) {
//                 Presence::create([
//                     'employee_id'      => $k->id,
//                     'tanggal'          => $hariIni,
//                     'status'           => 'Alpa',
//                     'keterangan'       => 'Tanpa keterangan (Sistem Otomatis)',
//                     'jam_masuk_asli'   => null,
//                     'jam_pulang_asli'  => null,
//                 ]);
//     }

//     return "berhasil";
// });