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
        </style>
        <style>
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

    <body class="flex min-h-screen bg-slate-50 text-slate-800 antialiased">

        <!-- Include Sidebar -->
        @include("Admin.Partials.sidebar")

        <!-- Main Content Area -->
        <div class="flex min-w-0 flex-1 flex-col">
            <!-- Include Topbar / Header -->
            @include("Admin.Layouts.header")

            <!-- Dynamic Page Content -->
            <main class="mx-auto w-full max-w-7xl flex-1 space-y-6 p-6">
                @yield("content")
            </main>
        </div>

        @stack("scripts")
    </body>

</html>
