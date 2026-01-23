<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Kartu Peserta Ujian - {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        /* Reset & Base */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            /* Padding dihilangkan karena diatur oleh @page */
            background-color: #fff;
            color: #000;
            font-size: 12pt;
        }

        /* Container Kartu - Border dihapus untuk PDF clean, border bisa diatur di content */
        .card {
            width: 100%;
            border: 2px solid #000;
            padding: 20px;
            box-sizing: border-box;
            /* Penting agar padding tidak melebarkan width */
        }

        /* Header */
        .header {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header-table {
            width: 100%;
            border: none;
        }

        .logo-cell {
            width: 80px;
            vertical-align: middle;
            text-align: center;
        }

        .logo {
            width: 70px;
            height: auto;
        }

        .text-cell {
            text-align: center;
            vertical-align: middle;
        }

        .institution-name {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        .institution-address {
            font-size: 11px;
            margin: 5px 0 0 0;
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

        /* Content Layout using Table */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        /* Photo Section */
        .photo-cell {
            width: 3.5cm;
            vertical-align: top;
            padding-right: 15px;
        }

        .photo-box {
            width: 3cm;
            height: 4cm;
            border: 1px solid #000;
            display: block;
            object-fit: cover;
        }

        .photo-placeholder {
            width: 3cm;
            height: 4cm;
            border: 1px solid #000;
            display: table-cell;
            /* Hack untuk vertical align text di div statis pdf */
            vertical-align: middle;
            text-align: center;
            font-size: 10px;
            background: #f0f0f0;
        }

        /* Data Section */
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

        /* Footer / Tanda Tangan */
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

        /* Page Break Prevention */
        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    {{-- HAPUS TOMBOL PRINT & BACK KARENA INI PDF --}}

    <div class="card">
        <div class="header">
            <table class="header-table">
                <tr>
                    <td class="logo-cell">
                        @php
                            // FIX: Gunakan public_path() agar DomPDF membaca file lokal, bukan URL HTTP
                            // Ini mencegah loading macet/timeout di localhost
                            $logoPath = null;
                            if ($pengaturan->logo && file_exists(public_path('storage/' . $pengaturan->logo))) {
                                $logoPath = public_path('storage/' . $pengaturan->logo);
                            }
                        @endphp

                        @if ($logoPath)
                            <img src="{{ $logoPath }}" alt="Logo" class="logo">
                        @else
                            {{-- Fallback jika logo tidak ditemukan --}}
                            <div style="font-weight:bold; border:1px solid #000; padding:5px;">LOGO</div>
                        @endif
                    </td>
                    <td class="text-cell">
                        <h1 class="institution-name">{{ $pengaturan->nama_pesantren ?? 'Pondok Pesantren Al-Badru' }}
                        </h1>
                        <p class="institution-address">
                            {{ $pengaturan->alamat_lengkap ?? 'Alamat Pesantren Belum Diatur' }} <br>
                            Telp: {{ $pengaturan->no_telp ?? '-' }} | Email: {{ $pengaturan->email ?? '-' }}
                        </p>
                    </td>
                </tr>
            </table>
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
