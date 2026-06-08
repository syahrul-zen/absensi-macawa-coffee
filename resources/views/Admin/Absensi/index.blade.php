@extends('Admin.Layouts.main')

@section('title', 'Dashboard Presensi Admin')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
        <div>
            <h2 class="text-xl font-black text-slate-800 tracking-tight">Log Presensi Karyawan</h2>
            <p class="text-xs font-medium text-slate-400">Pusat kendali dan pemantauan kehadiran kru Macawa Coffee secara
                real-time.</p>
        </div>

        <!-- Informasi Tanggal Hari Ini Aktif -->
        <div
            class="text-xs font-bold text-slate-600 bg-white border border-slate-200/80 rounded-xl px-4 py-3 shadow-sm h-fit">
            📅 Tanggal Operasional: <span
                class="text-red-600 font-black">{{ \Carbon\Carbon::parse($tanggalFilter)->translatedFormat('d F Y') }}</span>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 1. STATISTIK RINGKAS COUNTER (ATAS)        -->
    <!-- ========================================== -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Card Tepat Waktu -->
        <div
            class="bg-white p-4 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex items-center gap-4">
            <div
                class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold">
                ✔</div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tepat Waktu</span>
                <span class="text-lg font-black text-slate-800">{{ $presences->where('status', 'Tepat Waktu')->count() }}
                    <span class="text-xs font-medium text-slate-400">kru</span></span>
            </div>
        </div>

        <!-- Card Terlambat -->
        <div
            class="bg-white p-4 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-sm font-bold">⏰
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Terlambat</span>
                <span class="text-lg font-black text-slate-800">{{ $presences->where('status', 'Terlambat')->count() }}
                    <span class="text-xs font-medium text-slate-400">kru</span></span>
            </div>
        </div>

        <!-- Card Izin/Sakit -->
        <div
            class="bg-white p-4 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold">
                📄</div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Izin / Sakit</span>
                <span class="text-lg font-black text-slate-800">{{ $presences->where('status', 'Izin')->count() }} <span
                        class="text-xs font-medium text-slate-400">kru</span></span>
            </div>
        </div>

        <!-- Card Alpa -->
        <div
            class="bg-white p-4 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex items-center gap-4">
            <div
                class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center text-sm font-bold">
                ❌</div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Alpa (Absen)</span>
                <span class="text-lg font-black text-slate-800">{{ $presences->where('status', 'Alpa')->count() }} <span
                        class="text-xs font-medium text-slate-400">kru</span></span>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 2. KONTROL FILTER SAKTI BARIS UTAMA       -->
    <!-- ========================================== -->
    <!-- KONTROL FILTER SAKTI BARIS UTAMA (Perbarui Bagian Ini) -->
    <div class="flex justify-end gap-2 mb-4">

        @if (!auth()->guard('admin')->user()->is_admin)
            <!-- TOMBOL BARU: CETAK REKAP MODAL -->
            <button type="button" onclick="modal_cetak_laporan.showModal()"
                class="btn bg-slate-900 hover:bg-slate-950 border-none text-white font-bold text-xs rounded-xl px-4 h-10 shadow-sm normal-case flex items-center gap-2">
                🖨️ Cetak Rekap Karyawan
            </button>
        @endif

        <button type="button" onclick="toggleFilterDrawer()"
            class="btn bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold text-xs rounded-xl px-4 h-10 shadow-sm normal-case flex items-center gap-2">
            🎛️ Filter Saringan Data
        </button>

        <a href="{{ url('/presensi') }}"
            class="btn btn-ghost hover:bg-slate-100 text-slate-400 font-bold text-xs rounded-xl h-10 normal-case">
            Reset Hari Ini
        </a>
    </div>

    <!-- ========================================== -->
    <!-- MODAL PILIH RENTANG TANGGAL CETAK LAPORAN  -->
    <!-- ========================================== -->
    <dialog id="modal_cetak_laporan" class="modal backdrop:backdrop-blur-sm">
        <div class="modal-box max-w-md bg-white rounded-2xl p-6 shadow-2xl border border-slate-100">

            <div class="flex items-center gap-3 border-b border-slate-100 pb-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-sm font-bold">
                    🖨️</div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Cetak Rekap Presensi</h3>
                    <p class="text-xs font-semibold text-slate-400 mt-0.5">Tentukan rentang tanggal laporan rekap bulanan
                        global.</p>
                </div>
            </div>

            <!-- Form diarahkan ke route laporan dengan target="_blank" agar membuka di tab baru -->
            <form action="{{ url('/laporan') }}" method="GET" target="_blank" class="space-y-4">

                <!-- Tanggal Awal -->
                <div class="form-control">
                    <label class="label pt-0 pb-1.5"><span
                            class="label-text font-bold text-slate-500 text-[11px] uppercase tracking-wide">Tanggal
                            Awal</span></label>
                    <input type="date" name="tanggal_awal" required
                        value="{{ \Carbon\Carbon::now()->startOfMonth()->toDateString() }}"
                        class="input input-bordered bg-white text-slate-700 rounded-xl font-semibold text-xs border-slate-200 focus:outline-none focus:border-red-600 w-full h-10 shadow-sm" />
                </div>

                <!-- Tanggal Akhir -->
                <div class="form-control">
                    <label class="label pt-0 pb-1.5"><span
                            class="label-text font-bold text-slate-500 text-[11px] uppercase tracking-wide">Tanggal
                            Akhir</span></label>
                    <input type="date" name="tanggal_akhir" required value="{{ \Carbon\Carbon::now()->toDateString() }}"
                        class="input input-bordered bg-white text-slate-700 rounded-xl font-semibold text-xs border-slate-200 focus:outline-none focus:border-red-600 w-full h-10 shadow-sm" />
                </div>

                <!-- Tombol Aksi -->
                <div class="modal-action gap-2 pt-2">
                    <button type="button" onclick="modal_cetak_laporan.close()"
                        class="btn btn-ghost hover:bg-slate-100 text-slate-500 font-bold text-xs px-5 rounded-xl normal-case">
                        Batal
                    </button>
                    <button type="submit" onclick="modal_cetak_laporan.close()"
                        class="btn bg-red-600 hover:bg-red-700 border-none text-white font-bold text-xs px-6 rounded-xl normal-case shadow-md shadow-red-600/10">
                        Buka Lembar Cetak 🚀
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop bg-slate-900/40"><button>close</button></form>
    </dialog>

    <!-- PANEL LACI COLLAPSE FILTER -->
    <div id="filter-drawer" class="hidden transition-all duration-300 ease-in-out mb-5">
        <div class="card bg-slate-50/70 border border-slate-200/60 rounded-2xl p-5 shadow-inner">
            <form action="{{ url('/presensi') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">

                <div>
                    <label class="label pt-0 pb-1.5"><span
                            class="label-text font-bold text-slate-500 text-[11px] uppercase tracking-wide">Pilih
                            Tanggal</span></label>
                    <input type="date" name="tanggal" value="{{ $tanggalFilter }}"
                        class="input input-bordered bg-white text-slate-700 rounded-xl font-semibold text-xs border-slate-200 focus:outline-none focus:border-red-600 w-full h-10 shadow-sm" />
                </div>

                <div>
                    <label class="label pt-0 pb-1.5"><span
                            class="label-text font-bold text-slate-500 text-[11px] uppercase tracking-wide">Status
                            Kehadiran</span></label>
                    <select name="status"
                        class="select select-bordered bg-white text-slate-700 rounded-xl font-semibold text-xs border-slate-200 focus:outline-none focus:border-red-600 w-full h-10 shadow-sm">
                        <option value="">-- Semua Status --</option>
                        <option value="Tepat Waktu" {{ $statusFilter == 'Tepat Waktu' ? 'selected' : '' }}>Tepat Waktu
                        </option>
                        <option value="Terlambat" {{ $statusFilter == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                        <option value="Izin" {{ $statusFilter == 'Izin' ? 'selected' : '' }}>Izin / Sakit</option>
                        <option value="Alpa" {{ $statusFilter == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                    </select>
                </div>

                <div>
                    <label class="label pt-0 pb-1.5"><span
                            class="label-text font-bold text-slate-500 text-[11px] uppercase tracking-wide">Shift
                            Kerja</span></label>
                    <select name="shift"
                        class="select select-bordered bg-white text-slate-700 rounded-xl font-semibold text-xs border-slate-200 focus:outline-none focus:border-red-600 w-full h-10 shadow-sm">
                        <option value="">-- Semua Shift --</option>

                        @foreach ($shifts as $shift)
                            <option value="{{ $shift->id }}" @selected($shift->id == $shiftFilter)>{{ $shift->nama_shift }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="sm:col-span-3 flex justify-end mt-1">
                    <button type="submit"
                        class="btn bg-red-600 hover:bg-red-700 border-none text-white font-bold text-xs px-6 h-10 rounded-xl shadow-md shadow-red-600/10 normal-case">
                        🔍 Terapkan Saringan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 3. TABEL UTAMA LOG DATA PRESENSI           -->
    <!-- ========================================== -->
    <div class="card bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl border border-slate-100/60 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="table table-zebra text-xs text-slate-700">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-100 text-slate-500 font-bold">
                        <th class="py-3.5 px-4">Karyawan</th>
                        <th class="py-3.5">Presensi Masuk</th>
                        <th class="py-3.5">Presensi Pulang</th>
                        <th class="py-3.5">Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($presences as $p)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                            <!-- Profil Singkat -->
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div
                                            class="bg-red-600 text-white rounded-xl w-9 h-9 font-black flex items-center justify-center text-[11px]">
                                            {{ strtoupper(substr($p->employee->nama, 0, 2)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 block">{{ $p->employee->nama }}</span>
                                        <span
                                            class="text-[10px] text-slate-400 font-medium block mt-0.5">{{ $p->employee->jabatan }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Masuk -->
                            <td>
                                <span
                                    class="font-bold text-slate-800 block">{{ $p->jam_masuk_asli ? \Carbon\Carbon::parse($p->jam_masuk_asli)->format('H:i') : '--:--' }}</span>
                                @if ($p->jarak_masuk_meter !== null)
                                    <span class="text-[10px] text-slate-400 font-medium block mt-0.5">📍
                                        {{ round($p->jarak_masuk_meter) }} meter</span>
                                @endif
                            </td>

                            <!-- Pulang -->
                            <td>
                                <span
                                    class="font-bold text-slate-800 block">{{ $p->jam_pulang_asli ? \Carbon\Carbon::parse($p->jam_pulang_asli)->format('H:i') : '--:--' }}</span>
                                @if ($p->jarak_pulang_meter !== null)
                                    <span class="text-[10px] text-slate-400 font-medium block mt-0.5">📍
                                        {{ round($p->jarak_pulang_meter) }} meter</span>
                                @endif
                            </td>

                            <!-- Badge Pewarnaan Status -->
                            <td>
                                @if ($p->status == 'Tepat Waktu')
                                    <span
                                        class="badge bg-emerald-100 text-emerald-700 border-none font-bold text-[10px] px-2.5 py-1.5 rounded-md">TEPAT
                                        WAKTU</span>
                                @elseif($p->status == 'Terlambat')
                                    <span
                                        class="badge bg-red-100 text-red-600 border-none font-bold text-[10px] px-2.5 py-1.5 rounded-md">TERLAMBAT</span>
                                @elseif($p->status == 'Izin')
                                    <span
                                        class="badge bg-amber-100 text-amber-700 border-none font-bold text-[10px] px-2.5 py-1.5 rounded-md">IZIN
                                        / SAKIT</span>
                                @else
                                    <span
                                        class="badge bg-slate-100 text-slate-600 border-none font-bold text-[10px] px-2.5 py-1.5 rounded-md">ALPA</span>
                                @endif
                            </td>

                            <!-- Action Trigerer Modal -->
                            <td class="px-4 text-center">
                                <button type="button"
                                    onclick="bukaDetailPresensi({{ json_encode($p) }}, {{ json_encode($p->employee) }}, {{ json_encode($p->employee->shift) }})"
                                    class="btn btn-ghost hover:bg-slate-100 text-red-600 btn-xs rounded-xl font-bold normal-case">
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-slate-400 font-medium">Tidak ada rekaman data
                                presensi yang sesuai saringan filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 4. MODAL POP-UP DETAIL (DAISYUI 5 DIALOG)  -->
    <!-- ========================================== -->
    <dialog id="modal_detail_presensi" class="modal backdrop:backdrop-blur-sm">
        <div class="modal-box max-w-xl bg-white rounded-2xl p-6 shadow-2xl border border-slate-100">

            <!-- Header Profil Karyawan -->
            <div class="flex items-center gap-4 border-b border-slate-100 pb-4 mb-5">
                <div class="avatar placeholder">
                    <div class="bg-red-600 text-white rounded-2xl w-12 h-12 font-black text-sm flex items-center justify-center shadow-sm"
                        id="md-avatar">--</div>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight" id="md-nama">Nama</h3>
                    <p class="text-xs font-semibold text-slate-400 mt-0.5"><span id="md-jabatan">Jabatan</span> • <span
                            id="md-email">Email</span></p>
                </div>
            </div>

            <!-- Info Grid Masuk & Pulang -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                <!-- Box Masuk -->
                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Pencatatan
                        Masuk</span>
                    <div class="space-y-1.5 text-xs font-semibold">
                        <div class="flex justify-between"><span class="text-slate-400">Jam Masuk:</span><span
                                class="text-slate-800 font-bold" id="md-jam-masuk">00:00</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Status Hadir:</span><span
                                id="md-status-badge">--</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Jarak Lokasi:</span><span
                                class="text-slate-800 font-bold" id="md-jarak-masuk">0 m</span></div>
                    </div>
                </div>

                <!-- Box Pulang -->
                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Pencatatan
                        Pulang</span>
                    <div class="space-y-1.5 text-xs font-semibold">
                        <div class="flex justify-between"><span class="text-slate-400">Jam Pulang:</span><span
                                class="text-slate-800 font-bold" id="md-jam-pulang">00:00</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Jarak Lokasi:</span><span
                                class="text-slate-800 font-bold" id="md-jarak-pulang">0 m</span></div>
                    </div>
                </div>
            </div>

            <!-- Info Ketentuan Shift Kerja -->
            <div
                class="p-3.5 bg-red-50/50 rounded-xl border border-red-100/60 mb-5 text-xs font-semibold flex justify-between items-center">
                <div>
                    <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wide">Ketentuan Ketetapan
                        Shift</span>
                    <span class="text-slate-800 font-black block mt-0.5" id="md-nama-shift">Shift Kerja</span>
                </div>
                <div>
                    <span class="badge bg-red-600 text-white font-bold text-[11px] px-2.5 py-2 border-none rounded-lg"
                        id="md-jam-shift">00:00 - 00:00</span>
                </div>
            </div>

            <!-- Section Lampiran Berkas Izin (Muncul Jika Status == Izin) -->
            <div id="md-box-izin" class="hidden p-4 bg-amber-50/60 border border-amber-200/60 rounded-xl mb-5 text-xs">
                <span class="text-amber-800 font-bold uppercase text-[10px] tracking-wider block mb-1">Keterangan Dokumen
                    Surat Izin</span>
                <p class="text-slate-600 font-medium mb-3" id="md-keterangan-izin">Alasan...</p>
                <a href="#" id="md-link-file-izin" target="_blank"
                    class="btn btn-outline btn-warning btn-xs rounded-lg font-bold w-full normal-case">
                    📂 Buka Gambar Berkas Pendukung di Tab Baru
                </a>
            </div>

            <!-- Footer Tombol Action Modal -->
            <div class="modal-action mt-2">
                <button type="button" onclick="modal_detail_presensi.close()"
                    class="btn bg-slate-800 hover:bg-slate-900 border-none text-white font-bold text-xs px-6 rounded-xl normal-case">
                    Tutup Jendela Detail
                </button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop bg-slate-900/40"><button>close</button></form>
    </dialog>

    <!-- ========================================== -->
    <!-- SCRIPT JS INTERAKSI TAMPILAN               -->
    <!-- ========================================== -->
    <script>
        // 1. Fungsi Buka Tutup Laci Saringan Filter
        function toggleFilterDrawer() {
            const drawer = document.getElementById('filter-drawer');
            drawer.classList.toggle('hidden');
        }

        // Tetap buka laci filter jika URL mengandung saringan pencarian aktif
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('status') || urlParams.has('shift') || (urlParams.has('tanggal') && urlParams.get(
                    'tanggal') !== '{{ \Carbon\Carbon::today('Asia/Jakarta')->toDateString() }}')) {
                document.getElementById('filter-drawer').classList.remove('hidden');
            }
        });

        // 2. Fungsi Pengisi Data Masuk-Pulang ke Modal Dinamis
        function bukaDetailPresensi(presence, employee, shift) {
            document.getElementById('md-avatar').textContent = employee.nama.substring(0, 2).toUpperCase();
            document.getElementById('md-nama').textContent = employee.nama;
            document.getElementById('md-jabatan').textContent = employee.jabatan;
            document.getElementById('md-email').textContent = employee.email;

            document.getElementById('md-nama-shift').textContent = shift.nama_shift;
            document.getElementById('md-jam-shift').textContent =
                `${shift.jam_masuk.substring(0, 5)} - ${shift.jam_pulang.substring(0, 5)}`;

            document.getElementById('md-jam-masuk').textContent = presence.jam_masuk_asli ? presence.jam_masuk_asli
                .substring(0, 5) : '--:--';
            document.getElementById('md-jam-pulang').textContent = presence.jam_pulang_asli ? presence.jam_pulang_asli
                .substring(0, 5) : 'Belum Pulang';

            document.getElementById('md-jarak-masuk').textContent = presence.jarak_masuk_meter !== null ?
                `${Math.round(presence.jarak_masuk_meter)} meter` : '-';
            document.getElementById('md-jarak-pulang').textContent = presence.jarak_pulang_meter !== null ?
                `${Math.round(presence.jarak_pulang_meter)} meter` : '-';

            // Styling Badge Status di Dalam Modal
            const badgeElement = document.getElementById('md-status-badge');
            if (presence.status === 'Tepat Waktu') {
                badgeElement.className =
                    "badge bg-emerald-100 text-emerald-700 border-none font-bold text-[10px] rounded-md";
                badgeElement.textContent = "TEPAT WAKTU";
            } else if (presence.status === 'Terlambat') {
                badgeElement.className = "badge bg-red-100 text-red-600 border-none font-bold text-[10px] rounded-md";
                badgeElement.textContent = "TERLAMBAT";
            } else if (presence.status === 'Izin') {
                badgeElement.className = "badge bg-amber-100 text-amber-700 border-none font-bold text-[10px] rounded-md";
                badgeElement.textContent = "IZIN / SAKIT";
            } else {
                badgeElement.className = "badge bg-slate-100 text-slate-600 border-none font-bold text-[10px] rounded-md";
                badgeElement.textContent = "ALPA";
            }

            // Handle Penampilan Lampiran Khusus Izin
            const boxIzin = document.getElementById('md-box-izin');
            if (presence.status === 'Izin') {
                boxIzin.classList.remove('hidden');
                document.getElementById('md-keterangan-izin').textContent = presence.keterangan ||
                    'Tidak ada keterangan tertulis.';

                if (presence.file_izin) {
                    document.getElementById('md-link-file-izin').classList.remove('hidden');
                    document.getElementById('md-link-file-izin').href = `/File/${presence.file_izin}`;
                } else {
                    document.getElementById('md-link-file-izin').classList.add('hidden');
                }
            } else {
                boxIzin.classList.add('hidden');
            }

            modal_detail_presensi.showModal();
        }
    </script>
@endsection
