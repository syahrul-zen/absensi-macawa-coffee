@extends('Karyawan.Layouts.main') {{-- Sesuaikan dengan nama layout Anda --}}

@section('title', 'Riwayat Absensi')

@section('content')
    <div class="space-y-5 p-2 sm:p-0">

        <!-- HEADER HALAMAN -->
        <div>
            <h2 class="text-xl font-black text-slate-900 tracking-tight">Riwayat Absensi</h2>
            <p class="text-xs font-semibold text-slate-400 mt-0.5">Pantau rekam jejak kehadiran dan jam kerja Anda secara
                transparan.</p>
        </div>

        <!-- MAIN GRID LAYOUT -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <!-- ======================================================== -->
            <!-- SISI KIRI (70%): TABEL UTAMA DATA ABSENSI               -->
            <!-- ======================================================== -->
            <div
                class="lg:col-span-2 card bg-white border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.01)] rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">Jurnal Kehadiran</h3>
                    <span class="text-[11px] font-bold text-slate-400 bg-slate-50 px-2.5 py-1 rounded-lg">
                        📅 Periode: {{ Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
                    </span>
                </div>

                <!-- RESPONSIVE TABLE WRAPPER -->
                <div class="overflow-x-auto w-full rounded-xl border border-slate-100">
                    <table class="table table-sm w-full text-xs font-semibold text-slate-600 bg-white">

                        <!-- HEAD TABLE -->
                        <thead
                            class="bg-slate-50 text-slate-500 text-[10px] uppercase tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="py-3 pl-4">Hari & Tanggal</th>
                                <th class="py-3">Jam Masuk</th>
                                <th class="py-3">Jam Pulang</th>
                                <th class="py-3 text-center">Status</th>
                                <th class="py-3 pr-4">Keterangan</th>
                            </tr>
                        </thead>

                        <!-- BODY TABLE -->
                        <tbody class="divide-y divide-slate-50">
                            @forelse($riwayatAbsensi as $absen)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <!-- Tanggal -->
                                    <td class="py-3 pl-4 font-bold text-slate-800">
                                        {{ Carbon\Carbon::parse($absen->tanggal)->translatedFormat('l, d M Y') }}
                                    </td>

                                    <!-- Jam Masuk -->
                                    <td class="py-3">
                                        @if ($absen->jam_masuk_asli)
                                            <span
                                                class="{{ $absen->menit_terlambat > 0 ? 'text-red-600 font-bold' : 'text-slate-800' }}">
                                                {{ Carbon\Carbon::parse($absen->jam_masuk_asli)->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-slate-300">--:--</span>
                                        @endif
                                    </td>

                                    <!-- Jam Pulang -->
                                    <td class="py-3 text-slate-800">
                                        {{ $absen->jam_pulang_asli ? Carbon\Carbon::parse($absen->jam_pulang_asli)->format('H:i') : '--:--' }}
                                    </td>
                                    <td class="py-3 text-center">
                                        @if ($absen->status == 'Tepat Waktu')
                                            <span
                                                class="badge bg-emerald-50 border-none text-emerald-700 text-[10px] font-bold px-2 py-0 h-5 rounded-md">
                                                Tepat Waktu
                                            </span>
                                        @elseif ($absen->status == 'Terlambat')
                                            <span
                                                class="badge bg-red-50 border-none text-red-700 text-[10px] font-bold px-2 py-0 h-5 rounded-md">
                                                Terlambat
                                            </span>
                                        @elseif ($absen->status == 'Izin')
                                            <span
                                                class="badge bg-amber-50 border-none text-amber-700 text-[10px] font-bold px-2 py-0 h-5 rounded-md">
                                                Izin
                                            </span>
                                        @elseif ($absen->status == 'Alpa')
                                            <span
                                                class="badge bg-slate-100 border-none text-slate-600 text-[10px] font-bold px-2 py-0 h-5 rounded-md">
                                                Alpa
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-slate-50 border-none text-slate-400 text-[10px] font-bold px-2 py-0 h-5 rounded-md">
                                                {{ $absen->status ?? '--' }}
                                            </span>
                                        @endif
                                    </td>
                                    <!-- Keterangan / Shift -->
                                    <td class="py-3 pr-4 text-slate-400 text-[11px] max-w-[150px] truncate">
                                        {{ $absen->keterangan ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-slate-400 font-medium">
                                        🚫 Tidak ada data absensi pada periode bulan ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- SISI KANAN (30%): PANEL FILTER & STATISTIK BULANAN        -->
            <!-- ======================================================== -->
            <div class="space-y-4">

                <!-- PANEL FILTER BULAN -->
                <div class="card bg-white border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.01)] rounded-2xl p-5">

                    <!-- ======================================================== -->
                    <!-- NOTIFIKASI ALERT FEEDBACK (BARU)                          -->
                    <!-- ======================================================== -->
                    @if (session('success'))
                        <div
                            class="alert alert-success bg-emerald-50 border border-emerald-200 rounded-xl p-3 mb-3 flex items-start gap-2 shadow-sm animate-fade-in">
                            <span class="text-xs font-bold text-emerald-800 text-left block leading-relaxed">
                                🎉 {{ session('success') }}
                            </span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div
                            class="alert alert-error bg-red-50 border border-red-200 rounded-xl p-3 mb-3 flex items-start gap-2 shadow-sm">
                            <span class="text-xs font-bold text-red-800 text-left block leading-relaxed">
                                ⚠️ {{ session('error') }}
                            </span>
                        </div>
                    @endif

                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-3">Pilih Periode</h4>

                    <form action="" method="GET" class="space-y-3">
                        <div class="grid grid-cols-2 gap-2">
                            <!-- Dropdown Bulan -->
                            <select name="bulan"
                                class="select select-bordered select-sm bg-white text-slate-700 text-xs rounded-xl focus:outline-none border-slate-200 focus:border-slate-900 h-9">
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                        {{ Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Dropdown Tahun -->
                            <select name="tahun"
                                class="select select-bordered select-sm bg-white text-slate-700 text-xs rounded-xl focus:outline-none border-slate-200 focus:border-slate-900 h-9">
                                @php
                                    $y = Carbon\Carbon::now()->year;
                                @endphp
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                    {{ $y }}</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="btn btn-sm w-full bg-slate-900 hover:bg-slate-950 text-white font-bold text-xs rounded-xl h-9 border-none normal-case shadow-sm">
                            Filter Riwayat 🔍
                        </button>
                    </form>

                    <!-- Garis Pemisah Tipis -->
                    <div class="border-t border-dashed border-slate-100 my-3.5"></div>

                    <!-- Tombol Pemicu Modal Ganti Shift Mandiri (Baru) -->
                    <button type="button" onclick="modal_ganti_shift.showModal()"
                        class="btn btn-sm w-full bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-bold normal-case h-9 shadow-sm">
                        🔄 Ajukan / Ganti Shift Kerja
                    </button>
                </div>

                <!-- ======================================================== -->
                <!-- DIALOG MODAL: GANTI SHIFT MANDIRI KARYAWAN               -->
                <!-- ======================================================== -->
                <dialog id="modal_ganti_shift" class="modal backdrop-blur-sm">
                    <div class="modal-box bg-white max-w-sm rounded-2xl border border-slate-100 p-6 shadow-xl">

                        <!-- Header Modal -->
                        <div class="mb-4 text-left">
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider">Pilih Shift Kerja</h3>
                            <p class="text-[11px] font-semibold text-slate-400 mt-0.5">Sesuaikan jadwal penugasan shift
                                harian Anda di Macawa Coffee.</p>
                        </div>

                        <!-- Form Aksi Ganti Shift -->
                        <form action="{{ url('/ubah-shift-mandiri') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <!-- Menampilkan Shift Sekarang -->
                            <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl text-left">
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wide block">Shift Aktif
                                    Saat Ini:</span>
                                <span class="text-xs font-black text-slate-800 mt-0.5 block">
                                    {{ Auth::guard('employee')->user()->shift->nama_shift ?? 'Belum Ditentukan' }}
                                    <span class="text-slate-400 font-normal">
                                        ({{ substr(Auth::guard('employee')->user()->shift->jam_masuk ?? '', 0, 5) }} -
                                        {{ substr(Auth::guard('employee')->user()->shift->jam_pulang ?? '', 0, 5) }})
                                    </span>
                                </span>
                            </div>

                            <!-- Dropdown Pilihan Shift Baru -->
                            <div class="form-control w-full flex flex-col items-start">
                                <label class="label pt-0 pb-1.5 justify-start">
                                    <span
                                        class="label-text font-bold text-slate-500 text-[11px] uppercase tracking-wide">Pilih
                                        Shift Baru</span>
                                </label>

                                <select name="shift_id" required
                                    class="select select-bordered bg-white text-slate-700 rounded-xl font-semibold text-xs @error('shift_id') border-red-500 @else border-slate-200 @enderror focus:outline-none focus:border-slate-900 w-full h-10 shadow-sm">
                                    <option value="" disabled selected>-- Pilih Opsi Shift Tersedia --</option>
                                    @foreach ($daftarShift as $s)
                                        <option value="{{ $s->id }}"
                                            {{ (Auth::guard('employee')->user()->shift_id ?? '') == $s->id ? 'selected' : '' }}>
                                            {{ $s->nama_shift }} ({{ substr($s->jam_masuk, 0, 5) }} -
                                            {{ substr($s->jam_pulang, 0, 5) }})
                                        </option>
                                    @endforeach
                                </select>

                                @error('shift_id')
                                    <div class="block w-full text-left pt-1.5 px-0.5 clear-both">
                                        <span class="text-[10px] font-bold text-red-600 block text-left">⚠️
                                            {{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Tombol Konfirmasi -->
                            <div class="modal-action gap-2 pt-2 m-0 justify-end flex">
                                <button type="button" onclick="modal_ganti_shift.close()"
                                    class="btn btn-ghost hover:bg-slate-100 text-slate-500 font-bold text-xs px-5 rounded-xl normal-case h-9 min-h-0 border-none">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="btn bg-slate-900 hover:bg-slate-950 border-none text-white font-bold text-xs px-6 rounded-xl normal-case h-9 min-h-0 shadow-md">
                                    Simpan Jadwal 💾
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Klik di luar area modal untuk menutup otomatis -->
                    <form method="dialog" class="modal-backdrop bg-slate-950/20">
                        <button>close</button>
                    </form>
                </dialog>

                <!-- RAPOR BULANAN (STATISTIK RINGKAS) -->
                <div class="card bg-white border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.01)] rounded-2xl p-5">
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-4">Rapor Bulan Ini</h4>

                    <div class="space-y-3">
                        <!-- Stat Hadir -->
                        <div class="flex items-center justify-between p-2.5 bg-emerald-50/50 rounded-xl">
                            <span class="text-xs font-bold text-emerald-800">Total Hadir</span>
                            <span class="text-sm font-black text-emerald-700">{{ $totalHadir }}x</span>
                        </div>

                        <!-- Stat Terlambat (Akumulasi Menit) -->
                        {{-- <div class="flex items-center justify-between p-2.5 bg-red-50/50 rounded-xl">
                            <div>
                                <span class="text-xs font-bold text-red-800 block">Total Keterlambatan</span>
                                <span class="text-[10px] text-red-400 font-medium">Bulan berjalan</span>
                            </div>
                            <span class="text-sm font-black text-red-700">{{ $totalMenitTelat }} Menit</span>
                        </div> --}}

                        <!-- Stat Izin/Sakit -->
                        <div class="flex items-center justify-between p-2.5 bg-amber-50/50 rounded-xl">
                            <span class="text-xs font-bold text-amber-800">Izin / Sakit</span>
                            <span class="text-sm font-black text-amber-700">{{ $totalIzin }}x</span>
                        </div>

                        <!-- Stat Alpa -->
                        <div class="flex items-center justify-between p-2.5 bg-slate-100/70 rounded-xl">
                            <span class="text-xs font-bold text-slate-700">Alpa / Tanpa Keterangan</span>
                            <span class="text-sm font-black text-slate-800">{{ $totalAlpa }}x</span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
