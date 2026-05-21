<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ShiftController;

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

Route::get('/dashboard', function () {
    return view('Admin.dashboard');
});

Route::resource('/shift', ShiftController::class);
Route::resource('/karyawan', EmployeeController::class);
Route::resource('/presensi', PresenceController::class);

Route::get('/test', function () {
    return view('welcome');
});
Route::get('/', [AbsensiController::class, 'index']);
Route::post('/absen/proses', [AbsensiController::class, 'proses']);
