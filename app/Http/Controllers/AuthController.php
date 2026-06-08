<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index() {

        if (Auth::guard('admin')->check() || Auth::guard('employee')->check()) {
            return redirect('/');
        }

        return view('login');
    }

    public function login(Request $request)
    {

        // 1. Validasi Input
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Alamat email kedai wajib diisi.',
            'email.email'    => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi akun wajib diisi.',
        ]);

        $remember = $request->filled('remember');

        // 2. Percobaan Pertama: Login sebagai Admin
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        // 3. Percobaan Kedua: Login sebagai Karyawan (Employee)
        if (Auth::guard('employee')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        // 4. Jika Kedua Guard Gagal, Kembalikan Error
        throw ValidationException::withMessages([
            'email' => ['Kredensial akun yang Anda masukkan tidak cocok dengan data kami.'],
        ]);
    }

    public function logout(Request $request)
    {
        // Logout dari guard yang sedang aktif
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('employee')->check()) {
            Auth::guard('employee')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
