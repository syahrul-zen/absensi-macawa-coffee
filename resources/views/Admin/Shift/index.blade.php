@extends("Admin.Layouts.main")

@section("title", "Kelola Shift")

@section("content")
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900">Pengaturan Jam Kerja</h2>
            <p class="mt-0.5 text-xs font-medium text-slate-400">Kelola batasan waktu kerja operasional café.</p>
        </div>
        <!-- DaisyUI Modal Trigger Button -->
        <label for="modal-add-shift"
            class="btn bg-macawa-red rounded-xl border-none text-xs font-bold normal-case text-white hover:bg-red-700">
            + Tambah Shift Kerja
        </label>
    </div>

    <!-- Table Container -->
    <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="table w-full text-slate-700">
                <thead
                    class="border-b border-slate-100 bg-slate-50/70 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="px-6 py-4">Nama Shift</th>
                        <th class="px-6 py-4">Jam Masuk</th>
                        <th class="px-6 py-4">Jam Pulang</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($shifts ?? [] as $shift)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $shift->nama_shift }}</td>
                            <td class="px-6 py-4 text-xs font-medium">{{ $shift->jam_masuk }}</td>
                            <td class="px-6 py-4 text-xs font-medium">{{ $shift->jam_pulang }}</td>
                            <td class="px-6 py-4 text-center">
                                <button class="btn btn-ghost btn-xs text-macawa-red font-bold normal-case">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-xs font-medium text-slate-400">
                                Belum ada data shift kerja. Tambahkan shift baru untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- DaisyUI Modal Component Layout -->
    <input type="checkbox" id="modal-add-shift" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box max-w-sm rounded-2xl bg-white p-6">
            <h3 class="text-base font-bold text-slate-900">Buat Jam Shift Baru</h3>
            <form action="#" method="POST" class="mt-4 space-y-4">
                @csrf
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Nama Shift</label>
                    <input type="text" name="nama_shift" placeholder="Contoh: Shift Pagi / Barista"
                        class="input input-bordered focus:outline-macawa-red w-full rounded-xl text-xs" required />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="form-control">
                        <label class="label-text mb-1 text-xs font-bold text-slate-500">Jam Masuk</label>
                        <input type="time" name="jam_masuk"
                            class="input input-bordered focus:outline-macawa-red w-full rounded-xl text-xs" required />
                    </div>
                    <div class="form-control">
                        <label class="label-text mb-1 text-xs font-bold text-slate-500">Jam Pulang</label>
                        <input type="time" name="jam_pulang"
                            class="input input-bordered focus:outline-macawa-red w-full rounded-xl text-xs" required />
                    </div>
                </div>
                <div class="modal-action mt-6 gap-2">
                    <label for="modal-add-shift"
                        class="btn btn-ghost rounded-xl text-xs font-semibold normal-case">Batal</label>
                    <button type="submit"
                        class="btn bg-macawa-red rounded-xl border-none px-6 text-xs font-bold normal-case text-white hover:bg-red-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
