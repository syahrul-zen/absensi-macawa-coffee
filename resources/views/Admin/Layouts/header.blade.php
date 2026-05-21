<header class="sticky top-0 z-10 flex h-16 items-center justify-between border-b border-slate-100 bg-white px-8">
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
        <span>Kantin Utama</span>
        <span>/</span>
        <span class="font-bold text-slate-800">@yield("title")</span>
    </div>

    <div class="text-right">
        <div id="live-clock-digital" class="text-sm font-bold text-slate-800">00:00:00 AM</div>
        <div class="text-macawa-red text-[10px] font-bold uppercase tracking-wider">Kamis, 21 Mei 2026</div>
    </div>
</header>

@push("scripts")
    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('live-clock-digital').innerText = now.toLocaleTimeString('en-US', {
                hour12: true
            });
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
@endpush
