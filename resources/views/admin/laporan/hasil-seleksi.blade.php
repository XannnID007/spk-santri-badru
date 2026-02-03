<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Seleksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            margin: 15px;
        }

        /* HEADER FORMAL BARU */
        .header-formal {
            border: 3px solid #000;
            background: linear-gradient(to bottom, #FFFF00 0%, #FFFF00 60%, #00FF00 60%, #00FF00 100%);
            padding: 15px;
            margin-bottom: 25px;
            text-align: center;
        }

        .header-formal .main-title {
            font-size: 13pt;
            font-weight: bold;
            margin: 0 0 5px 0;
            line-height: 1.3;
            text-transform: uppercase;
        }

        .header-formal .sub-title {
            font-size: 11pt;
            font-weight: bold;
            margin: 0 0 8px 0;
            text-transform: uppercase;
        }

        .header-formal .regulation-info {
            font-size: 7.5pt;
            margin: 5px 0;
            line-height: 1.3;
        }

        .header-formal .bank-info {
            font-size: 8.5pt;
            font-weight: bold;
            margin: 5px 0;
            color: #c00;
        }

        .header-formal .npwp-info {
            font-size: 8.5pt;
            font-weight: bold;
            margin: 3px 0 0 0;
        }

        .header-formal .address-footer {
            font-size: 7pt;
            margin: 5px 0 0 0;
            line-height: 1.2;
        }

        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-title h2 {
            margin: 0;
            text-decoration: underline;
            font-size: 14pt;
        }

        .report-title p {
            margin: 5px 0;
            font-size: 11pt;
            font-weight: bold;
        }

        .info-box {
            background: #f3f4f6;
            padding: 12px;
            margin-bottom: 15px;
            border-left: 4px solid #10b981;
            border: 1px solid #d1d5db;
        }

        .info-box table {
            width: 100%;
        }

        .info-box td {
            padding: 3px 0;
            font-size: 9.5pt;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data th {
            background: #374151;
            color: white;
            padding: 8px 5px;
            font-size: 9pt;
            text-align: left;
            border: 1px solid #000;
        }

        table.data td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            font-size: 9pt;
        }

        table.data tr:nth-child(even) {
            background: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 8pt;
            font-weight: bold;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 9pt;
        }

        .signature {
            margin-top: 60px;
        }

        .rank-1 {
            background: #fef3c7 !important;
            font-weight: bold;
        }

        .rank-2 {
            background: #e5e7eb !important;
        }

        .rank-3 {
            background: #fed7aa !important;
        }

        .keterangan-box {
            margin-top: 20px;
            padding: 12px;
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            border: 1px solid #fbbf24;
        }

        .keterangan-box strong {
            font-size: 10pt;
        }

        .keterangan-box small {
            font-size: 8.5pt;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <!-- HEADER FORMAL BARU -->
    <div class="header-formal">
        <div class="main-title">
            YAYASAN ANAK YATIM/PIATU, ANAK ASUH DAN DHUAFA<br>
            BADRU PASIRKALIKI
        </div>
        <div class="sub-title">
            KELURAHAN PASIRKALIKI KECAMATAN CIMAHI UTARA KOTA CIMAHI PROVINSI JAWA BARAT
        </div>
        <div class="regulation-info">
            (SK Menteri Hukum dan HAM Republik Indonesia No.AHU-5019.AH.01.04.2013 Tgl 06-09-2013)<br>
            (Akte Notaris Pendiri Yayasan Badru Pasirkaliki oleh JJN ABDUL JALIL, S.H.,Sp.N. No.: 15. Tgl 16
            April-2013)<br>
            (Ijasz Bid. Usaha Sosial KESOS No : 458.2/5-PSN-UPPKS/Komas/2013) Bakor Rek: 1071-10-003833-53-5)
        </div>
        <div class="bank-info">
            (Bank bjb CABANG CIMAHI An. Yayasan Badru Pasirkaliki No Rekening :0057421924100)
        </div>
        <div class="npwp-info">
            (NPWP Yayasan Badru Pasirkaliki No : 31.773.122.2-421.000 Tgl 03 Juni 2013)
        </div>
        <div class="address-footer">
            Sekretariat : Jalan Budhi RT 002 RW 004 Kel. Pasirkaliki Kec. Cimahi Utara Kota Cimahi No.Hp. 081842682 /
            082126428817 Kode Pos
        </div>
    </div>

    <div class="report-title">
        <h2>LAPORAN HASIL SELEKSI AKHIR</h2>
        <p>{{ $periode->nama_periode }}</p>
    </div>

    <div class="info-box">
        <table>
            <tr>
                <td style="width: 150px;"><strong>Periode Pendaftaran</strong></td>
                <td>: {{ $periode->nama_periode }}</td>
                <td style="width: 150px;"><strong>Tanggal Cetak</strong></td>
                <td>: {{ now()->format('d F Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td><strong>Total Peserta</strong></td>
                <td>: {{ $hasil->count() }} Orang</td>
                <td><strong>Kuota Diterima</strong></td>
                <td>: {{ $periode->kuota_santri }} Orang</td>
            </tr>
        </table>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Rekapitulasi Status Kelulusan:</strong><br>
        <span class="badge badge-success">Diterima: {{ $totalDiterima }}</span>
        <span class="badge badge-warning">Cadangan: {{ $totalCadangan }}</span>
        <span class="badge badge-danger">Tidak Diterima: {{ $totalDitolak }}</span>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 40px;">Ranking</th>
                <th style="width: 100px;">No. Pendaftaran</th>
                <th>Nama Lengkap</th>
                <th>Asal Sekolah</th>
                <th style="width: 80px;">Nilai Akhir</th>
                <th style="width: 100px;">Status Kelulusan</th>
                <th style="width: 150px;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasil as $h)
                <tr class="{{ $h->ranking <= 3 ? 'rank-' . $h->ranking : '' }}">
                    <td style="text-align: center; font-weight: bold;">{{ $h->ranking }}</td>
                    <td>{{ $h->pendaftaran->no_pendaftaran }}</td>
                    <td>{{ $h->pendaftaran->pengguna->profil->nama_lengkap ?? $h->pendaftaran->pengguna->nama }}</td>
                    <td>{{ $h->pendaftaran->asal_sekolah }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ number_format($h->nilai_akhir * 100, 2) }}
                    </td>
                    <td style="text-align: center;">
                        @if ($h->status_kelulusan === 'diterima')
                            <span class="badge badge-success">DITERIMA</span>
                        @elseif($h->status_kelulusan === 'cadangan')
                            <span class="badge badge-warning">CADANGAN</span>
                        @else
                            <span class="badge badge-danger">TIDAK DITERIMA</span>
                        @endif
                    </td>
                    <td style="font-size: 8pt;">{{ $h->catatan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #6b7280;">
                        Belum ada hasil perhitungan untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="keterangan-box">
        <strong>Keterangan:</strong><br>
        <small>
            - Nilai Akhir dihitung menggunakan metode SMART (Simple Multi-Attribute Rating Technique)<br>
            - Ranking ditentukan berdasarkan nilai akhir tertinggi<br>
            - Status kelulusan ditentukan berdasarkan kuota dan passing grade yang telah ditetapkan
        </small>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Kota Cimahi, {{ now()->format('d F Y') }}</p>
            <p>Ketua Panitia PSB,</p>
            <br><br><br>
            <p><strong><u>_______________________</u></strong></p>
        </div>
    </div>
</body>

</html>
