@extends("Admin.Layouts.main")

@section("title", "Data Karyawan")

@section("content")
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900">Kru Macawa Coffee</h2>
            <p class="mt-0.5 text-xs font-medium text-slate-400">Daftar staf, barista, dan hak akses penugasan shift kerja.
            </p>
        </div>
        <label for="modal-add-karyawan"
            class="btn bg-macawa-red rounded-xl border-none text-xs font-bold normal-case text-white hover:bg-red-700">
            + Registrasi Karyawan
        </label>
    </div>

    <!-- Table Data Karyawan -->
    <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="table w-full text-slate-700">
                <thead
                    class="border-b border-slate-100 bg-slate-50/70 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Posisi / Peran</th>
                        <th class="px-6 py-4">Shift Penugasan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($karyawans ?? [] as $karyawan)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $karyawan->nama }}</div>
                                <div class="text-[10px] font-medium text-slate-400">{{ $karyawan->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-600">{{ $karyawan->posisi }}</td>
                            <td class="px-6 py-4 text-xs"><span
                                    class="badge badge-ghost rounded-lg font-semibold text-slate-600">{{ $karyawan->shift->nama_shift }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button
                                    class="btn btn-ghost btn-xs text-macawa-red font-bold normal-case">Keluarkan</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-xs font-medium text-slate-400">
                                Tidak ada staf terdaftar saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form Karyawan -->
    <input type="checkbox" id="modal-add-karyawan" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box max-w-sm rounded-2xl bg-white p-6">
            <h3 class="text-base font-bold text-slate-900">Registrasi Anggota Kru Baru</h3>
            <form action="#" method="POST" class="mt-4 space-y-4">
                @csrf
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Nama lengkap karyawan"
                        class="input input-bordered focus:outline-macawa-red w-full rounded-xl text-xs" required />
                </div>
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Jabatan Posisi</label>
                    <select name="posisi" class="select select-bordered focus:outline-macawa-red w-full rounded-xl text-xs"
                        required>
                        <option value="Barista">Barista</option>
                        <option value="Kitchen Staff">Kitchen Staff</option>
                        <option value="Cashier">Cashier</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Alokasi Shift Utama</label>
                    <select name="shift_id"
                        class="select select-bordered focus:outline-macawa-red w-full rounded-xl text-xs" required>
                        <!-- Tautkan data shift dari database di sini -->
                        <option disabled selected>-- Pilih Jadwal Kerja --</option>
                    </select>
                </div>
                <div class="modal-action mt-6 gap-2">
                    <label for="modal-add-karyawan"
                        class="btn btn-ghost rounded-xl text-xs font-semibold normal-case">Batal</label>
                    <button type="submit"
                        class="btn bg-macawa-red rounded-xl border-none px-6 text-xs font-bold normal-case text-white hover:bg-red-700">Daftarkan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
