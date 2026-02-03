<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Kartu Peserta Ujian - {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #000;
            font-size: 12pt;
        }

        .card {
            width: 100%;
            border: 2px solid #000;
            padding: 20px;
            box-sizing: border-box;
        }

        /* HEADER FORMAL BARU */
        .header-formal {
            border: 3px solid #000;
            background: linear-gradient(to bottom, #FFFF00 0%, #FFFF00 60%, #00FF00 60%, #00FF00 100%);
            padding: 12px;
            margin-bottom: 20px;
            text-align: center;
        }

        .header-formal .main-title {
            font-size: 12pt;
            font-weight: bold;
            margin: 0 0 4px 0;
            line-height: 1.3;
            text-transform: uppercase;
        }

        .header-formal .sub-title {
            font-size: 10pt;
            font-weight: bold;
            margin: 0 0 6px 0;
            text-transform: uppercase;
        }

        .header-formal .regulation-info {
            font-size: 7pt;
            margin: 4px 0;
            line-height: 1.2;
        }

        .header-formal .bank-info {
            font-size: 8pt;
            font-weight: bold;
            margin: 4px 0;
            color: #c00;
        }

        .header-formal .npwp-info {
            font-size: 8pt;
            font-weight: bold;
            margin: 3px 0 0 0;
        }

        .header-formal .address-footer {
            font-size: 6.5pt;
            margin: 4px 0 0 0;
            line-height: 1.1;
        }

        /* Title */
        .card-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
            text-decoration: underline;
        }

        /* Content Layout */
        .content-wrapper {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
        }

        .photo-cell {
            width: 120px;
            vertical-align: top;
            padding-right: 20px;
            text-align: center;
        }

        .photo-box {
            width: 3cm;
            height: 4cm;
            border: 2px solid #000;
            display: block;
            object-fit: cover;
            margin: 0 auto;
        }

        .photo-placeholder {
            width: 3cm;
            height: 4cm;
            border: 2px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
            background: #f9fafb;
            margin: 0 auto;
        }

        .data-cell {
            vertical-align: top;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 0;
            font-size: 13px;
            vertical-align: top;
        }

        .label {
            width: 130px;
            font-weight: bold;
        }

        .separator {
            width: 15px;
            text-align: center;
        }

        .value {
            font-weight: normal;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            width: 100%;
        }

        .footer-table {
            width: 100%;
        }

        .qr-cell {
            width: 60%;
            vertical-align: bottom;
            font-size: 10px;
            color: #555;
        }

        .signature-cell {
            width: 40%;
            text-align: center;
            vertical-align: top;
            font-size: 12px;
        }

        .signature-space {
            height: 60px;
        }

        .signer-name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Notes */
        .notes {
            margin-top: 20px;
            border: 1px dashed #555;
            padding: 10px;
            font-size: 10px;
            background-color: #fafafa;
        }

        .notes h4 {
            margin: 0 0 5px 0;
            font-size: 11px;
        }

        .notes ul {
            margin: 0;
            padding-left: 15px;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <div class="card">
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
                Sekretariat : Jalan Budhi RT 002 RW 004 Kel. Pasirkaliki Kec. Cimahi Utara Kota Cimahi No.Hp. 081842682
                / 082126428817 Kode Pos
            </div>
        </div>

        <h2 class="card-title">KARTU PESERTA UJIAN</h2>

        <table class="content-table">
            <tr>
                <td class="photo-cell">
                    @php
                        $fotoPath = null;
                        if ($pendaftaran->pengguna->profil && $pendaftaran->pengguna->profil->foto) {
                            $path = public_path('storage/' . $pendaftaran->pengguna->profil->foto);
                            if (file_exists($path)) {
                                $fotoPath = $path;
                            }
                        }
                    @endphp

                    @if ($fotoPath)
                        <img src="{{ $fotoPath }}" alt="Foto Peserta" class="photo-box">
                    @else
                        <div class="photo-placeholder">
                            FOTO 3x4
                        </div>
                    @endif
                </td>

                <td class="data-cell">
                    <table class="info-table">
                        <tr>
                            <td class="label">No. Pendaftaran</td>
                            <td class="separator">:</td>
                            <td class="value" style="font-size: 14px; font-weight: bold;">
                                {{ $pendaftaran->no_pendaftaran }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Nama Lengkap</td>
                            <td class="separator">:</td>
                            <td class="value" style="text-transform: uppercase;">
                                {{ $pendaftaran->pengguna->profil->nama_lengkap ?? $pendaftaran->pengguna->nama }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label">NISN / NIK</td>
                            <td class="separator">:</td>
                            <td class="value">{{ $pendaftaran->pengguna->profil->nik ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tempat, Tgl Lahir</td>
                            <td class="separator">:</td>
                            <td class="value">
                                {{ $pendaftaran->pengguna->profil->tempat_lahir ?? '' }},
                                {{ $pendaftaran->pengguna->profil ? $pendaftaran->pengguna->profil->tanggal_lahir->format('d F Y') : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Asal Sekolah</td>
                            <td class="separator">:</td>
                            <td class="value">{{ $pendaftaran->asal_sekolah }}</td>
                        </tr>
                        <tr>
                            <td class="label">Periode</td>
                            <td class="separator">:</td>
                            <td class="value">{{ $pendaftaran->periode->nama_periode }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="footer">
            <table class="footer-table">
                <tr>
                    <td class="qr-cell">
                        <div style="border: 1px solid #ccc; padding: 5px; display: inline-block;">
                            <span
                                style="font-family: monospace; font-size: 14px; font-weight: bold; letter-spacing: 2px;">
                                {{ $pendaftaran->no_pendaftaran }}
                            </span>
                        </div>
                        <p style="margin-top: 5px; font-style: italic;">
                            Dicetak otomatis oleh sistem pada: {{ now()->format('d/m/Y H:i') }}
                        </p>
                    </td>
                    <td class="signature-cell">
                        <p>Kota Cimahi, {{ now()->format('d F Y') }}</p>
                        <p>Panitia PSB,</p>
                        <div class="signature-space"></div>
                        <p class="signer-name">( _______________________ )</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="notes">
            <h4>TATA TERTIB UJIAN:</h4>
            <ul>
                <li>Kartu ini wajib dibawa (dicetak) saat pelaksanaan tes seleksi (Ujian Tulis & Wawancara).</li>
                <li>Peserta wajib hadir 30 menit sebelum ujian dimulai.</li>
                <li>Berpakaian rapi, sopan, dan menutup aurat (busana muslim/muslimah).</li>
                <li>Membawa alat tulis sendiri (Pensil 2B, Penghapus, Pulpen Hitam).</li>
                <li>Dilarang membawa alat komunikasi ke dalam ruang ujian.</li>
            </ul>
        </div>
    </div>
</body>

</html>
