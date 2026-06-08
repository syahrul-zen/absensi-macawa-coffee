<!DOCTYPE html>
<html lang="id" class="bg-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Macawa Coffee</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="text-slate-800 antialiased">

    <!-- daisyUI 5 Struktur Drawer Responsif -->
    <div class="drawer lg:drawer-open min-h-screen">
        <input id="sidebar-drawer" type="checkbox" class="drawer-toggle" />

        <!-- SISI KANAN: AREA KONTEN UTAMA -->
        <div class="drawer-content flex flex-col bg-slate-50 min-h-screen">

            <!-- NAVBAR ATAS (Hanya muncul di HP / Tablet) -->
            <div class="navbar bg-white border-b border-slate-100 lg:hidden px-4 justify-between sticky top-0 z-40">
                <div class="flex-none">
                    <!-- Trigger Tombol Sidebar di HP -->
                    <label for="sidebar-drawer" class="btn btn-square btn-ghost drawer-button text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block w-5 h-5 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
                <div class="flex-1 px-2 mx-2 font-black text-red-600 tracking-wider text-sm">MACAWA COFFEE</div>
                <div class="flex-none">
                    <div class="avatar placeholder">
                        <div
                            class="bg-slate-100 text-slate-600 rounded-full w-8 h-8 flex items-center justify-center text-xs font-bold">
                            {{ strtoupper(substr('Bambang Pamungkas' ?? 'K', 0, 2)) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- AREA UTAMA INJECT BLADE VIEW -->
            <main class="flex-1 p-4 md:p-8 max-w-5xl w-full mx-auto">
                @yield('content')
            </main>

            <!-- FOOTER RINGKAS -->
            <footer class="p-4 bg-white border-t border-slate-100 text-center text-[11px] font-medium text-slate-400">
                &copy; 2026 Macawa Coffee. Built with Passion.
            </footer>
        </div>

        <!-- SISI KIRI: SIDEBAR NAVIGASI (Sesuai Aturan daisyUI 5) -->
        <div class="drawer-side z-50">
            <!-- Overlay penutup di versi 5 dipisah atau diklik di area luar -->
            <label for="sidebar-drawer" aria-label="close sidebar" class="drawer-overlay"></label>

            <!-- Konten Sidebar Menetap -->
            <div class="w-72 min-h-screen bg-white border-r border-slate-100 flex flex-col justify-between p-6">

                <!-- Navigasi Atas -->
                <div>
                    <!-- Brand Macawa Logo -->
                    <div class="mb-8 px-4 flex items-center gap-3">
                        <div
                            class="h-8 w-8 rounded-xl bg-red-600 flex items-center justify-center text-white font-black text-sm shadow-sm">
                            M</div>
                        <div>
                            <h2 class="text-sm font-black tracking-wider text-red-600 leading-none">MACAWA COFFEE</h2>
                            <span class="text-[10px] font-bold text-slate-400 tracking-wide">PORTAL KRU DECK</span>
                        </div>
                    </div>

                    <!-- Menu List -->
                    <p class="px-4 text-[10px] font-bold tracking-widest text-slate-400 uppercase mb-3">Menu Utama</p>
                    <ul class="space-y-1">
                        {{-- <li>
                            <a href="{{ url('/karyawan/dashboard') }}"
                                class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-xs font-bold transition-all {{ Request::is('karyawan/dashboard') ? 'bg-red-50 text-red-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                Dashboard
                            </a>
                        </li> --}}
                        <li>
                            <a href="{{ url('/home') }}"
                                class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-xs font-bold transition-all {{ Request::is('home') ? 'bg-red-50 text-red-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Absensi Hari Ini
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/riwayat-absensi') }}"
                                class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-xs font-bold transition-all {{ Request::is('riwayat-absensi') ? 'bg-red-50 text-red-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Riwayat Absensi
                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{ url('/karyawan/profil') }}"
                                class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-xs font-bold transition-all {{ Request::is('karyawan/profil') ? 'bg-red-50 text-red-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                Profil Saya
                            </a>
                        </li> --}}
                    </ul>
                </div>

                <!-- Bagian Informasi User & Tombol Keluar -->
                <div class="border-t border-slate-100 pt-4">
                    <div class="flex items-center gap-3 px-2 mb-4">
                        <div class="avatar placeholder">
                            <div
                                class="bg-red-600 text-white rounded-xl w-10 h-10 flex items-center justify-center text-xs font-black">
                                {{ strtoupper(substr('Bambang Pamungkas' ?? 'K', 0, 2)) }}
                            </div>
                        </div>
                        <div class="truncate">
                            <h4 class="text-xs font-bold text-slate-800 truncate">
                                {{ 'Bambang Pamungkas' ?? 'Nama Karyawan' }}</h4>
                            <span
                                class="text-[10px] font-semibold text-slate-400 block mt-0.5">{{ Auth::guard('employee')->user()->jabatan ?? 'Staf' }}</span>
                        </div>
                    </div>

                    <form action="{{ url('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-xs font-bold w-full text-red-500 hover:bg-red-50/60 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                            Keluar Akun
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
