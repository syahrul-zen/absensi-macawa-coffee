@extends("Admin.Layouts.main")

@section("title", "Kelola Shift")

@section("content")
    <div class="w-full space-y-4">
        {{-- Alert Berhasil (Ditampilkan hanya jika ada session success) --}}
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

        {{-- Header Section --}}
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
                    @forelse($shifts as $shift)
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $shift->nama_shift }}</td>
                            <td class="px-6 py-4 text-xs font-medium">
                                {{ \Carbon\Carbon::parse($shift->jam_masuk)->format("H:i") }}</td>
                            <td class="px-6 py-4 text-xs font-medium">
                                {{ \Carbon\Carbon::parse($shift->jam_pulang)->format("H:i") }}</td>
                            <td class="px-6 py-4 text-center">
                                <!-- Tombol Edit dengan data attribute -->
                                <button type="button"
                                    class="btn-edit-shift btn btn-ghost btn-xs font-bold normal-case text-yellow-500"
                                    data-id="{{ $shift->id }}" data-nama="{{ $shift->nama_shift }}"
                                    data-masuk="{{ \Carbon\Carbon::parse($shift->jam_masuk)->format("H:i") }}"
                                    data-pulang="{{ \Carbon\Carbon::parse($shift->jam_pulang)->format("H:i") }}">
                                    Edit
                                </button>
                                <button type="button"
                                    class="btn-delete-shift btn btn-ghost btn-xs text-macawa-red font-bold normal-case"
                                    data-id="{{ $shift->id }}" data-nama="{{ $shift->nama_shift }}">
                                    Hapus
                                </button>
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
    <!-- Jika ada error di validasi form, otomatis tambahkan atribut 'checked' agar modal langsung timbul -->
    <input type="checkbox" id="modal-add-shift" class="modal-toggle" {{ $errors->any() ? "checked" : "" }} />

    <div class="modal">
        <div class="modal-box max-w-sm rounded-2xl bg-white p-6">
            <h3 class="text-base font-bold text-slate-900">Buat Jam Shift Baru</h3>

            <form action="{{ url("/shift") }}" method="POST" class="mt-4 space-y-4">
                @csrf

                <!-- Nama Shift -->
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Nama Shift</label>
                    <!-- value="{{ old("nama_shift") }}" berguna agar teks yang sudah diketik user tidak hilang saat error -->
                    <input type="text" name="nama_shift" value="{{ old("nama_shift") }}"
                        placeholder="Contoh: Shift Pagi / Barista"
                        class="input input-bordered focus:outline-macawa-red {{ $errors->has("nama_shift") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs" />

                    @error("nama_shift")
                        <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <!-- Jam Masuk -->
                    <div class="form-control">
                        <label class="label-text mb-1 text-xs font-bold text-slate-500">Jam Masuk</label>
                        <input type="time" name="jam_masuk" value="{{ old("jam_masuk") }}"
                            class="input input-bordered focus:outline-macawa-red {{ $errors->has("jam_masuk") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs" />

                        @error("jam_masuk")
                            <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jam Pulang -->
                    <div class="form-control">
                        <label class="label-text mb-1 text-xs font-bold text-slate-500">Jam Pulang</label>
                        <input type="time" name="jam_pulang" value="{{ old("jam_pulang") }}"
                            class="input input-bordered focus:outline-macawa-red {{ $errors->has("jam_pulang") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs" />

                        @error("jam_pulang")
                            <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                        @enderror
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

    <input type="checkbox" id="modal-edit-shift" class="modal-toggle"
        {{ $errors->any() && old("edit_id") ? "checked" : "" }} />

    <div class="modal">
        <div class="modal-box max-w-sm rounded-2xl bg-white p-6 text-left">
            <h3 class="text-base font-bold text-slate-900">Ubah Jam Shift Kerja</h3>

            <!-- Action akan diisi secara dinamis oleh JS, default diarahkan ke URL kosong -->
            <form id="form-edit-shift" action="{{ url("/shift/" . (old("edit_id") ?? "")) }}" method="POST"
                class="mt-4 space-y-4">
                @csrf
                @method("PUT")

                <!-- Hidden Input untuk menyimpan ID yang sedang diedit -->
                <input type="hidden" name="edit_id" id="edit-shift-id" value="{{ old("edit_id") }}">

                <!-- Nama Shift -->
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Nama Shift</label>
                    <input type="text" name="nama_shift" id="edit-nama-shift" value="{{ old("nama_shift") }}"
                        placeholder="Contoh: Shift Pagi / Barista"
                        class="input input-bordered focus:outline-macawa-red {{ $errors->has("nama_shift") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs"
                        required />

                    @error("nama_shift")
                        <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <!-- Jam Masuk -->
                    <div class="form-control">
                        <label class="label-text mb-1 text-xs font-bold text-slate-500">Jam Masuk</label>
                        <input type="time" name="jam_masuk" id="edit-jam-masuk" value="{{ old("jam_masuk") }}"
                            class="input input-bordered focus:outline-macawa-red {{ $errors->has("jam_masuk") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs"
                            required />

                        @error("jam_masuk")
                            <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jam Pulang -->
                    <div class="form-control">
                        <label class="label-text mb-1 text-xs font-bold text-slate-500">Jam Pulang</label>
                        <input type="time" name="jam_pulang" id="edit-jam-pulang" value="{{ old("jam_pulang") }}"
                            class="input input-bordered focus:outline-macawa-red {{ $errors->has("jam_pulang") ? "border-red-500 focus:outline-red-500" : "" }} w-full rounded-xl text-xs"
                            required />

                        @error("jam_pulang")
                            <span class="mt-1 text-[10px] font-semibold text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="modal-action mt-6 gap-2">
                    <!-- Tombol Batal membersihkan inputan lama jika ditekan -->
                    <label for="modal-edit-shift" id="btn-cancel-edit"
                        class="btn btn-ghost rounded-xl text-xs font-semibold normal-case">Batal</label>
                    <button type="submit"
                        class="btn bg-macawa-red rounded-xl border-none px-6 text-xs font-bold normal-case text-white hover:bg-red-700">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <input type="checkbox" id="modal-delete-shift" class="modal-toggle" />

    <div class="modal">
        <div class="modal-box max-w-sm rounded-2xl bg-white p-6 text-center">
            <!-- Icon Peringatan Merah -->
            <div class="text-macawa-red mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-50">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m14.74 9-.34 6m-4.74 0L9.26 15m9.96-6-.34 12A2.25 2.25 0 0 1 15.75 21H8.25a2.25 2.25 0 0 1-2.24-2.15L5.45 9m16.08 0H3.36m13.59 0-1 Shelby-1.72a2.25 2.25 0 0 0-2.25-2.25h-3a2.25 2.25 0 0 0-2.25 2.25L6.74 9M12 18.75V16.5" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h3 class="text-base font-bold text-slate-900">Hapus Shift Kerja?</h3>
            <p class="mt-2 text-xs font-medium text-slate-500">
                Apakah Anda yakin ingin menghapus shift <span id="delete-shift-name"
                    class="font-bold text-slate-800"></span>? Tindakan ini tidak dapat dibatalkan.
            </p>

            <!-- Form Hapus Dinamis -->
            <form id="form-delete-shift" action="" method="POST" class="mt-6 flex justify-end gap-2">
                @csrf
                @method("DELETE")

                <label for="modal-delete-shift"
                    class="btn btn-ghost flex-1 rounded-xl text-xs font-semibold normal-case">Batal</label>
                <button type="submit"
                    class="btn bg-macawa-red flex-1 rounded-xl border-none text-xs font-bold normal-case text-white hover:bg-red-700">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modalToggle = document.getElementById("modal-edit-shift");
            const formEdit = document.getElementById("form-edit-shift");

            // Ambil elemen-elemen input di dalam modal
            const inputId = document.getElementById("edit-shift-id");
            const inputNama = document.getElementById("edit-nama-shift");
            const inputMasuk = document.getElementById("edit-jam-masuk");
            const inputPulang = document.getElementById("edit-jam-pulang");

            // Basis URL untuk action form (Sesuaikan jika aplikasi Anda tidak berjalan di root folder)
            const baseUrl = "{{ url("/shift") }}";

            // Tangkap semua tombol edit di dalam tabel
            document.querySelectorAll(".btn-edit-shift").forEach(button => {
                button.addEventListener("click", function() {
                    // 1. Ambil data dari attribute tombol yang diklik
                    const id = this.getAttribute("data-id");
                    const nama = this.getAttribute("data-nama");
                    const masuk = this.getAttribute("data-masuk");
                    const pulang = this.getAttribute("data-pulang");

                    // 2. Isi value form modal dengan data di atas
                    inputId.value = id;
                    inputNama.value = nama;
                    inputMasuk.value = masuk;
                    inputPulang.value = pulang;

                    // 3. Ubah action form secara dinamis menuju endpoint update (e.g., /shift/5)
                    formEdit.setAttribute("action", `${baseUrl}/${id}`);

                    // 4. Picu/buka modal dengan mencentang checkbox toggle-nya
                    modalToggle.checked = true;
                });
            });

            // Opsional: Bersihkan form jika tombol 'Batal' diklik agar sisa error validasi hilang saat dibuka kembali
            document.getElementById("btn-cancel-edit").addEventListener("click", function() {
                // Jika tidak ada error validasi bawaan session, form aman di-reset biasa
                if (!{{ $errors->any() ? "true" : "false" }}) {
                    formEdit.reset();
                } else {
                    // Jika ada error validasi sebelumnya, paksa bersihkan halaman agar error visual hilang saat ditutup
                    window.location.reload();
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // ... kode JavaScript modal edit Anda yang kemarin tetap di sini ...

            const deleteModalToggle = document.getElementById("modal-delete-shift");
            const formDelete = document.getElementById("form-delete-shift");
            const deleteShiftName = document.getElementById("delete-shift-name");

            // Basis URL untuk delete endpoint
            const baseUrlDelete = "{{ url("/shift") }}";

            // Tangkap klik tombol hapus
            document.querySelectorAll(".btn-delete-shift").forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");
                    const nama = this.getAttribute("data-nama");

                    // 1. Masukkan teks nama shift ke dalam tag kalimat konfirmasi
                    deleteShiftName.textContent = nama;

                    // 2. Ubah action form menjadi /shift/{id} secara dinamis
                    formDelete.setAttribute("action", `${baseUrlDelete}/${id}`);

                    // 3. Munculkan modal hapus
                    deleteModalToggle.checked = true;
                });
            });
        });
    </script>
@endsection
