@extends("Admin.Layouts.main")

@section("title", "Data Karyawan")

@section("content")

    <div class="w-full space-y-4">
        @if (session("success"))
            <div role="alert"
                class="alert alert-success flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 stroke-emerald-600" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-emerald-800">Berhasil!</span>
                    <span class="text-[11px] font-medium text-emerald-600">{{ session("success") }}</span>
                </div>
            </div>
        @endif

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold tracking-tight text-slate-900">Kru Macawa Coffee</h2>
                <p class="mt-0.5 text-xs font-medium text-slate-400">Daftar staf, barista, dan hak akses penugasan shift
                    kerja.
                </p>
            </div>
            <label for="modal-add-karyawan"
                class="btn bg-macawa-red rounded-xl border-none text-xs font-bold normal-case text-white hover:bg-red-700">
                + Registrasi Karyawan
            </label>
        </div>

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
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($employees as $karyawan)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $karyawan->nama }}</div>
                                <div class="text-[10px] font-medium text-slate-400">{{ $karyawan->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-600">{{ $karyawan->jabatan }}</td>
                            <td class="px-6 py-4 text-xs"><span
                                    class="badge badge-ghost rounded-lg font-semibold text-slate-600">{{ $karyawan->shift->nama_shift }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-600">{{ $karyawan->email }}</td>

                            <td class="space-x-1 px-6 py-4 text-center">
                                <!-- TOMBOL EDIT BARU DENGAN DATA ATTRIBUTE -->
                                <button type="button"
                                    class="btn-edit-karyawan btn btn-ghost btn-xs font-bold normal-case text-yellow-500"
                                    data-id="{{ $karyawan->id }}" data-nama="{{ $karyawan->nama }}"
                                    data-email="{{ $karyawan->email }}" data-jabatan="{{ $karyawan->jabatan }}"
                                    data-shift="{{ $karyawan->shift_id }}">
                                    Edit
                                </button>

                                <button type="button"
                                    class="btn-delete-karyawan btn btn-ghost btn-xs text-macawa-red font-bold normal-case"
                                    data-id="{{ $karyawan->id }}" data-nama="{{ $karyawan->nama }}">
                                    Keluarkan
                                </button>
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

    <!-- Otomatis terbuka kembali jika validasi form registrasi gagal -->
    <input type="checkbox" id="modal-add-karyawan" class="modal-toggle" {{ $errors->any() ? "checked" : "" }} />

    <div class="modal">
        <div class="modal-box max-w-sm rounded-2xl bg-white p-6">
            <h3 class="text-base font-bold text-slate-900">Registrasi Anggota Kru Baru</h3>

            <!-- Sesuaikan action url menuju route store karyawan Anda -->
            <form action="{{ url("/karyawan") }}" method="POST" class="mt-4 space-y-4">
                @csrf

                <!-- Nama Lengkap -->
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old("nama") }}" placeholder="Nama lengkap karyawan"
                        class="input input-bordered focus:outline-macawa-red {{ $errors->has("nama") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs" />
                    @error("nama")
                        <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email (Akun Login Karyawan) -->
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Alamat Email</label>
                    <input type="email" name="email" value="{{ old("email") }}" placeholder="contoh@macawacoffee.com"
                        class="input input-bordered focus:outline-macawa-red {{ $errors->has("email") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs" />
                    @error("email")
                        <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Password Akun</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter"
                        class="input input-bordered focus:outline-macawa-red {{ $errors->has("password") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs" />
                    @error("password")
                        <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Jabatan Posisi -->
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Jabatan Posisi</label>
                    <select name="jabatan"
                        class="select select-bordered focus:outline-macawa-red {{ $errors->has("jabatan") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs">
                        <option value="" disabled {{ old("jabatan") ? "" : "selected" }}>-- Pilih jabatan --</option>
                        <option value="Barista" {{ old("jabatan") == "Barista" ? "selected" : "" }}>Barista</option>
                        <option value="Kitchen Staff" {{ old("jabatan") == "Kitchen Staff" ? "selected" : "" }}>Kitchen
                            Staff</option>
                        <option value="Cashier" {{ old("jabatan") == "Cashier" ? "selected" : "" }}>Cashier</option>
                    </select>
                    @error("jabatan")
                        <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Alokasi Shift Utama -->
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Alokasi Shift Utama</label>
                    <select name="shift_id"
                        class="select select-bordered focus:outline-macawa-red {{ $errors->has("shift_id") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs">
                        <option value="" disabled {{ old("shift_id") ? "" : "selected" }}>-- Pilih Jadwal Kerja --
                        </option>
                        @foreach ($shifts as $shift)
                            <option value="{{ $shift->id }}" {{ old("shift_id") == $shift->id ? "selected" : "" }}>
                                {{ $shift->nama_shift }}</option>
                        @endforeach
                    </select>
                    @error("shift_id")
                        <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                    @enderror
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

    <input type="checkbox" id="modal-edit-karyawan" class="modal-toggle"
        {{ $errors->any() && old("edit_id") ? "checked" : "" }} />

    <div class="modal">
        <div class="modal-box max-w-sm rounded-2xl bg-white p-6">
            <h3 class="text-base font-bold text-slate-900">Ubah Data Anggota Kru</h3>

            <form id="form-edit-karyawan" action="{{ url("/karyawan/" . (old("edit_id") ?? "")) }}" method="POST"
                class="mt-4 space-y-4">
                @csrf
                @method("PUT")

                <!-- Hidden Input untuk menandai ID karyawan yang diedit -->
                <input type="hidden" name="edit_id" id="edit-karyawan-id" value="{{ old("edit_id") }}">

                <!-- Nama Lengkap -->
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Nama Lengkap</label>
                    <input type="text" name="nama" id="edit-karyawan-nama" value="{{ old("nama") }}"
                        class="input input-bordered focus:outline-macawa-red {{ $errors->has("nama") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs"
                        required />
                    @error("nama")
                        <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Alamat Email</label>
                    <input type="email" name="email" id="edit-karyawan-email" value="{{ old("email") }}"
                        class="input input-bordered focus:outline-macawa-red {{ $errors->has("email") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs"
                        required />
                    @error("email")
                        <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password (Opsional saat Edit) -->
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Password Baru <span
                            class="text-[10px] font-normal text-slate-400">(Kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter jika ingin ganti"
                        class="input input-bordered focus:outline-macawa-red {{ $errors->has("password") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs" />
                    @error("password")
                        <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Jabatan Posisi -->
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Jabatan Posisi</label>
                    <select name="jabatan" id="edit-karyawan-posisi"
                        class="select select-bordered focus:outline-macawa-red {{ $errors->has("jabatan") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs"
                        required>
                        <option value="Barista" {{ old("jabatan") == "Barista" ? "selected" : "" }}>Barista</option>
                        <option value="Kitchen Staff" {{ old("jabatan") == "Kitchen Staff" ? "selected" : "" }}>Kitchen
                            Staff</option>
                        <option value="Cashier" {{ old("jabatan") == "Cashier" ? "selected" : "" }}>Cashier</option>
                    </select>
                    @error("jabatan")
                        <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Alokasi Shift -->
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Alokasi Shift Utama</label>
                    <select name="shift_id" id="edit-karyawan-shift"
                        class="select select-bordered focus:outline-macawa-red {{ $errors->has("shift_id") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs"
                        required>
                        @foreach ($shifts as $shift)
                            <option value="{{ $shift->id }}">{{ $shift->nama_shift }}</option>
                        @endforeach
                    </select>
                    @error("shift_id")
                        <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="modal-action mt-6 gap-2">
                    <label for="modal-edit-karyawan" id="btn-cancel-edit-karyawan"
                        class="btn btn-ghost rounded-xl text-xs font-semibold normal-case">Batal</label>
                    <button type="submit"
                        class="btn bg-macawa-red rounded-xl border-none px-6 text-xs font-bold normal-case text-white hover:bg-red-700">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <input type="checkbox" id="modal-delete-karyawan" class="modal-toggle" />

    <div class="modal">
        <div class="modal-box max-w-sm rounded-2xl bg-white p-6 text-center">
            <!-- Ikon Peringatan -->
            <div class="text-macawa-red mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-50">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>

            <h3 class="text-base font-bold text-slate-900">Keluarkan Anggota Kru?</h3>
            <p class="mt-2 text-xs leading-relaxed text-slate-500">
                Apakah Anda yakin ingin mengeluarkan <span id="delete-karyawan-nama"
                    class="font-bold text-slate-800"></span>? Semua riwayat absensi terkait karyawan ini akan tetap
                tersimpan namun akses login mereka akan dicabut.
            </p>

            <!-- Form Hapus -->
            <form id="form-delete-karyawan" action="" method="POST" class="mt-6 flex justify-end gap-2">
                @csrf
                @method("DELETE")

                <label for="modal-delete-karyawan"
                    class="btn btn-ghost rounded-xl text-xs font-semibold normal-case">Batal</label>
                <button type="submit"
                    class="btn bg-macawa-red rounded-xl border-none px-6 text-xs font-bold normal-case text-white hover:bg-red-700">Ya,
                    Keluarkan</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editModalToggle = document.getElementById("modal-edit-karyawan");
            const formEdit = document.getElementById("form-edit-karyawan");

            // Ambil elemen input modal
            const inputId = document.getElementById("edit-karyawan-id");
            const inputNama = document.getElementById("edit-karyawan-nama");
            const inputEmail = document.getElementById("edit-karyawan-email");
            const inputPosisi = document.getElementById("edit-karyawan-posisi");
            const inputShift = document.getElementById("edit-karyawan-shift");

            const baseUrlKaryawan = "{{ url("/karyawan") }}";

            // Tangkap klik tombol edit karyawan
            document.querySelectorAll(".btn-edit-karyawan").forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");
                    const nama = this.getAttribute("data-nama");
                    const email = this.getAttribute("data-email");
                    const posisi = this.getAttribute("data-jabatan");
                    const shiftId = this.getAttribute("data-shift");

                    // Pasang data ke form internal modal
                    inputId.value = id;
                    inputNama.value = nama;
                    inputEmail.value = email;
                    inputPosisi.value = posisi;
                    inputShift.value = shiftId;

                    // Manipulasi URL form action menuju endpoint /karyawan/{id}
                    formEdit.setAttribute("action", `${baseUrlKaryawan}/${id}`);

                    // Buka modal
                    editModalToggle.checked = true;
                });
            });

            // Letakkan di dalam DOMContentLoaded bersama dengan kode edit kemarin
            const deleteModalToggle = document.getElementById("modal-delete-karyawan");
            const formDelete = document.getElementById("form-delete-karyawan");
            const txtNamaKaryawan = document.getElementById("delete-karyawan-nama");

            const baseUrlDelete = "{{ url("/karyawan") }}";

            // Tangkap klik tombol keluarkan/hapus karyawan
            document.querySelectorAll(".btn-delete-karyawan").forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");
                    const nama = this.getAttribute("data-nama");

                    // Tampilkan nama karyawan di dalam teks konfirmasi modal
                    txtNamaKaryawan.textContent = nama;

                    // Manipulasi URL form action menuju endpoint /karyawan/{id} dengan method DELETE
                    formDelete.setAttribute("action", `${baseUrlDelete}/${id}`);

                    // Buka modal konfirmasi hapus
                    deleteModalToggle.checked = true;
                });
            });

            // Reset halaman jika batal saat ada error agar DOM kembali bersih
            document.getElementById("btn-cancel-edit-karyawan").addEventListener("click", function() {
                if (!{{ $errors->any() ? "true" : "false" }}) {
                    formEdit.reset();
                } else {
                    window.location.reload();
                }
            });
        });
    </script>
@endsection
