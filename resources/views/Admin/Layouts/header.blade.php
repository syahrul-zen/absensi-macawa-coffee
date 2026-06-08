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
            @yield('title', 'Dashboard')
        </div>
    </div>

    <!-- Sisi Kanan Jam & Info -->
    <div class="text-right">
        <div id="live-clock-digital" class="text-sm font-bold text-slate-800">00:00:00 AM</div>
        <div class="text-macawa-red text-[10px] font-bold uppercase tracking-wider">Macawa Coffee</div>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function perbaruiJam() {
            const elemenJam = document.getElementById('live-clock-digital');
            if (!elemenJam) return;

            const sekarang = new Date();

            // Mengambil jam, menit, dan detik
            let jam = sekarang.getHours();
            let menit = sekarang.getMinutes();
            let detik = sekarang.getSeconds();

            // Menentukan format AM atau PM
            const ampm = jam >= 12 ? 'PM' : 'AM';

            // Mengubah format dari 24 jam menjadi 12 jam
            jam = jam % 12;
            jam = jam ? jam : 12; // Jika jam '0', ubah menjadi '12'

            // Menambahkan angka 0 di depan jika angka satuan (contoh: 07, 09)
            jam = jam < 10 ? '0' + jam : jam;
            menit = menit < 10 ? '0' + menit : menit;
            detik = detik < 10 ? '0' + detik : detik;

            // Menggabungkan menjadi format teks penuh
            const waktuString = `${jam}:${menit}:${detik} ${ampm}`;

            // Render ke dalam komponen HTML
            elemenJam.textContent = waktuString;
        }

        // Jalankan fungsi pertama kali saat halaman dimuat
        perbaruiJam();

        // Perbarui jam otomatis setiap 1 detik (1000 milidetik)
        setInterval(perbaruiJam, 1000);
    });
</script>
