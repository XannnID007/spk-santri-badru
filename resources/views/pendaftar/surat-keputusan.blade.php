<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Surat Keputusan Kelulusan - {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            color: #000;
            background: #fff;
            padding: 22px 28px;
            line-height: 1.6;
        }

        /* ===== KOP SURAT — 3 kolom native table ===== */
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

        /* ===== GARIS BATAS BAWAH KOP ===== */
        .batas-bawah-kop {
            border-top: 2px solid #000;
            margin: 0 0 20px 0;
        }

        /* ===== AREA ISI SURAT — margin kiri kanan ===== */
        .isi-surat-wrapper {
            margin: 0 18px;
        }

        /* ===== JUDUL ===== */
        .judul-surat {
            text-align: center;
            margin: 0 0 22px 0;
        }

        .judul-surat h2 {
            font-family: "Times New Roman", Times, serif;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .nomor-surat {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            margin-top: 6px;
        }

        /* ===== ISI SURAT ===== */
        .surat-content {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            text-align: justify;
            line-height: 1.7;
        }

        .surat-content p,
        .surat-content div,
        .surat-content li {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
        }

        .perihal-block {
            margin-bottom: 18px;
        }

        .kepada-block {
            margin-bottom: 18px;
            line-height: 1.9;
        }

        .p-indent {
            text-indent: 40px;
            margin-bottom: 14px;
        }

        /* ===== DATA PESERTA ===== */
        .data-peserta {
            margin: 14px 0 18px 40px;
            border-left: 3px solid #000;
            padding-left: 16px;
        }

        .dp-table {
            border-collapse: collapse;
        }

        .dp-table td {
            padding: 4px 0;
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            vertical-align: top;
        }

        .dp-label {
            width: 185px;
        }

        .dp-sep {
            width: 20px;
            text-align: center;
        }

        .dp-val {
            font-weight: bold;
        }

        /* ===== KOTAK KEPUTUSAN ===== */
        .keputusan-wrapper {
            text-align: center;
            margin: 22px 0;
        }

        .keputusan-box {
            display: inline-block;
            border: 2.5px solid #000;
            padding: 14px 52px;
        }

        .kep-main {
            font-family: "Times New Roman", Times, serif;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .kep-sub {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            margin-top: 8px;
            border-top: 1px solid #000;
            padding-top: 6px;
        }

        /* ===== SYARAT ===== */
        .syarat-list {
            margin: 12px 0 14px 54px;
        }

        .syarat-list li {
            margin-bottom: 7px;
            line-height: 1.7;
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
        }

        /* ===== GARIS BATAS ATAS FOOTER ===== */
        .batas-atas-footer {
            border-top: 2px solid #000;
            margin: 28px 0 0 0;
        }

        /* ===== TANDA TANGAN ===== */
        .ttd-section {
            padding-top: 16px;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ttd-kiri {
            width: 55%;
            vertical-align: top;
            font-family: "Times New Roman", Times, serif;
            font-size: 10pt;
            color: #444;
        }

        .ttd-kanan {
            width: 45%;
            text-align: center;
            vertical-align: top;
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
        }

        .ttd-space {
            height: 76px;
        }

        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <!-- KOP SURAT -->
    <table class="kop-surat" cellspacing="0" cellpadding="0">
        <tr>
            <td class="kop-col-logo">
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

    <!-- GARIS BATAS BAWAH KOP -->
    <div class="batas-bawah-kop"></div>

    <!-- WRAPPER MARGIN ISI SURAT -->
    <div class="isi-surat-wrapper">

        <!-- JUDUL SURAT -->
        <div class="judul-surat">
            <h2>Surat Keputusan Kelulusan</h2>
            <div class="nomor-surat">
                Nomor: {{ $pendaftaran->no_pendaftaran }}/PSB/{{ date('Y') }}
            </div>
        </div>

        <!-- ISI SURAT -->
        <div class="surat-content">

            <div class="perihal-block">
                <strong>Perihal: PEMBERITAHUAN HASIL SELEKSI PENERIMAAN SANTRI BARU</strong>
            </div>

            <div class="kepada-block">
                Kepada Yth,<br>
                Bapak/Ibu Orang Tua/Wali Calon Santri<br>
                di&nbsp;&nbsp;Tempat
            </div>

            <p style="font-style:italic; margin-bottom:16px;">
                <em>Assalamu'alaikum Warahmatullahi Wabarakatuh,</em>
            </p>

            <p class="p-indent">
                Dengan mengucapkan puji dan syukur ke hadirat Allah SWT, Panitia Penerimaan Santri Baru (PSB)
                {{ $pengaturan->nama_pesantren ?? 'Yayasan Badru Pasirkaliki' }}
                telah melaksanakan proses seleksi untuk periode
                <strong>{{ $pendaftaran->periode->nama_periode }}</strong>.
            </p>

            <p class="p-indent">
                Berdasarkan hasil seleksi administrasi, tes tulis, dan wawancara yang telah dilaksanakan,
                Panitia PSB menyatakan bahwa peserta dengan identitas sebagai berikut:
            </p>

            <div class="data-peserta">
                <table class="dp-table">
                    <tr>
                        <td class="dp-label">Nama Lengkap</td>
                        <td class="dp-sep">:</td>
                        <td class="dp-val" style="text-transform:uppercase;">
                            {{ $pendaftaran->pengguna->profil->nama_lengkap ?? $pendaftaran->pengguna->nama }}
                        </td>
                    </tr>
                    <tr>
                        <td class="dp-label">Nomor Pendaftaran</td>
                        <td class="dp-sep">:</td>
                        <td class="dp-val">{{ $pendaftaran->no_pendaftaran }}</td>
                    </tr>
                    <tr>
                        <td class="dp-label">Asal Sekolah</td>
                        <td class="dp-sep">:</td>
                        <td class="dp-val">{{ $pendaftaran->asal_sekolah }}</td>
                    </tr>
                    @if ($pendaftaran->pengguna->profil)
                        <tr>
                            <td class="dp-label">Tempat, Tgl. Lahir</td>
                            <td class="dp-sep">:</td>
                            <td class="dp-val">
                                {{ $pendaftaran->pengguna->profil->tempat_lahir }},
                                {{ $pendaftaran->pengguna->profil->tanggal_lahir->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td class="dp-label">Nilai Akhir Seleksi</td>
                        <td class="dp-sep">:</td>
                        <td class="dp-val">{{ number_format($pengumuman->nilai_akhir * 100, 2) }} (Skala 100)</td>
                    </tr>
                </table>
            </div>

            <p style="margin-bottom:10px;">Dinyatakan:</p>

            <div class="keputusan-wrapper">
                <div class="keputusan-box">
                    <div class="kep-main">LULUS / DITERIMA</div>
                    <div class="kep-sub">
                        Sebagai Santri Baru Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}
                    </div>
                </div>
            </div>

            <p class="p-indent">
                di <strong>{{ $pengaturan->nama_pesantren ?? 'Yayasan Badru Pasirkaliki' }}</strong>
                Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}.
            </p>

            <p class="p-indent">
                Selanjutnya, bagi calon santri yang dinyatakan <strong>diterima</strong>,
                <u>WAJIB</u> melakukan daftar ulang dengan ketentuan sebagai berikut:
            </p>

            <ol class="syarat-list">
                <li>Membawa dan menunjukkan Surat Keputusan ini (dalam bentuk cetakan/<em>print</em>).</li>
                <li>Menyerahkan berkas persyaratan fisik (KK, Akta Kelahiran, Ijazah/SKL) asli beserta fotokopinya.</li>
                <li>Menyelesaikan seluruh administrasi daftar ulang di Sekretariat Pondok.</li>
                <li>
                    Batas waktu daftar ulang sampai dengan tanggal
                    <strong>{{ \Carbon\Carbon::parse($pendaftaran->periode->tanggal_selesai)->addDays(7)->translatedFormat('d F Y') }}</strong>.
                </li>
                <li>
                    Bagi yang tidak melakukan daftar ulang sampai batas waktu yang ditentukan,
                    dianggap <strong>mengundurkan diri</strong>.
                </li>
            </ol>

            <p class="p-indent">
                Demikian Surat Keputusan ini disampaikan. Keputusan Panitia bersifat mutlak dan tidak dapat
                diganggu gugat. Atas perhatian dan kerja samanya, kami ucapkan terima kasih.
            </p>

            <p style="font-style:italic; margin-top:12px;">
                <em>Wassalamu'alaikum Warahmatullahi Wabarakatuh.</em>
            </p>

        </div><!-- end surat-content -->

    </div><!-- end isi-surat-wrapper -->

    <!-- GARIS BATAS ATAS FOOTER -->
    <div class="batas-atas-footer"></div>

    <!-- TANDA TANGAN -->
    <div class="ttd-section">
        <table class="ttd-table">
            <tr>
                <td class="ttd-kiri">
                    Dokumen ini diterbitkan secara resmi oleh<br>
                    Sistem Informasi PSB Yayasan Badru Pasirkaliki.<br>
                    Dicetak: {{ now()->translatedFormat('d F Y') }},
                    Pukul {{ now()->format('H:i') }}&nbsp;WIB
                </td>
                <td class="ttd-kanan">
                    Ditetapkan di&nbsp;: Kota Cimahi<br>
                    Pada Tanggal&nbsp;&nbsp;: {{ now()->translatedFormat('d F Y') }}<br><br>
                    Ketua Panitia Penerimaan Santri Baru,<br><br>
                    <div class="ttd-space"></div>
                    <span class="ttd-name">( __________________________ )</span>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
