<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Data Pendaftar - {{ $periode->nama_periode }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            color: #000;
            background: #fff;
            line-height: 1.5;
            padding: 22px 28px;
        }

        /* ===== KOP SURAT =====
         * 3 kolom: logo | teks | dummy (sama lebar logo)
         * → teks selalu center sempurna
         */
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
            border: 1px solid #000;
            margin-bottom: 18px;
            width: 100%;
            border-collapse: collapse;
        }

        .info-block td {
            padding: 6px 14px;
            font-size: 10.5pt;
            vertical-align: top;
        }

        .info-block td.label {
            width: 195px;
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
            width: 175px;
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
            font-size: 10pt;
            font-weight: bold;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        table.data-table td {
            border: 1px solid #000;
            padding: 7px 6px;
            font-size: 10pt;
            vertical-align: top;
        }

        table.data-table tr:nth-child(even) td {
            background: #f7f7f7;
        }

        table.data-table td.center {
            text-align: center;
        }

        /* ===== FOOTER TTD ===== */
        .footer-section {
            margin-top: 32px;
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
        <div class="judul-utama">Laporan Data Pendaftar</div>
        <div class="judul-sub">{{ $periode->nama_periode }}</div>
    </div>

    <!-- INFO -->
    <table class="info-block">
        <tr>
            <td class="label">Periode Pendaftaran</td>
            <td class="sep">:</td>
            <td>{{ $periode->nama_periode }}</td>
            <td class="div-left">Tanggal Cetak</td>
            <td class="sep">:</td>
            <td>{{ now()->translatedFormat('d F Y') }}, Pukul {{ now()->format('H:i') }} WIB</td>
        </tr>
        <tr>
            <td class="label">Rentang Waktu Pendaftaran</td>
            <td class="sep">:</td>
            <td>{{ $periode->tanggal_mulai->translatedFormat('d F Y') }} s/d
                {{ $periode->tanggal_selesai->translatedFormat('d F Y') }}</td>
            <td class="div-left">Kuota Santri</td>
            <td class="sep">:</td>
            <td>{{ $periode->kuota_santri }} Orang</td>
        </tr>
        <tr>
            <td class="label">Total Pendaftar</td>
            <td class="sep">:</td>
            <td>{{ $totalPendaftar }} Orang</td>
            <td class="div-left">Sisa Kuota</td>
            <td class="sep">:</td>
            <td>{{ max(0, $periode->kuota_santri - $totalPendaftar) }} Orang</td>
        </tr>
    </table>

    <!-- REKAP -->
    <div class="rekap-wrapper">
        <div class="rekap-title">Rekapitulasi Status Verifikasi:</div>
        <table class="rekap-table">
            <tr>
                <td class="rl">Terverifikasi (Diterima)</td>
                <td>{{ $verified }} orang</td>
                <td class="rl">Status Pending</td>
                <td>{{ $pending }} orang</td>
                <td class="rl">Status Ditolak</td>
                <td>{{ $rejected }} orang</td>
            </tr>
        </table>
    </div>

    <!-- TABEL DATA -->
    <div class="section-title">Daftar Pendaftar:</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:40px;">No.</th>
                <th style="width:122px;">No. Pendaftaran</th>
                <th>Nama Lengkap</th>
                <th style="width:138px;">NIK</th>
                <th>Asal Sekolah</th>
                <th style="width:68px;">Nilai Rata</th>
                <th style="width:92px;">Tgl. Submit</th>
                <th style="width:112px;">Status Verifikasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendaftarans as $index => $p)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="center">{{ $p->no_pendaftaran }}</td>
                    <td>{{ $p->pengguna->profil->nama_lengkap ?? $p->pengguna->nama }}</td>
                    <td class="center">{{ $p->pengguna->profil->nik ?? '-' }}</td>
                    <td>{{ $p->asal_sekolah }}</td>
                    <td class="center">{{ $p->rata_nilai }}</td>
                    <td class="center">{{ $p->tanggal_submit->format('d/m/Y') }}</td>
                    <td class="center">
                        @if ($p->status_verifikasi === 'diterima')
                            Terverifikasi
                        @elseif($p->status_verifikasi === 'pending')
                            Pending
                        @else
                            Ditolak
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="center" style="padding:22px; font-style:italic; color:#666;">
                        Belum ada data pendaftar untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"
                    style="text-align:right; font-weight:bold; padding:7px 10px; border:1px solid #000; background:#f0f0f0;">
                    Total Pendaftar
                </td>
                <td colspan="3"
                    style="font-weight:bold; text-align:center; padding:7px; border:1px solid #000; background:#f0f0f0;">
                    {{ $totalPendaftar }} Orang
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- TANDA TANGAN -->
    <div class="footer-section">
        <table class="ttd-table">
            <tr>
                <td class="ttd-kiri">
                    <strong>Catatan:</strong><br>
                    <small>
                        - Dokumen ini dicetak secara otomatis oleh Sistem Informasi PSB.<br>
                        - Keabsahan dokumen dapat diverifikasi melalui sistem.
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
