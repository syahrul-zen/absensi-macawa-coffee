@extends('Admin.Layouts.main')

@section('title', 'Dashboard Utama Admin')

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-black text-slate-800 tracking-tight">Dashboard Ringkasan</h2>
        <p class="text-xs font-medium text-slate-400">Analisis cepat kondisi kehadiran kru dan tren kedisiplinan Macawa
            Coffee.</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div
            class="bg-white p-4 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex items-center gap-4">
            <div
                class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs font-bold">
                👤</div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Sudah Masuk</span>
                <span class="text-lg font-black text-slate-800">{{ $hadirHariIni }} <span
                        class="text-xs font-medium text-slate-400">kru</span></span>
            </div>
        </div>

        <div
            class="bg-white p-4 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xs font-bold">⏰
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Terlambat Hari Ini</span>
                <span class="text-lg font-black text-slate-800">{{ $terlambatHariIni }} <span
                        class="text-xs font-medium text-slate-400">kru</span></span>
            </div>
        </div>

        <div
            class="bg-white p-4 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xs font-bold">
                📄</div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Sedang Izin</span>
                <span class="text-lg font-black text-slate-800">{{ $izinHariIni }} <span
                        class="text-xs font-medium text-slate-400">kru</span></span>
            </div>
        </div>

        <div
            class="bg-white p-4 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex items-center gap-4">
            <div
                class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center text-xs font-bold">
                ❓</div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Belum Datang / Alpa</span>
                <span class="text-lg font-black text-slate-800">{{ $belumAbsenHariIni }} <span
                        class="text-xs font-medium text-slate-400">kru</span></span>
            </div>
        </div>
    </div>

    <div class="card bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl border border-slate-100/60 p-5">
        <div class="mb-4">
            <h3 class="text-sm font-black text-slate-800 tracking-tight">Grafik Tren Kehadiran (7 Hari Terakhir)</h3>
            <p class="text-[11px] font-medium text-slate-400">Visualisasi perbandingan tingkat kedisiplinan kru dari hari ke
                hari.</p>
        </div>

        <div class="w-full h-64 sm:h-80">
            <canvas id="trenAbsensiChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('trenAbsensiChart').getContext('2d');

            // Tangkap data array terpisah dari controller
            const labelHari = {!! json_encode($grafikLabels) !!};
            const dataTepatWaktu = {!! json_encode($grafikTepatWaktu) !!};
            const dataTerlambat = {!! json_encode($grafikTerlambat) !!};
            const dataIzin = {!! json_encode($grafikIzin) !!}; // Tambahan baru
            const dataAlpa = {!! json_encode($grafikAlpa) !!}; // Tambahan baru

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labelHari,
                    datasets: [{
                            label: 'Tepat Waktu',
                            data: dataTepatWaktu,
                            backgroundColor: '#10b981', // Emerald-500 (Hijau)
                            borderRadius: 5
                        },
                        {
                            label: 'Terlambat',
                            data: dataTerlambat,
                            backgroundColor: '#ef4444', // Red-500 (Merah)
                            borderRadius: 5
                        },
                        {
                            label: 'Izin / Sakit',
                            data: dataIzin,
                            backgroundColor: '#f59e0b', // Amber-500 (Kuning Emas)
                            borderRadius: 5
                        },
                        {
                            label: 'Alpa / Belum Datang',
                            data: dataAlpa,
                            backgroundColor: '#cbd5e1', // Slate-300 (Abu-abu lembut)
                            borderRadius: 5
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    size: 11,
                                    weight: 'bold'
                                },
                                usePointStyle: true,
                                boxWidth: 6
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10,
                                    weight: '600'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9'
                            },
                            ticks: {
                                stepSize: 1,
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

@endsection
