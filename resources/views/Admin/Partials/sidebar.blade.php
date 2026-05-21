<aside class="sticky top-0 flex h-screen w-64 shrink-0 flex-col justify-between border-r border-slate-100 bg-white">
    <div class="p-6">
        <!-- Logo Brand -->
        <div class="mb-8 flex items-center gap-3 px-2">
            <div
                class="bg-macawa-red flex h-9 w-9 items-center justify-center rounded-xl text-lg font-black text-white shadow-md shadow-red-200">
                M
            </div>
            <div>
                <h1 class="text-base font-bold leading-none tracking-tight text-slate-900">Macawa Coffee</h1>
                <span class="text-[10px] font-medium uppercase tracking-wider text-slate-400">Admin Panel</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="space-y-1">
            <a href="{{ url("dashboard") }}"
                class="{{ request()->is("dashboard") ? "bg-red-50 text-macawa-red" : "text-slate-500 hover:bg-slate-50 hover:text-slate-800" }} flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Dashboard
            </a>

            <a href="{{ url("/shift") }}"
                class="{{ request()->is("shift*") ? "bg-red-50 text-macawa-red" : "text-slate-500 hover:bg-slate-50 hover:text-slate-800" }} flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Kelola Shift
            </a>

            <a href="{{ url("karyawan") }}"
                class="{{ request()->is("karyawan*") ? "bg-red-50 text-macawa-red" : "text-slate-500 hover:bg-slate-50 hover:text-slate-800" }} flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                Data Karyawan
            </a>

            <a href="{{ url("presensi") }}"
                class="{{ request()->is("presensi") ? "bg-red-50 text-macawa-red" : "text-slate-500 hover:bg-slate-50 hover:text-slate-800" }} flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Log Absensi
            </a>
        </nav>
    </div>

    <!-- Admin Profile Footer Info -->
    <div class="flex items-center gap-3 border-t border-slate-100 bg-slate-50/50 p-4">
        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-200 text-sm font-bold text-slate-700">
            ADM
        </div>
        <div class="min-w-0 flex-1">
            <h4 class="truncate text-xs font-bold text-slate-800">Manager Macawa</h4>
            <p class="truncate text-[10px] font-medium text-slate-400">admin@macawacoffee.com</p>
        </div>
    </div>
</aside>
