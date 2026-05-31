<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Presensi Macawa Coffee</title>
    <style>
        /* Pengaturan Dasar Halaman PDF */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* DESAIN KOP SURAT RESMI */
        .kop-surat {
            border-bottom: 3px solid #0f172a;
            padding-bottom: 10px;
            margin-bottom: 20px;
            width: 100%;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-left {
            text-align: left;
            width: 65%;
        }

        .kop-right {
            text-align: right;
            width: 35%;
            vertical-align: top;
            border-left: 1px solid #cbd5e1;
            padding-left: 15px;
        }

        .brand-name {
            font-size: 20px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .brand-tagline {
            font-size: 9px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 2px 0 0 0;
        }

        .brand-address {
            font-size: 9px;
            color: #94a3b8;
            margin-top: 5px;
            line-height: 1.3;
        }

        .doc-title {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            color: #1e293b;
            margin: 0;
        }

        .doc-subtitle {
            font-size: 9px;
            text-transform: uppercase;
            font-weight: bold;
            color: #dc2626;
            margin: 2px 0 0 0;
        }

        .doc-periode {
            font-size: 9px;
            color: #64748b;
            margin-top: 5px;
        }

        /* DESAIN TABEL DATA LAPORAN */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table-data th {
            background-color: #0f172a;
            color: #ffffff;
            font-weight: bold;
            padding: 8px 10px;
            font-size: 11px;
            text-align: left;
            border: none;
        }

        .table-data td {
            padding: 8px 10px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 11px;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        /* Indikator Warna Status (Aman untuk PDF) */
        .txt-success {
            color: #10b981;
            font-weight: bold;
        }

        .txt-danger {
            color: #ef4444;
            font-weight: bold;
        }

        .txt-warning {
            color: #f59e0b;
            font-weight: bold;
        }

        .txt-muted {
            color: #475569;
            font-weight: bold;
        }

        .unit-text {
            font-size: 9px;
            color: #94a3b8;
            font-weight: normal;
        }

        /* AREA TANDA TANGAN */
        .tanda-tangan-container {
            margin-top: 40px;
            width: 100%;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ttd-box {
            width: 30%;
            text-align: center;
        }

        .ttd-space {
            height: 70px;
        }
    </style>
</head>

<body>

    <!-- KOP SURAT RESMI MACAWA COFFEE -->
    <div class="kop-surat">
        <table class="kop-table">
            <tr>
                <td class="kop-left">
                    <h1 class="brand-name">MACAWA COFFEE</h1>
                    <p class="brand-tagline">Premium Coffee & Roastery</p>
                    <div class="brand-address">
                        Jl. Kolonel Abunjani No. 42, Sipin, Kota Jambi, Indonesia <br>
                        Email: Operational@macawacoffee.com | Telp: +62 812-3456-7890
                    </div>
                </td>
                <td class="kop-right">
                    <h2 class="doc-title">Laporan Bulanan</h2>
                    <p class="doc-subtitle">Rekapitulasi Presensi</p>
                    <p class="doc-periode">Periode:<br><strong>{{ $periodeText }}</strong></p>
                </td>
            </tr>
        </table>
    </div>

    <!-- TABEL DATA UTAMA -->
    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 5%; border-top-left-radius: 6px; border-bottom-left-radius: 6px;" class="text-center">
                    No</th>
                <th style="width: 30%;">Nama Karyawan</th>
                <th style="width: 20%;">Jabatan</th>
                <th style="width: 12%; text-align: center;">Tepat Waktu</th>
                <th style="width: 11%; text-align: center;">Terlambat</th>
                <th style="width: 11%; text-align: center;">Izin/Sakit</th>
                <th
                    style="width: 11%; text-align: center; border-top-right-radius: 6px; border-bottom-right-radius: 6px;">
                    Alpa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $index => $e)
                <tr>
                    <td class="text-center" style="color: #94a3b8;">{{ $index + 1 }}</td>
                    <td class="font-bold" style="color: #0f172a;">{{ $e->nama }}</td>
                    <td style="color: #475569;">{{ $e->jabatan }}</td>
                    <td class="text-center"><span class="txt-success">{{ $e->total_tepat_waktu }}</span> <span
                            class="unit-text">kali</span></td>
                    <td class="text-center"><span class="txt-danger">{{ $e->total_terlambat }}</span> <span
                            class="unit-text">kali</span></td>
                    <td class="text-center"><span class="txt-warning">{{ $e->total_izin }}</span> <span
                            class="unit-text">kali</span></td>
                    <td class="text-center"><span class="txt-muted">{{ $e->total_alpa }}</span> <span
                            class="unit-text">kali</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TANDA TANGAN MANAJER -->
    <div class="tanda-tangan-container">
        <table class="ttd-table">
            <tr>
                <!-- Sisi kiri dikosongkan untuk menyeimbangkan posisi tanda tangan di kanan -->
                <td style="width: 70%;"></td>
                <td class="ttd-box">
                    <p style="color: #64748b; margin: 0;">Jambi, {{ $tanggalCetak }}</p>
                    <p style="font-weight: bold; color: #0f172a; margin: 3px 0 0 0;">Manager Macawa Coffee</p>
                    <div class="ttd-space"></div>
                    <p
                        style="font-weight: bold; color: #0f172a; margin: 0; text-transform: uppercase; border-top: 1px solid #475569; padding-top: 5px;">
                        Manager Operasional
                    </p>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
