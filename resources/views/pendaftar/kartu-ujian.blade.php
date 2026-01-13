<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Peserta Ujian - {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        /* Reset & Base */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #fff;
            color: #000;
        }

        /* Container Kartu */
        .card {
            width: 100%;
            max-width: 700px;
            /* Ukuran lebar standar kertas A4 potrait margin */
            margin: 0 auto;
            border: 2px solid #000;
            padding: 20px;
            position: relative;
        }

        /* Header */
        .header {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-table {
            width: 100%;
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
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        .institution-address {
            font-size: 12px;
            margin: 5px 0 0 0;
        }

        /* Title */
        .card-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 25px;
            text-decoration: underline;
        }

        /* Content Layout using Table */
        .content-table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Photo Section */
        .photo-cell {
            width: 140px;
            vertical-align: top;
            padding-right: 20px;
        }

        .photo-box {
            width: 3cm;
            /* Ukuran 3x4 cm */
            height: 4cm;
            border: 1px solid #000;
            display: block;
            object-fit: cover;
        }

        .photo-placeholder {
            width: 3cm;
            height: 4cm;
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            text-align: center;
            background: #f0f0f0;
        }

        /* Data Section */
        .data-cell {
            vertical-align: top;
        }

        .info-table {
            width: 100%;
        }

        .info-table td {
            padding: 5px 0;
            font-size: 14px;
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
            margin-top: 40px;
            width: 100%;
        }

        .footer-table {
            width: 100%;
        }

        .qr-cell {
            width: 50%;
            vertical-align: bottom;
            font-size: 10px;
            color: #555;
        }

        .signature-cell {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .signature-space {
            height: 70px;
        }

        .signer-name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Notes */
        .notes {
            margin-top: 30px;
            border: 1px dashed #555;
            padding: 10px;
            font-size: 11px;
            background-color: #fafafa;
        }

        .notes h4 {
            margin: 0 0 5px 0;
            font-size: 12px;
        }

        .notes ul {
            margin: 0;
            padding-left: 20px;
        }

        /* Print Settings */
        @media print {
            body {
                background: none;
                -webkit-print-color-adjust: exact;
            }

            .no-print {
                display: none;
            }

            .card {
                border: none;
                /* Hilangkan border luar saat print agar bersih */
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.history.back()"
            style="padding: 10px 20px; background: #333; color: #fff; border: none; cursor: pointer; border-radius: 5px;">
            &larr; Kembali
        </button>
        <button onclick="window.print()"
            style="padding: 10px 20px; background: #ea580c; color: #fff; border: none; cursor: pointer; border-radius: 5px; margin-left: 10px;">
            Cetak Kartu
        </button>
    </div>

    <div class="card">
        <div class="header">
            <table class="header-table">
                <tr>
                    <td class="logo-cell">
                        @php
                            // Menggunakan public_path agar bisa dibaca oleh DOMPDF jika nanti di-convert
                            // Jika hanya browser print, asset() sudah cukup.
                            $logoPath = $pengaturan->logo
                                ? asset('storage/' . $pengaturan->logo)
                                : 'https://via.placeholder.com/70';
                        @endphp
                        <img src="{{ $logoPath }}" alt="Logo" class="logo">
                    </td>
                    <td class="text-cell">
                        <h1 class="institution-name">{{ $pengaturan->nama_pesantren ?? 'Pondok Pesantren Al-Badru' }}
                        </h1>
                        <p class="institution-address">
                            {{ $pengaturan->alamat ?? 'Alamat Pesantren Belum Diatur' }} <br>
                            Telp: {{ $pengaturan->telepon ?? '-' }} | Email: {{ $pengaturan->email ?? '-' }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>

        <h2 class="card-title">KARTU PESERTA UJIAN</h2>

        <table class="content-table">
            <tr>
                <td class="photo-cell">
                    @if ($pendaftaran->pengguna->profil && $pendaftaran->pengguna->profil->foto)
                        <img src="{{ asset('storage/' . $pendaftaran->pengguna->profil->foto) }}" alt="Foto Peserta"
                            class="photo-box">
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
                            <td class="value" style="font-size: 16px; font-weight: bold;">
                                {{ $pendaftaran->no_pendaftaran }}</td>
                        </tr>
                        <tr>
                            <td class="label">Nama Lengkap</td>
                            <td class="separator">:</td>
                            <td class="value" style="text-transform: uppercase;">
                                {{ $pendaftaran->pengguna->profil->nama_lengkap ?? $pendaftaran->pengguna->nama }}</td>
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
                                style="font-family: 'Courier New', monospace; font-size: 14px; font-weight: bold; letter-spacing: 2px;">
                                {{ $pendaftaran->no_pendaftaran }}
                            </span>
                        </div>
                        <p style="margin-top: 5px;">Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
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
                <li>Kartu ini wajib dibawa saat pelaksanaan tes seleksi (Ujian Tulis & Wawancara).</li>
                <li>Peserta wajib hadir 30 menit sebelum ujian dimulai.</li>
                <li>Berpakaian rapi, sopan, dan menutup aurat (busana muslim/muslimah).</li>
                <li>Membawa alat tulis sendiri (Pensil 2B, Penghapus, Pulpen Hitam).</li>
                <li>Dilarang membawa alat komunikasi ke dalam ruang ujian.</li>
            </ul>
        </div>

    </div>

</body>

</html>
