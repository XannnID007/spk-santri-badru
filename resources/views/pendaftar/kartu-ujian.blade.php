<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Kartu Peserta Ujian - {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            color: #000;
            background: #fff;
            padding: 22px 28px;
        }

        /* ===== KOP SURAT ===== */
        .kop-surat {
            border: 3px solid #000;
            margin-bottom: 20px;
        }

        .kop-inner {
            display: table;
            width: 100%;
            background: linear-gradient(to bottom, #FFFF00 0%, #FFFF00 60%, #00FF00 60%, #00FF00 100%);
        }

        .kop-logo-cell {
            display: table-cell;
            width: 100px;
            vertical-align: middle;
            text-align: center;
            padding: 12px 10px 12px 14px;
        }

        .kop-logo-cell img {
            width: 72px;
            height: 72px;
            object-fit: contain;
        }

        .kop-logo-placeholder {
            width: 72px;
            height: 72px;
            border: 2px solid #333;
            display: inline-block;
            line-height: 72px;
            font-size: 8pt;
            font-weight: bold;
            background: rgba(255, 255, 255, 0.55);
            text-align: center;
        }

        .kop-text-cell {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding: 12px 8px;
        }

        .kop-text-cell .main-title {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.35;
            margin-bottom: 3px;
        }

        .kop-text-cell .sub-title {
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .kop-text-cell .regulation-info {
            font-size: 7pt;
            line-height: 1.4;
            margin-bottom: 3px;
        }

        .kop-text-cell .bank-info {
            font-size: 8pt;
            font-weight: bold;
            color: #c00000;
            margin-bottom: 2px;
        }

        .kop-text-cell .npwp-info {
            font-size: 8pt;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .kop-text-cell .address-footer {
            font-size: 6.5pt;
            line-height: 1.3;
        }

        .kop-spacer {
            display: table-cell;
            width: 100px;
        }

        /* ===== JUDUL ===== */
        .judul-kartu {
            text-align: center;
            margin: 0 0 18px 0;
        }

        .judul-kartu h2 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            letter-spacing: 1.5px;
        }

        .judul-kartu .periode {
            font-size: 10.5pt;
            margin-top: 4px;
        }

        /* ===== KONTEN UTAMA ===== */
        .konten-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .foto-cell {
            width: 120px;
            vertical-align: top;
            padding-right: 18px;
        }

        .foto-box {
            width: 95px;
            height: 125px;
            border: 2px solid #000;
            overflow: hidden;
        }

        .foto-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .data-cell {
            vertical-align: top;
        }

        /* No. Pendaftaran highlight */
        .no-pendaftaran-box {
            background: #000;
            color: #fff;
            padding: 7px 14px;
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 2.5px;
            margin-bottom: 12px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px 0;
            font-size: 10.5pt;
            vertical-align: top;
            line-height: 1.5;
        }

        .info-table td.label {
            width: 140px;
            font-weight: bold;
        }

        .info-table td.sep {
            width: 15px;
        }

        .info-table tr+tr td {
            border-top: 1px dotted #bbb;
            padding-top: 5px;
        }

        /* ===== TANDA TANGAN ===== */
        .ttd-wrapper {
            border-top: 1px solid #000;
            padding-top: 12px;
            margin-top: 8px;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ttd-kiri {
            width: 60%;
            vertical-align: bottom;
            font-size: 9pt;
            color: #444;
        }

        .ttd-kanan {
            width: 40%;
            text-align: center;
            vertical-align: top;
            font-size: 10.5pt;
        }

        .ttd-space {
            height: 56px;
        }

        .ttd-name {
            font-weight: bold;
        }

        .barcode-area {
            border: 1px solid #aaa;
            padding: 5px 12px;
            display: inline-block;
            font-family: monospace;
            font-size: 13pt;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .cetak-info {
            font-style: italic;
            margin-top: 5px;
            font-size: 8pt;
            color: #666;
        }

        /* ===== TATA TERTIB ===== */
        .tata-tertib {
            margin-top: 16px;
            border: 1.5px dashed #555;
            padding: 12px 16px;
            background: #fafafa;
        }

        .tata-tertib h4 {
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .tata-tertib ol {
            margin: 0;
            padding-left: 20px;
        }

        .tata-tertib ol li {
            font-size: 9.5pt;
            margin-bottom: 4px;
            line-height: 1.5;
        }
    </style>
</head>

<body>

    <!-- KOP SURAT -->
    <div class="kop-surat">
        <div class="kop-inner">
            <div class="kop-logo-cell">
                @php
                    $logoPath = null;
                    if ($pengaturan && $pengaturan->logo) {
                        $path = public_path('storage/' . $pengaturan->logo);
                        if (file_exists($path)) {
                            $logoPath = $path;
                        }
                    }
                @endphp
                @if ($logoPath)
                    <img src="{{ $logoPath }}" alt="Logo">
                @else
                    <div class="kop-logo-placeholder">LOGO</div>
                @endif
            </div>

            <div class="kop-text-cell">
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
            </div>

            <div class="kop-spacer"></div>
        </div>
    </div>

    <!-- JUDUL KARTU -->
    <div class="judul-kartu">
        <h2>Kartu Peserta Ujian</h2>
        <div class="periode">{{ $pendaftaran->periode->nama_periode }}</div>
    </div>

    <!-- KONTEN: FOTO + DATA -->
    <table class="konten-table">
        <tr>
            <td class="foto-cell">
                @php
                    $fotoPath = null;
                    if ($pendaftaran->pengguna->profil && $pendaftaran->pengguna->profil->foto) {
                        $path = public_path('storage/' . $pendaftaran->pengguna->profil->foto);
                        if (file_exists($path)) {
                            $fotoPath = $path;
                        }
                    } elseif ($pendaftaran->file_foto) {
                        $path = public_path('storage/' . $pendaftaran->file_foto);
                        if (file_exists($path)) {
                            $fotoPath = $path;
                        }
                    }
                @endphp

                @if ($fotoPath)
                    <div class="foto-box">
                        <img src="{{ $fotoPath }}" alt="Foto Peserta">
                    </div>
                @else
                    <table style="width:95px; height:125px; border:2px solid #000; border-collapse:collapse;">
                        <tr>
                            <td
                                style="text-align:center; vertical-align:middle; font-size:9pt; font-weight:bold; color:#555; background:#f5f5f5;">
                                FOTO<br>3 × 4
                            </td>
                        </tr>
                    </table>
                @endif
                <div style="text-align:center; font-size:8pt; margin-top:5px; color:#555;">Pas Foto Terbaru</div>
            </td>

            <td class="data-cell">
                <!-- Nomor Pendaftaran -->
                <div class="no-pendaftaran-box">
                    {{ $pendaftaran->no_pendaftaran }}
                </div>

                <table class="info-table">
                    <tr>
                        <td class="label">Nama Lengkap</td>
                        <td class="sep">:</td>
                        <td style="text-transform:uppercase; font-weight:bold;">
                            {{ $pendaftaran->pengguna->profil->nama_lengkap ?? $pendaftaran->pengguna->nama }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label">NISN / NIK</td>
                        <td class="sep">:</td>
                        <td>{{ $pendaftaran->pengguna->profil->nik ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tempat, Tgl. Lahir</td>
                        <td class="sep">:</td>
                        <td>
                            {{ $pendaftaran->pengguna->profil->tempat_lahir ?? '-' }},
                            {{ $pendaftaran->pengguna->profil ? $pendaftaran->pengguna->profil->tanggal_lahir->translatedFormat('d F Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Jenis Kelamin</td>
                        <td class="sep">:</td>
                        <td>
                            @if (isset($pendaftaran->pengguna->profil->jenis_kelamin))
                                {{ $pendaftaran->pengguna->profil->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Asal Sekolah</td>
                        <td class="sep">:</td>
                        <td>{{ $pendaftaran->asal_sekolah }}</td>
                    </tr>
                    <tr>
                        <td class="label">Periode</td>
                        <td class="sep">:</td>
                        <td>{{ $pendaftaran->periode->nama_periode }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal Daftar</td>
                        <td class="sep">:</td>
                        <td>{{ $pendaftaran->tanggal_submit->translatedFormat('d F Y') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- TANDA TANGAN -->
    <div class="ttd-wrapper">
        <table class="ttd-table">
            <tr>
                <td class="ttd-kiri">
                    <div class="barcode-area">{{ $pendaftaran->no_pendaftaran }}</div>
                    <div class="cetak-info">
                        Dicetak otomatis: {{ now()->format('d/m/Y H:i') }} WIB
                    </div>
                </td>
                <td class="ttd-kanan">
                    Kota Cimahi, {{ now()->translatedFormat('d F Y') }}<br>
                    Panitia Penerimaan Santri Baru,<br>
                    <div class="ttd-space"></div>
                    <span class="ttd-name">( _______________________ )</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- TATA TERTIB -->
    <div class="tata-tertib">
        <h4>&#9632; Tata Tertib Ujian Seleksi</h4>
        <ol>
            <li>Kartu ini <strong>WAJIB DIBAWA</strong> dan ditunjukkan kepada panitia saat pelaksanaan tes seleksi
                (Ujian Tulis &amp; Wawancara).</li>
            <li>Peserta wajib hadir di lokasi ujian <strong>30 menit</strong> sebelum ujian dimulai.</li>
            <li>Berpakaian rapi, sopan, dan menutup aurat (busana muslim/muslimah).</li>
            <li>Membawa alat tulis sendiri: Pensil 2B, Penghapus, dan Pulpen Hitam.</li>
            <li>Dilarang membawa dan menggunakan alat komunikasi di dalam ruang ujian.</li>
            <li>Peserta yang datang terlambat lebih dari 15 menit tidak diperkenankan mengikuti ujian.</li>
        </ol>
    </div>

</body>

</html>
