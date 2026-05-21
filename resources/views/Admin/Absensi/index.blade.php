@extends("Admin.Layouts.main")

@section("title", "Log Absensi")

@section("content")
    <div>
        <h2 class="text-xl font-bold tracking-tight text-slate-900">Histori Kehadiran Realtime</h2>
        <p class="mt-0.5 text-xs font-medium text-slate-400">Lembar riwayat pencatatan waktu masuk dan keluar seluruh staf.
        </p>
    </div>

    <!-- Table Logs -->
    <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="table w-full text-slate-700">
                <thead
                    class="border-b border-slate-100 bg-slate-50/70 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="px-6 py-4">Karyawan</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Jam Masuk</th>
                        <th class="px-6 py-4">Jam Pulang</th>
                        <th class="px-6 py-4">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($absensis ?? [] as $absen)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <td class="px-6 py-4 font-bold text-slate-900">{{ $absen->karyawan->nama }}</td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-500">{{ $absen->tanggal }}</td>
                            <td class="px-6 py-4 text-xs font-semibold">{{ $absen->jam_masuk ?? "-" }}</td>
                            <td class="px-6 py-4 text-xs font-semibold">{{ $absen->jam_pulang ?? "-" }}</td>
                            <td class="px-6 py-4">
                                @if ($absen->status == "Tepat Waktu")
                                    <span
                                        class="badge rounded-lg border-none bg-emerald-50 text-[10px] font-bold text-emerald-600">Tepat
                                        Waktu</span>
                                @else
                                    <span
                                        class="badge rounded-lg border-none bg-amber-50 text-[10px] font-bold text-amber-500">Terlambat</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-xs font-medium text-slate-400">
                                Belum ada aktivitas rekam absensi hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
