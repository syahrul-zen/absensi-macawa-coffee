<!DOCTYPE html>
<html lang="id" class="bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Sistem - Macawa Coffee</title>
    <!-- Masukkan Tailwind CSS & DaisyUI v5 Anda di sini -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-8 selection:bg-red-100 selection:text-macawa-red">

    <!-- CONTAINER UTAMA SPLIT SCREEN -->
    <div
        class="w-full max-w-4xl bg-white rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden grid grid-cols-1 md:grid-cols-2 min-h-[550px]">

        <!-- SISI KIRI: VISUAL BANNER COFFEE THEME (Tersembunyi di HP) -->
        <div
            class="hidden md:flex flex-col justify-between p-8 bg-gradient-to-br from-amber-950 to-slate-950 text-white relative overflow-hidden">
            <!-- Pola Dekoratif Halus -->
            <div
                class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]">
            </div>

            <!-- Logo atas -->
            <div class="flex items-center gap-2 relative z-10">
                <div
                    class="w-7 h-7 rounded-lg bg-white/10 backdrop-blur-md flex items-center justify-center text-xs font-black border border-white/20">
                    M</div>
                <span class="text-xs font-bold tracking-wider uppercase opacity-80">Macawa Coffee Workspace</span>
            </div>

            <!-- Kutipan Tengah -->
            <div class="space-y-3 relative z-10 my-auto">
                <h1 class="text-2xl font-black leading-tight tracking-tight">Seduh Semangat, Catat Kehadiran.</h1>
                <p class="text-xs text-amber-200/70 font-medium leading-relaxed max-w-sm">
                    Silakan masuk untuk mengelola shift, meninjau jurnal presensi harian, dan memantau performa kedai
                    Anda.
                </p>
            </div>

            <!-- Footer Bawah -->
            <div class="text-[10px] font-semibold text-white/40 relative z-10">
                &copy; {{ date('Y') }} Macawa Coffee. All Rights Reserved.
            </div>
        </div>

        <!-- SISI KANAN: FORM INTERAKTIF AUTH -->
        <div class="flex flex-col justify-center p-6 sm:p-10 bg-white">

            <!-- Header Form -->
            <div class="mb-6 text-center md:text-left">
                <div
                    class="md:hidden inline-flex w-10 h-10 rounded-xl bg-red-50 text-macawa-red items-center justify-center text-sm font-black mb-3">
                    M</div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Selamat Datang Kembali</h2>
                <p class="text-xs font-semibold text-slate-400 mt-1">Masukkan email kerja Anda untuk mengakses
                    dashboard.</p>
            </div>

            <!-- Form Aksi -->
            <form action="{{ url('/login') }}" method="POST" class="space-y-4">
                @csrf

                <!-- INPUT EMAIL -->
                <div class="form-control w-full flex flex-col items-start">
                    <label class="label pt-0 pb-1.5 justify-start">
                        <span class="label-text font-bold text-slate-500 text-[11px] uppercase tracking-wide">Alamat
                            Email Kerja</span>
                    </label>

                    <div class="relative flex items-center w-full">
                        <span class="absolute left-3.5 text-slate-400 text-xs">✉️</span>
                        <input type="email" name="email" required value="{{ old('email') }}"
                            placeholder="nama@macawacoffee.com"
                            class="input input-bordered bg-white text-slate-700 pl-9 rounded-xl font-semibold text-xs @error('email') border-red-500 @else border-slate-200 @enderror focus:outline-none focus:border-slate-900 w-full h-10.5 shadow-sm transition-all" />
                    </div>

                    @error('email')
                        <div class="block w-full text-left pt-1.5 px-0.5 clear-both">
                            <span class="text-[10px] font-bold text-red-600 block text-left">
                                ⚠️ {{ $message }}
                            </span>
                        </div>
                    @enderror
                </div>

                <!-- INPUT PASSWORD -->
                <div class="form-control">
                    <label class="label pt-0 pb-1.5 flex justify-between items-center">
                        <span class="label-text font-bold text-slate-500 text-[11px] uppercase tracking-wide">Kata Sandi
                            Akun</span>
                    </label>
                    <div class="relative flex items-center">
                        <span class="absolute left-3.5 text-slate-400 text-xs">🔒</span>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="input input-bordered bg-white text-slate-700 pl-9 rounded-xl font-semibold text-xs @error('email') border-red-500 @else border-slate-200 @enderror focus:outline-none focus:border-slate-900 w-full h-10.5 shadow-sm transition-all" />
                    </div>
                </div>

                <!-- REMEMBER ME -->
                {{-- <div class="flex items-center justify-between pt-0.5">
                    <label class="label cursor-pointer justify-start gap-2 p-0">
                        <input type="checkbox" name="remember"
                            class="checkbox checkbox-xs rounded-md bg-white border-slate-300 checked:bg-slate-900 checked:text-white" />
                        <span class="label-text text-[11px] font-bold text-slate-500">Ingat Akun Saya</span>
                    </label>
                </div> --}}

                <!-- TOMBOL MASUK UTAMA -->
                <div class="pt-2">
                    <button type="submit"
                        class="btn w-full bg-macawa-red hover:bg-red-700 border-none text-white font-black text-xs h-10.5 rounded-xl normal-case shadow-md shadow-red-100 transition-all duration-200">
                        Masuk Workspace ☕
                    </button>
                </div>
            </form>

            <!-- Teks Bantuan Khusus Karyawan -->
            <div class="mt-8 pt-4 border-t border-slate-50 text-center">
                <p class="text-[10px] font-medium text-slate-400 leading-relaxed">
                    Kendala hak akses atau lupa kata sandi? <br>Silakan hubungi **Manager / Admin IT Macawa Coffee**
                    untuk reset data.
                </p>
            </div>

        </div>
    </div>

</body>

</html>
