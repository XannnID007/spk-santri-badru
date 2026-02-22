<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Hasil Seleksi - {{ $periode->nama_periode }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 10pt;
            color: #000;
            background: #fff;
            line-height: 1.5;
            padding: 22px 28px;
        }

        /* ===== KOP SURAT — 3 kolom ===== */
        .kop-surat {
            width: 100%;
            border: 3px solid #000;
            border-collapse: collapse;
            margin-bottom: 22px;
            background: linear-gradient(to bottom,
                    #FFFF00 0%, #FFFF00 60%,
                    #00FF00 60%, #00FF00 100%);
        }

        .kop-col-logo {
            width: 100px;
            vertical-align: middle;
            text-align: center;
            padding: 14px 8px 14px 14px;
        }

        .kop-col-logo img {
            width: 76px;
            height: 76px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .kop-logo-placeholder {
            width: 76px;
            height: 76px;
            border: 2px solid #555;
            line-height: 76px;
            font-size: 8pt;
            font-weight: bold;
            background: rgba(255, 255, 255, 0.5);
            text-align: center;
            display: block;
            margin: 0 auto;
        }

        .kop-col-text {
            vertical-align: middle;
            text-align: center;
            padding: 14px 6px;
        }

        .kop-col-text .main-title {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.35;
            margin-bottom: 4px;
        }

        .kop-col-text .sub-title {
            font-size: 10.5pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        .kop-col-text .regulation-info {
            font-size: 7.5pt;
            line-height: 1.45;
            margin-bottom: 4px;
        }

        .kop-col-text .bank-info {
            font-size: 8.5pt;
            font-weight: bold;
            color: #c00000;
            margin-bottom: 3px;
        }

        .kop-col-text .npwp-info {
            font-size: 8.5pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .kop-col-text .address-footer {
            font-size: 7pt;
            line-height: 1.35;
        }

        .kop-col-dummy {
            width: 100px;
        }

        /* ===== JUDUL ===== */
        .judul-wrapper {
            text-align: center;
            margin: 0 0 20px 0;
        }

        .judul-utama {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .judul-sub {
            font-size: 11pt;
            margin-top: 5px;
        }

        /* ===== INFO BLOCK ===== */
        .info-block {
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .info-block td {
            padding: 6px 14px;
            font-size: 10.5pt;
            vertical-align: top;
        }

        .info-block td.label {
            width: 180px;
            font-weight: bold;
        }

        .info-block td.sep {
            width: 12px;
        }

        .info-block td.div-left {
            border-left: 1px solid #ddd;
            padding-left: 18px;
            width: 180px;
            font-weight: bold;
        }

        .info-block tr+tr td {
            border-top: 1px solid #ddd;
        }

        /* ===== REKAP ===== */
        .rekap-wrapper {
            margin-bottom: 18px;
        }

        .rekap-title {
            font-size: 10.5pt;
            font-weight: bold;
            margin-bottom: 7px;
        }

        .rekap-table {
            border-collapse: collapse;
        }

        .rekap-table td {
            border: 1px solid #000;
            padding: 5px 18px;
            font-size: 10pt;
            text-align: center;
        }

        .rekap-table td.rl {
            text-align: left;
            padding-left: 12px;
            font-weight: bold;
            width: 165px;
        }

        /* ===== TABEL DATA ===== */
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 8px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.data-table th {
            background: #000;
            color: #fff;
            border: 1px solid #000;
            padding: 8px 6px;
            font-size: 9.5pt;
            font-weight: bold;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        table.data-table td {
            border: 1px solid #000;
            padding: 7px 6px;
            font-size: 9.5pt;
            vertical-align: middle;
        }

        table.data-table tr:nth-child(even) td {
            background: #f7f7f7;
        }

        table.data-table td.center {
            text-align: center;
        }

        .row-rank-1 td {
            font-weight: bold;
            background: #f0f0f0 !important;
        }

        /* ===== KETERANGAN ===== */
        .keterangan {
            margin-top: 18px;
            border: 1px solid #000;
            padding: 10px 14px;
        }

        .keterangan strong {
            font-size: 10pt;
        }

        .keterangan p {
            font-size: 9pt;
            margin-top: 5px;
            line-height: 1.7;
        }

        /* ===== FOOTER ===== */
        .footer-section {
            margin-top: 30px;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ttd-kiri {
            width: 55%;
            vertical-align: top;
            font-size: 10pt;
        }

        .ttd-kanan {
            width: 45%;
            text-align: center;
            vertical-align: top;
            font-size: 10.5pt;
        }

        .ttd-space {
            height: 68px;
        }

        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .catatan {
            margin-top: 22px;
            border-top: 1px solid #000;
            padding-top: 6px;
            font-size: 8pt;
            color: #555;
        }
    </style>
</head>

<body>

    <!-- KOP SURAT -->
    <table class="kop-surat">
        <tr>
            <td class="kop-col-logo">
                @php
                    $logoPath = null;
                    if ($pengaturan && $pengaturan->logo) {
                        $p = public_path('storage/' . $pengaturan->logo);
                        if (file_exists($p)) {
                            $logoPath = $p;
                        }
                    }
                @endphp
                @if ($logoPath)
                    <img src="{{ $logoPath }}" alt="Logo Yayasan">
                @else
                    <div class="kop-logo-placeholder">LOGO</div>
                @endif
            </td>

            <td class="kop-col-text">
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
                    Sekretariat : Jalan Budhi RT 002 RW 004 Kel. Pasirkaliki Kec. Cimahi Utara Kota Cimahi
                    No.Hp. 081842682 / 082126428817 Kode Pos
                </div>
            </td>

            <td class="kop-col-dummy"></td>
        </tr>
    </table>

    <!-- JUDUL -->
    <div class="judul-wrapper">
        <div class="judul-utama">Laporan Hasil Seleksi Akhir</div>
        <div class="judul-sub">{{ $periode->nama_periode }}</div>
    </div>

    <!-- INFO -->
    <table class="info-block">
        <tr>
            <td class="label">Periode</td>
            <td class="sep">:</td>
            <td>{{ $periode->nama_periode }}</td>
            <td class="div-left">Tanggal Cetak</td>
            <td class="sep">:</td>
            <td>{{ now()->translatedFormat('d F Y') }}, Pukul {{ now()->format('H:i') }} WIB</td>
        </tr>
        <tr>
            <td class="label">Total Peserta Seleksi</td>
            <td class="sep">:</td>
            <td>{{ $hasil->count() }} Orang</td>
            <td class="div-left">Kuota Diterima</td>
            <td class="sep">:</td>
            <td>{{ $periode->kuota_santri }} Orang</td>
        </tr>
    </table>

    <!-- REKAP -->
    <div class="rekap-wrapper">
        <div class="rekap-title">Rekapitulasi Status Kelulusan:</div>
        <table class="rekap-table">
            <tr>
                <td class="rl">Diterima</td>
                <td>{{ $totalDiterima }} orang</td>
                <td class="rl">Cadangan</td>
                <td>{{ $totalCadangan }} orang</td>
                <td class="rl">Tidak Diterima</td>
                <td>{{ $totalDitolak }} orang</td>
                <td class="rl">Total Peserta</td>
                <td>{{ $hasil->count() }} orang</td>
            </tr>
        </table>
    </div>

    <!-- TABEL HASIL -->
    <div class="section-title">Hasil Seleksi Per Peserta:</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:46px;">Ranking</th>
                <th style="width:120px;">No. Pendaftaran</th>
                <th>Nama Lengkap</th>
                <th>Asal Sekolah</th>
                <th style="width:90px;">Nilai Akhir<br><span style="font-weight:normal; font-size:8pt;">(Skala
                        100)</span></th>
                <th style="width:115px;">Status Kelulusan</th>
                <th style="width:135px;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasil as $h)
                <tr class="{{ $h->ranking === 1 ? 'row-rank-1' : '' }}">
                    <td class="center" style="font-weight:bold; font-size:11pt;">{{ $h->ranking }}</td>
                    <td class="center">{{ $h->pendaftaran->no_pendaftaran }}</td>
                    <td>{{ $h->pendaftaran->pengguna->profil->nama_lengkap ?? $h->pendaftaran->pengguna->nama }}</td>
                    <td>{{ $h->pendaftaran->asal_sekolah }}</td>
                    <td class="center" style="font-weight:bold;">{{ number_format($h->nilai_akhir * 100, 2) }}</td>
                    <td class="center">
                        @if ($h->status_kelulusan === 'diterima')
                            <strong>&#10003; DITERIMA</strong>
                        @elseif($h->status_kelulusan === 'cadangan')
                            <em>&#9670; CADANGAN</em>
                        @else
                            &#10005; TIDAK DITERIMA
                        @endif
                    </td>
                    <td style="font-size:8.5pt;">{{ $h->catatan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="center" style="padding:22px; font-style:italic; color:#666;">
                        Belum ada hasil perhitungan untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- KETERANGAN -->
    <div class="keterangan">
        <strong>Keterangan Metode Perhitungan:</strong>
        <p>
            &bull; Nilai akhir dihitung menggunakan metode SMART (Simple Multi-Attribute Rating Technique).<br>
            &bull; Normalisasi nilai: Benefit = (nilai &minus; min) / (max &minus; min) &nbsp;|&nbsp; Cost = (max
            &minus; nilai) / (max &minus; min).<br>
            &bull; Ranking ditentukan berdasarkan nilai akhir dari yang tertinggi ke terendah.<br>
            &bull; Status kelulusan ditentukan berdasarkan kuota dan/atau passing grade yang telah ditetapkan panitia.
        </p>
    </div>

    <!-- TANDA TANGAN -->
    <div class="footer-section">
        <table class="ttd-table">
            <tr>
                <td class="ttd-kiri">
                    <strong>Catatan:</strong><br>
                    <small>
                        - Dokumen ini merupakan dokumen resmi hasil seleksi PSB.<br>
                        - Keputusan panitia bersifat mutlak dan tidak dapat diganggu gugat.
                    </small>
                </td>
                <td class="ttd-kanan">
                    Kota Cimahi, {{ now()->translatedFormat('d F Y') }}<br><br>
                    Ketua Panitia Penerimaan Santri Baru,<br><br>
                    <div class="ttd-space"></div>
                    <span class="ttd-name">( __________________________ )</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="catatan">
        Dokumen ini dicetak dari Sistem Informasi Penerimaan Santri Baru &bull;
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }} WIB
    </div>

</body>

</html>
