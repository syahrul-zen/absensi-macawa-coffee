<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Demo Absensi GPS Kafe</title>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background: #eef2f3;
                margin: 0;
            }

            .card {
                background: white;
                padding: 40px;
                border-radius: 16px;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
                text-align: center;
                width: 100%;
                max-width: 400px;
            }

            button {
                background: #10b981;
                color: white;
                border: none;
                padding: 14px 28px;
                font-size: 16px;
                border-radius: 8px;
                cursor: pointer;
                width: 100%;
                font-weight: bold;
                transition: 0.2s;
            }

            button:hover {
                background: #059669;
            }

            button:disabled {
                background: #cbd5e1;
                cursor: not-allowed;
            }

            .alert {
                padding: 12px;
                border-radius: 8px;
                margin-bottom: 20px;
                font-weight: 500;
                font-size: 14px;
            }

            .alert-success {
                background: #d1fae5;
                color: #065f46;
                border: 1px solid #a7f3d0;
            }

            .alert-error {
                background: #fee2e2;
                color: #991b1b;
                border: 1px solid #fca5a5;
            }

            .status {
                margin-top: 15px;
                font-size: 14px;
                color: #64748b;
                font-style: italic;
            }
        </style>
    </head>

    <body>

        <div class="card">
            <h2>☕ Presensi Kafe</h2>
            <p style="color: #64748b; margin-bottom: 25px;">Klik tombol di bawah untuk simulasi absen masuk.</p>

            <!-- Notifikasi dari Backend Laravel -->
            @if (session("success"))
                <div class="alert alert-success">{{ session("success") }}</div>
            @endif

            @if (session("error"))
                <div class="alert alert-error">{{ session("error") }}</div>
            @endif

            <div id="statusPesan" class="status" style="margin-bottom: 15px; display: none;"></div>

            <form id="formAbsen" action="{{ url("absen/proses") }}" method="POST">
                @csrf
                <input type="hidden" name="latitude" id="lat">
                <input type="hidden" name="longitude" id="lon">
                <button type="button" id="btnKirim" onclick="ambilLokasi()">Dapatkan Lokasi & Absen</button>
            </form>
        </div>

        <script>
            function ambilLokasi() {
                const btn = document.getElementById('btnKirim');
                const statusDiv = document.getElementById('statusPesan');

                btn.disabled = true;
                statusDiv.style.display = "block";
                statusDiv.style.color = "#64748b";
                statusDiv.innerText = "Sedang mencari sinyal GPS...";

                if (!navigator.geolocation) {
                    statusDiv.innerText = "Browser kamu tidak mendukung GPS.";
                    statusDiv.style.color = "#991b1b";
                    btn.disabled = false;
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        statusDiv.innerText = "Lokasi ditemukan! Mengirim data ke server...";
                        statusDiv.style.color = "#10b981";

                        // Masukkan data GPS ke form tersembunyi
                        document.getElementById('lat').value = position.coords.latitude;
                        document.getElementById('lon').value = position.coords.longitude;

                        // Submit form ke Laravel backend
                        document.getElementById('formAbsen').submit();
                    },
                    (error) => {
                        btn.disabled = false;
                        statusDiv.style.color = "#991b1b";
                        if (error.code === error.PERMISSION_DENIED) {
                            statusDiv.innerText = "Gagal: Akses GPS ditolak oleh pengguna.";
                        } else {
                            statusDiv.innerText = "Gagal mendapatkan lokasi. Coba lagi.";
                        }
                    }, {
                        enableHighAccuracy: true,
                        timeout: 8000,
                        maximumAge: 0
                    }
                );
            }
        </script>

    </body>

</html>
