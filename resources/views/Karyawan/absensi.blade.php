@extends('Karyawan.Layouts.main')

@section('title', 'Absensi Hari Ini')

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-black text-slate-800 tracking-tight">Presensi Kehadiran</h2>
        <p class="text-xs font-medium text-slate-400">Pencatatan jam kerja berbasis verifikasi waktu shift dan radius lokasi
            GPS.</p>
    </div>

    @if (session('success'))
        <div
            class="alert alert-success bg-emerald-50 border border-emerald-200/60 p-3.5 rounded-xl text-xs font-bold text-emerald-800 mb-5">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div
            class="alert alert-error bg-red-50 border border-red-200/60 p-3.5 rounded-xl text-xs font-bold text-red-700 mb-5">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div
            class="card bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl overflow-hidden h-fit border border-slate-100/50">
            <div class="bg-red-600 p-5 text-white text-center">
                <p class="text-[10px] font-bold uppercase tracking-widest opacity-75">Waktu Kerja Real-time</p>
                <h2 id="live-clock" class="text-3xl font-black tracking-tight my-0.5">00:00:00</h2>
                <p id="live-date" class="text-[11px] font-semibold opacity-90">Hari, Tanggal</p>
            </div>
            <div class="p-4 space-y-2.5 text-xs font-semibold bg-white">
                <div class="flex justify-between border-b border-slate-100/60 pb-2">
                    <span class="text-slate-400">Jadwal Shift:</span>
                    <span class="text-red-600 font-bold">{{ $shift->nama_shift }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Ketentuan Jam:</span>
                    <span class="text-slate-800 font-bold">{{ \Carbon\Carbon::parse($shift->jam_masuk)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($shift->jam_pulang)->format('H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- <div
            class="md:col-span-2 card bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 justify-center border border-slate-100/50">

            @if ($absensiHariIni && $absensiHariIni->status == 'Izin')
                <div class="p-6 bg-yellow-50/60 border border-yellow-200 rounded-xl text-center">
                    <span class="text-yellow-700 font-black text-sm block">STATUS HARI INI: IZIN / SAKIT</span>
                    <p class="text-xs text-slate-500 font-medium mt-1">Permohonan dispensasi Anda telah terdata:
                        "{{ $absensiHariIni->keterangan }}"</p>
                </div>
            @else
                <div class="text-center md:text-left mb-5">
                    <span class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">Status Kehadiran Hari
                        Ini</span>
                    <div class="mt-1">
                        @if ($absensiHariIni)
                            <span
                                class="badge bg-emerald-100 text-emerald-700 border-none font-black text-xs px-3 py-2.5 rounded-lg">{{ strtoupper($absensiHariIni->status) }}</span>
                        @else
                            <span
                                class="badge bg-red-100 text-red-600 border-none font-black text-xs px-3 py-2.5 rounded-lg">BELUM
                                ABSEN</span>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    @if (!$absensiHariIni)
                        <form action="{{ url('/absen-masuk') }}" method="POST" id="form-absen-masuk">
                            @csrf
                            <input type="hidden" name="latitude" id="input-lat">
                            <input type="hidden" name="longitude" id="input-lon">

                            <button type="button" onclick="getLokasiKaryawan()" {{ !$isDalamJamShift ? 'disabled' : '' }}
                                class="btn bg-red-600 hover:bg-red-700 border-none text-white w-full rounded-xl font-bold text-xs h-12 normal-case disabled:bg-slate-100 disabled:text-slate-400">
                                {{ $isDalamJamShift ? '✔ Kirim Absen Masuk (Verifikasi Lokasi)' : '🔒 Tombol Terkunci (Di Luar Jam Shift)' }}
                            </button>
                        </form>

                        <button type="button" onclick="modal_izin_karyawan.showModal()"
                            class="text-xs text-red-500 font-bold underline cursor-pointer mt-2 text-center hover:text-red-700 block mx-auto bg-transparent border-none">
                            Ajukan Surat Izin / Sakit Jika Berhalangan Hadir
                        </button>
                    @elseif($absensiHariIni && is_null($absensiHariIni->jam_pulang_asli))
                        <form action="{{ url('/absen-pulang') }}" method="POST" id="form-absen-pulang">
                            @csrf
                            <input type="hidden" name="latitude_pulang" id="input-lat-pulang">
                            <input type="hidden" name="longitude_pulang" id="input-lon-pulang">

                            <button type="button" onclick="getLokasiPulang()"
                                class="btn bg-slate-800 hover:bg-slate-900 border-none text-white w-full rounded-xl font-bold text-xs h-12 normal-case">
                                👋 Catat Absen Pulang Kerja
                            </button>
                        </form>
                    @else
                        <div
                            class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 font-bold text-xs rounded-xl text-center">
                            🎉 Absensi hari ini selesai. Selamat beristirahat dari tugas shift Anda!
                        </div>
                    @endif
                </div>
            @endif

        </div> --}}

        <div
            class="md:col-span-2 card bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 justify-center border border-slate-100/50">

            @if ($absensiHariIni && $absensiHariIni->status == 'Izin')
                <div class="p-6 bg-yellow-50/60 border border-yellow-200 rounded-xl text-center">
                    <span class="text-yellow-700 font-black text-sm block">STATUS HARI INI: IZIN / SAKIT</span>
                    <p class="text-xs text-slate-500 font-medium mt-1">Permohonan dispensasi Anda telah terdata:
                        "{{ $absensiHariIni->keterangan }}"</p>
                </div>
            @else
                <div class="text-center md:text-left mb-5">
                    <span class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">Status Kehadiran Hari
                        Ini</span>
                    <div class="mt-1">
                        @if ($absensiHariIni)
                            <span
                                class="badge bg-emerald-100 text-emerald-700 border-none font-black text-xs px-3 py-2.5 rounded-lg">{{ strtoupper($absensiHariIni->status) }}</span>
                        @else
                            <span
                                class="badge bg-red-100 text-red-600 border-none font-black text-xs px-3 py-2.5 rounded-lg">BELUM
                                ABSEN</span>
                        @endif
                    </div>
                </div>

                <!-- ======================================================== -->
                <!-- KOMPONEN SELFIE CAM INTERAKTIF (MODERN)                  -->
                <!-- ======================================================== -->
                @if (!$absensiHariIni || ($absensiHariIni && is_null($absensiHariIni->jam_pulang_asli)))
                    <div
                        class="form-control w-full flex flex-col items-center justify-center bg-slate-50 p-4 rounded-xl border border-slate-100 mb-4">
                        <label class="label pb-1.5 w-full justify-start pt-0">
                            <span class="label-text font-black text-slate-500 text-[10px] uppercase tracking-wider">📸 Bukti
                                Foto Swafoto</span>
                        </label>

                        <!-- Wadah Kamera (Awalnya Tersembunyi 'hidden') -->
                        <video id="webcam" autoplay playsinline
                            class="hidden w-full max-w-xs h-40 bg-slate-900 rounded-xl object-cover shadow-inner mb-2.5"></video>
                        <canvas id="canvas" class="hidden"></canvas>

                        <!-- Preview Hasil Foto (Awalnya Tersembunyi 'hidden') -->
                        <img id="photo-preview"
                            class="hidden w-full max-w-xs h-40 rounded-xl object-cover border-2 border-emerald-500 shadow-md mb-2.5" />

                        <!-- Menu Aksi Kamera Kontrol -->
                        <div class="w-full max-w-xs">
                            <!-- 1. Tombol Pertama: Pemicu Buka Kamera -->
                            <button type="button" id="start-camera-btn"
                                class="btn btn-sm btn-block bg-slate-800 hover:bg-slate-900 text-white font-bold text-[11px] rounded-xl normal-case h-9 border-none">
                                📷 Buka Kamera Aktif
                            </button>

                            <div class="flex gap-2">
                                <!-- 2. Tombol Kedua: Ambil Jepretan (Muncul saat kamera aktif) -->
                                <button type="button" id="capture-btn"
                                    class="btn btn-sm btn-block bg-red-600 hover:bg-red-700 text-white font-bold text-[11px] rounded-xl normal-case h-9 border-none hidden">
                                    Tangkap Foto
                                </button>
                                <!-- 3. Tombol Ketiga: Reset Ulang Foto -->
                                <button type="button" id="retake-btn"
                                    class="btn btn-sm btn-block bg-amber-500 hover:bg-amber-600 text-white font-bold text-[11px] rounded-xl normal-case h-9 border-none hidden">
                                    🔄 Foto Ulang
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex flex-col gap-3">
                    @if (!$absensiHariIni)
                        <form action="{{ url('/absen-masuk') }}" method="POST" id="form-absen-masuk">
                            @csrf
                            <input type="hidden" name="latitude" id="input-lat">
                            <input type="hidden" name="longitude" id="input-lon">
                            <input type="hidden" name="image_data" id="image_data">

                            <button type="button" onclick="validateAndSubmitMasuk()"
                                {{ !$isDalamJamShift ? 'disabled' : '' }}
                                class="btn bg-red-600 hover:bg-red-700 border-none text-white w-full rounded-xl font-bold text-xs h-12 normal-case disabled:bg-slate-100 disabled:text-slate-400">
                                {{ $isDalamJamShift ? '✔ Kirim Absen Masuk (Verifikasi Lokasi)' : '🔒 Tombol Terkunci (Di Luar Jam Shift)' }}
                            </button>
                        </form>

                        <button type="button" onclick="modal_izin_karyawan.showModal()"
                            class="text-xs text-red-500 font-bold underline cursor-pointer mt-2 text-center hover:text-red-700 block mx-auto bg-transparent border-none">
                            Ajukan Surat Izin / Sakit Jika Berhalangan Hadir
                        </button>
                    @elseif($absensiHariIni && is_null($absensiHariIni->jam_pulang_asli))
                        <form action="{{ url('/absen-pulang') }}" method="POST" id="form-absen-pulang">
                            @csrf
                            <input type="hidden" name="latitude_pulang" id="input-lat-pulang">
                            <input type="hidden" name="longitude_pulang" id="input-lon-pulang">
                            <input type="hidden" name="image_data" id="image_data_pulang">

                            <button type="button" onclick="validateAndSubmitPulang()"
                                class="btn bg-slate-800 hover:bg-slate-900 border-none text-white w-full rounded-xl font-bold text-xs h-12 normal-case">
                                👋 Catat Absen Pulang Kerja
                            </button>
                        </form>
                    @else
                        <div
                            class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 font-bold text-xs rounded-xl text-center">
                            🎉 Absensi hari ini selesai. Selamat beristirahat dari tugas shift Anda!
                        </div>
                    @endif
                </div>
            @endif

        </div>

        <!-- ======================================================== -->
        <!-- ENGINE JAVASCRIPT: TOGGLE LIVE STREAM WEBCAM             -->
        <!-- ======================================================== -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const video = document.getElementById('webcam');
                const canvas = document.getElementById('canvas');
                const startCameraBtn = document.getElementById('start-camera-btn');
                const captureBtn = document.getElementById('capture-btn');
                const retakeBtn = document.getElementById('retake-btn');
                const photoPreview = document.getElementById('photo-preview');

                let streamInstance = null;

                if (!startCameraBtn) return;

                // Aksi 1: Nyalakan Aliran Kamera saat tombol "Buka Kamera" diklik
                startCameraBtn.addEventListener('click', function() {
                    navigator.mediaDevices.getUserMedia({
                            video: {
                                facingMode: "user"
                            },
                            audio: false
                        })
                        .then(function(stream) {
                            streamInstance = stream;
                            video.srcObject = stream;

                            // Kelola visibilitas elemen
                            video.classList.remove('hidden');
                            startCameraBtn.classList.add('hidden');
                            captureBtn.classList.remove('hidden');
                        })
                        .catch(function(err) {
                            console.error("Akses kamera ditolak: ", err);
                            alert("Aplikasi memerlukan akses kamera untuk bukti presensi mandiri.");
                        });
                });

                // Aksi 2: Tangkap Frame Gambar (Capture)
                captureBtn.addEventListener('click', function() {
                    const context = canvas.getContext('2d');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    const dataUrl = canvas.toDataURL('image/jpeg');

                    // Pasok string gambar ke input form yang berhak
                    const inputMasuk = document.getElementById('image_data');
                    const inputPulang = document.getElementById('image_data_pulang');
                    if (inputMasuk) inputMasuk.value = dataUrl;
                    if (inputPulang) inputPulang.value = dataUrl;

                    // Tukar tampilan ke layar statis hasil foto
                    photoPreview.src = dataUrl;
                    photoPreview.classList.remove('hidden');
                    video.classList.add('hidden');
                    captureBtn.classList.add('hidden');
                    retakeBtn.classList.remove('hidden');

                    // Matikan hardware lensa kamera demi hemat daya baterai smartphone
                    if (streamInstance) {
                        streamInstance.getTracks().forEach(track => track.stop());
                    }
                });

                // Aksi 3: Reset Ulang Foto
                retakeBtn.addEventListener('click', function() {
                    const inputMasuk = document.getElementById('image_data');
                    const inputPulang = document.getElementById('image_data_pulang');
                    if (inputMasuk) inputMasuk.value = "";
                    if (inputPulang) inputPulang.value = "";

                    photoPreview.classList.add('hidden');
                    retakeBtn.classList.add('hidden');

                    // Hidupkan ulang hardware kamera
                    startCameraBtn.click();
                });
            });

            function validateAndSubmitMasuk() {
                const foto = document.getElementById('image_data').value;
                if (!foto) {
                    alert("⚠️ Silakan buka kamera dan ambil foto swafoto Anda terlebih dahulu!");
                    return;
                }
                getLokasiKaryawan();
            }

            function validateAndSubmitPulang() {
                const foto = document.getElementById('image_data_pulang').value;
                if (!foto) {
                    alert("⚠️ Silakan buka kamera dan ambil foto swafoto Anda terlebih dahulu!");
                    return;
                }
                getLokasiPulang();
            }
        </script>
    </div>

    <dialog id="modal_izin_karyawan" class="modal backdrop:backdrop-blur-sm">
        <div class="modal-box max-w-sm rounded-2xl bg-white p-6 shadow-2xl">
            <h3 class="text-base font-bold text-slate-900">Form Pengajuan Izin / Sakit</h3>
            <form action="{{ url('/absen-izin') }}" method="POST" enctype="multipart/form-data"
                class="mt-4 space-y-4 text-left">
                @csrf
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Alasan Tidak Hadir</label>
                    <textarea name="keterangan" placeholder="Contoh: Demam tinggi, perlu istirahat dokter."
                        class="textarea textarea-bordered focus:outline-red-600 w-full rounded-xl text-xs h-20 bg-white" required></textarea>
                </div>
                <div class="form-control">
                    <label class="label-text mb-1 text-xs font-bold text-slate-500">Upload Surat Keterangan / Bukti
                        Image</label>
                    <input type="file" name="file_izin" accept="application/pdf"
                        class="file-input file-input-bordered focus:outline-red-600 w-full rounded-xl text-xs bg-white" />
                </div>
                <div class="modal-action mt-6 gap-2">
                    <button type="button" onclick="modal_izin_karyawan.close()"
                        class="btn btn-ghost rounded-xl text-xs font-semibold normal-case">Batal</button>
                    <button type="submit"
                        class="btn bg-red-600 rounded-xl border-none px-6 text-xs font-bold normal-case text-white hover:bg-red-700">Kirim
                        Permohonan</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop bg-slate-900/40"><button>close</button></form>
    </dialog>

    <script>
        // 1. Live Clock Running
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const elClock = document.getElementById('live-clock');
            if (elClock) elClock.textContent = `${hours}:${minutes}:${seconds}`;

            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const elDate = document.getElementById('live-date');
            if (elDate) elDate.textContent = now.toLocaleDateString('id-ID', options);
        }
        setInterval(updateClock, 1000);
        updateClock();

        // 2. Ambil Geolocation Browser saat tombol Masuk ditekan
        // function getLokasiKaryawan() {
        //     if (navigator.geolocation) {
        //         navigator.geolocation.getCurrentPosition(function(position) {
        //             // Set nilai koordinat ke hidden input form
        //             document.getElementById('input-lat').value = position.coords.latitude;
        //             document.getElementById('input-lon').value = position.coords.longitude;

        //             // Kirim form secara otomatis ke backend setelah data koordinat terisi
        //             document.getElementById('form-absen-masuk').submit();
        //         }, function(error) {
        //             alert("Gagal mengambil lokasi. Pastikan izin lokasi/GPS pada browser Anda aktif.");
        //         });
        //     } else {
        //         alert("Browser Anda tidak mendukung fitur pelacakan GPS.");
        //     }
        // }

        // // 2. FUNGSI BARU: Ambil Lokasi untuk PULANG
        // function getLokasiPulang() {
        //     if (navigator.geolocation) {
        //         navigator.geolocation.getCurrentPosition(function(position) {
        //             // Masukkan data ke input hidden milik form pulang
        //             document.getElementById('input-lat-pulang').value = position.coords.latitude;
        //             document.getElementById('input-lon-pulang').value = position.coords.longitude;

        //             // Submit form pulang
        //             document.getElementById('form-absen-pulang').submit();
        //         }, function(error) {
        //             alert("Gagal mengambil lokasi pulang. Pastikan izin lokasi/GPS aktif saat pulang kerja.");
        //         });
        //     } else {
        //         alert("Browser Anda tidak mendukung fitur pelacakan GPS.");
        //     }
        // }

        // ============================ BARU ==========================================
        // 🌟 KONFIGURASI SAKTI UNTUK AKURASI GPS MAKSIMAL
        const opsiGeolokasiMaksimal = {
            enableHighAccuracy: true, // Memaksa browser menggunakan hardware GPS Satelit (Akurasi Tinggi)
            timeout: 10000, // Batas waktu tunggu pencarian posisi maksimal 10 detik
            maximumAge: 0 // Memaksa sistem selalu mengambil posisi realtime terbaru, anti-cache data lama
        };

        // 1. FUNGSI OPTIMAL: Ambil Lokasi untuk MASUK
        function getLokasiKaryawan() {
            if (navigator.geolocation) {
                // Tampilkan loading teks ringan pada tombol agar karyawan tahu proses sedang berjalan
                const btnMasuk = document.querySelector("#form-absen-masuk button");
                if (btnMasuk) {
                    btnMasuk.disabled = true;
                    btnMasuk.innerHTML = "⏳ Menghubungi Satelit GPS...";
                }

                navigator.geolocation.getCurrentPosition(function(position) {
                    // Set nilai koordinat hasil akurasi tinggi ke hidden input form masuk
                    document.getElementById('input-lat').value = position.coords.latitude;
                    document.getElementById('input-lon').value = position.coords.longitude;

                    // Kirim form secara otomatis ke backend setelah data koordinat terisi
                    document.getElementById('form-absen-masuk').submit();
                }, function(error) {
                    // Kembalikan tombol ke semula jika gagal
                    if (btnMasuk) {
                        btnMasuk.disabled = false;
                        btnMasuk.innerHTML = "✔ Kirim Absen Masuk (Verifikasi Lokasi)";
                    }

                    // Logika pesan error yang lebih informatif sesuai kode error HTML5
                    if (error.code === error.TIMEOUT) {
                        alert(
                            "⚠️ Waktu tunggu habis. Koneksi GPS Anda lambat, silakan coba lagi di area yang lebih terbuka."
                        );
                    } else {
                        alert("⚠️ Gagal mengambil lokasi. Pastikan izin lokasi/GPS pada browser Anda aktif.");
                    }
                }, opsiGeolokasiMaksimal); // <--- Menyematkan konfigurasi akurasi tinggi disini
            } else {
                alert("Browser Anda tidak mendukung fitur pelacakan GPS.");
            }
        }

        // 2. FUNGSI OPTIMAL: Ambil Lokasi untuk PULANG
        function getLokasiPulang() {
            if (navigator.geolocation) {
                // Tampilkan loading teks ringan pada tombol pulang
                const btnPulang = document.querySelector("#form-absen-pulang button");
                if (btnPulang) {
                    btnPulang.disabled = true;
                    btnPulang.innerHTML = "⏳ Menghubungi Satelit GPS...";
                }

                navigator.geolocation.getCurrentPosition(function(position) {
                    // Masukkan data hasil akurasi tinggi ke input hidden milik form pulang
                    document.getElementById('input-lat-pulang').value = position.coords.latitude;
                    document.getElementById('input-lon-pulang').value = position.coords.longitude;

                    // Submit form pulang
                    document.getElementById('form-absen-pulang').submit();
                }, function(error) {
                    // Kembalikan tombol ke semula jika gagal
                    if (btnPulang) {
                        btnPulang.disabled = false;
                        btnPulang.innerHTML = "👋 Catat Absen Pulang Kerja";
                    }

                    if (error.code === error.TIMEOUT) {
                        alert(
                            "⚠️ Waktu tunggu habis. Koneksi GPS Anda lambat, silakan coba lagi di area yang lebih terbuka."
                        );
                    } else {
                        alert(
                            "⚠️ Gagal mengambil lokasi pulang. Pastikan izin lokasi/GPS aktif saat pulang kerja."
                        );
                    }
                }, opsiGeolokasiMaksimal); // <--- Menyematkan konfigurasi akurasi tinggi disini
            } else {
                alert("Browser Anda tidak mendukung fitur pelacakan GPS.");
            }
        }
    </script>
@endsection
