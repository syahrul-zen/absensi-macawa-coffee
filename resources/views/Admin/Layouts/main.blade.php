<!DOCTYPE html>
<html lang="id" data-theme="light">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield("title", "Admin Panel") - Macawa Coffee</title>
        @vite(["resources/css/app.css", "resources/js/app.js"])

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }

            .bg-macawa-red {
                background-color: rgb(255, 0, 0);
            }

            .text-macawa-red {
                color: rgb(255, 0, 0);
            }

            .border-macawa-red {
                border-color: rgb(255, 0, 0);
            }
        </style>
    </head>

    <body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

        <!-- Gunakan lg:drawer-open sesuai template referensi Anda -->
        <div class="drawer lg:drawer-open min-h-screen">
            <!-- ID ini dipanggil oleh tombol di header -->
            <input id="sidebar-drawer" type="checkbox" class="drawer-toggle" />

            <!-- Konten Utama (Sisi Kanan) -->
            <div class="drawer-content flex min-w-0 flex-1 flex-col">

                <!-- Include Topbar / Header (Di dalam sini ada tombol toggle drawer) -->
                @include("Admin.Layouts.header")

                <!-- Dynamic Page Content -->
                <main class="mx-auto w-full max-w-7xl flex-1 space-y-6 p-6">
                    @yield("content")
                </main>
            </div>

            <!-- Konten Sidebar (Sisi Kiri) -->
            <!-- Memakai modifier variant responsive untuk collapse-expand -->
            <div class="drawer-side is-drawer-close:overflow-visible z-20">
                <!-- Overlay penutup saat diklik luar (Mobile view) -->
                <label for="sidebar-drawer" aria-label="close sidebar" class="drawer-overlay"></label>

                <!-- Include file Sidebar asli Anda -->
                @include("Admin.Partials.sidebar")
            </div>
        </div>

        @stack("scripts")
    </body>

</html>
