@extends("Admin.Layouts.main")

@section("title", "Dashboard")

@section("content")
    <!-- Header Page -->
    <div>
        <h2 class="text-xl font-bold tracking-tight text-slate-900">Ringkasan Hari Ini</h2>
        <p class="mt-0.5 text-xs font-medium text-slate-400">Metrik operasional kehadiran kru Macawa Coffee.</p>
    </div>

    <!-- Stats Widgets -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        <div class="flex items-center justify-between rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Karyawan</p>
                <h3 class="mt-1 text-2xl font-black text-slate-800">{{ $totalKaryawan ?? 0 }}</h3>
            </div>
            <div class="text-macawa-red flex h-10 w-10 items-center justify-center rounded-xl bg-red-50">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
        </div>

        <div class="flex items-center justify-between rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Hadir</p>
                <h3 class="mt-1 text-2xl font-black text-emerald-600">{{ $totalHadir ?? 0 }}</h3>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <div class="flex items-center justify-between rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Terlambat</p>
                <h3 class="mt-1 text-2xl font-black text-amber-500">{{ $totalTerlambat ?? 0 }}</h3>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <div class="flex items-center justify-between rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Absen / Izin</p>
                <h3 class="mt-1 text-2xl font-black text-slate-400">{{ $totalAbsen ?? 0 }}</h3>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>
@endsection
