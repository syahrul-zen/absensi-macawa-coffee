<div
    class="is-drawer-close:w-14 is-drawer-open:w-64 flex min-h-full flex-col items-start border-r border-slate-100 bg-white transition-all duration-300">
    <!-- Tempatkan LOGO Macawa Coffee Anda di sini -->
    <div class="w-full border-b border-slate-50 p-4 text-center font-bold">
        <span class="is-drawer-close:hidden">Macawa Coffee</span>
        <span class="is-drawer-open:hidden text-macawa-red">M</span>
    </div>

    <!-- Menu List -->
    <ul class="menu w-full grow space-y-1 p-2">
        <li>
            <a href="{{ url("/dashboard") }}"
                class="is-drawer-close:justify-center is-drawer-close:tooltip is-drawer-close:tooltip-right {{ request()->is("dashboard") ? "bg-red-50 text-macawa-red" : "text-slate-500 hover:bg-slate-50 hover:text-slate-800" }} flex items-center gap-3 rounded-xl"
                data-tip="Dashboard">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-5 text-slate-500">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span class="is-drawer-close:hidden font-medium">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="{{ url("/shift") }}"
                class="is-drawer-close:justify-center is-drawer-close:tooltip is-drawer-close:tooltip-right {{ request()->is("shift") ? "bg-red-50 text-macawa-red" : "text-slate-500 hover:bg-slate-50 hover:text-slate-800" }} flex items-center gap-3 rounded-xl"
                data-tip="Shift">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="is-drawer-close:hidden font-medium">Kelola Shift</span>
            </a>
        </li>

        <li>
            <a href="{{ url("/karyawan") }}"
                class="is-drawer-close:justify-center is-drawer-close:tooltip is-drawer-close:tooltip-right {{ request()->is("karyawan") ? "bg-red-50 text-macawa-red" : "text-slate-500 hover:bg-slate-50 hover:text-slate-800" }} flex items-center gap-3 rounded-xl"
                data-tip="Karyawan">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                <span class="is-drawer-close:hidden font-medium">Kelola karyawan</span>
            </a>
        </li>

        <li>
            <a href="{{ url("/presensi") }}"
                class="is-drawer-close:justify-center is-drawer-close:tooltip is-drawer-close:tooltip-right {{ request()->is("presensi") ? "bg-red-50 text-macawa-red" : "text-slate-500 hover:bg-slate-50 hover:text-slate-800" }} flex items-center gap-3 rounded-xl"
                data-tip="Presensi">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="is-drawer-close:hidden font-medium">Kelola presensi</span>
            </a>
        </li>

        <!-- Item menu lainnya pasangkan class is-drawer-close:hidden pada teksnya -->

    </ul>
</div>
