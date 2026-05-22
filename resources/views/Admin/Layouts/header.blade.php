<header class="sticky top-0 z-10 flex h-16 items-center justify-between border-b border-slate-100 bg-white px-4">
    <div class="flex items-center gap-2">
        <!-- Tombol pengubah ukuran sidebar (Untuk desktop maupun mobile) -->
        <label for="sidebar-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost btn-sm text-slate-600">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linejoin="round" stroke-linecap="round"
                stroke-width="2" fill="none" stroke="currentColor" class="size-5">
                <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                <path d="M9 4v16"></path>
                <path d="M14 10l2 2l-2 2"></path>
            </svg>
        </label>

        <div class="pl-2 text-sm font-semibold text-slate-800">
            @yield("title", "Dashboard")
        </div>
    </div>

    <!-- Sisi Kanan Jam & Info -->
    <div class="text-right">
        <div id="live-clock-digital" class="text-sm font-bold text-slate-800">00:00:00 AM</div>
        <div class="text-macawa-red text-[10px] font-bold uppercase tracking-wider">Macawa Coffee</div>
    </div>
</header>
