<!DOCTYPE html>
<html lang="id" class="bg-slate-100/70">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Sistem - Macawa Coffee</title>
    <!-- Masukkan Tailwind CSS & DaisyUI v5 Anda di sini -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-8 selection:bg-red-100 selection:text-macawa-red bg-slate-100/70">

    <!-- CONTAINER UTAMA SPLIT SCREEN -->
    <div
        class="w-full max-w-4xl bg-slate-55 rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-slate-200/60 overflow-hidden grid grid-cols-1 md:grid-cols-2 min-h-[580px]">

        <!-- SISI KIRI: VISUAL BANNER COFFEE THEME (Tersembunyi di HP) -->
        <div
            class="hidden md:flex flex-col justify-between p-10 bg-gradient-to-br from-amber-950 to-slate-950 text-white relative overflow-hidden">
            <!-- Pola Dekoratif Halus -->
            <div
                class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]">
            </div>

            <!-- 🌟 LOGO KIRI: Diberi Kotak Putih Solid agar Logo Hitam PNG Anda Menyala Kontras -->
            <div class="flex flex-col items-start gap-4 relative z-10">
                <div
                    class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center border border-slate-200 p-2.5 shadow-md">
                    <img src="{{ asset('Img/logo_macawa.png') }}" alt="Logo Macawa Coffee"
                        class="w-full h-full object-contain">
                </div>
                <div class="space-y-0.5">
                    <span class="text-[10px] font-black tracking-widest uppercase text-amber-400/90 block">Workspace
                        System</span>
                    <span class="text-sm font-extrabold tracking-tight opacity-90 block">Macawa Coffee</span>
                </div>
            </div>

            <!-- Kutipan Tengah -->
            <div class="space-y-3.5 relative z-10 my-auto">
                <h1 class="text-3xl font-black leading-tight tracking-tight text-white">Seduh Semangat,<br>Catat
                    Kehadiran.</h1>
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

        <!-- SISI KANAN: FORM INTERAKTIF AUTH (SOFT OFF-WHITE - TIDAK SILAU) -->
        <div class="flex flex-col justify-center p-6 sm:p-10 bg-slate-55">

            <!-- Header Form -->
            <div class="mb-8 text-center lg:text-left flex flex-col items-center lg:items-start">

                <!-- 🌟 LOGO KANAN (RESPONSIF): Background Putih Bersih Menampilkan Logo Hitam PNG Dengan Jelas -->
                <div
                    class="lg:hidden inline-flex w-20 h-20 rounded-2xl bg-white border border-slate-200/80 items-center justify-center p-3.5 mb-5 shadow-sm">
                    <img src="{{ asset('Img/logo_macawa.png') }}" alt="Logo Macawa Coffee"
                        class="w-full h-full object-contain">
                </div>

                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Selamat Datang Kembali</h2>
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
                            class="input input-bordered bg-white text-slate-700 pl-9 rounded-xl font-semibold text-xs @error('email') border-red-500 @else border-slate-200 focus:border-slate-900 @enderror focus:outline-none w-full h-11 shadow-sm transition-all" />
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
                            class="input input-bordered bg-white text-slate-700 pl-9 rounded-xl font-semibold text-xs border-slate-200 focus:border-slate-900 w-full h-11 shadow-sm transition-all" />
                    </div>
                </div>

                <!-- TOMBOL MASUK UTAMA -->
                <div class="pt-2">
                    <button type="submit"
                        class="btn w-full bg-macawa-red hover:bg-red-700 border-none text-white font-black text-xs h-11 rounded-xl normal-case shadow-md shadow-red-100 transition-all duration-200">
                        Masuk Workspace ☕
                    </button>
                </div>
            </form>

            <!-- Teks Bantuan Khusus Karyawan -->
            {{-- <div class="mt-8 pt-4 border-t border-slate-200/60 text-center">
                <p class="text-[10px] font-medium text-slate-400 leading-relaxed">
                    Kendala hak akses atau lupa kata sandi? <br>Silakan hubungi <span
                        class="text-slate-700 font-bold">Manager / Admin IT Macawa Coffee</span> untuk reset data.
                </p>
            </div> --}}

        </div>
    </div>

</body>

</html>
