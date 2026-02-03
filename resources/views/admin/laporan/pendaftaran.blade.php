<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Pendaftar</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            margin: 20px;
            line-height: 1.4;
        }

        /* HEADER FORMAL */
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

        /* TITLE */
        .report-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .report-title h2 {
            margin: 0 0 5px 0;
            text-decoration: underline;
            font-size: 14pt;
            text-transform: uppercase;
        }

        .report-title p {
            margin: 0;
            font-size: 12pt;
        }

        /* INFO TABLE */
        .info-section {
            margin-bottom: 25px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px 10px;
            font-size: 11pt;
            vertical-align: top;
        }

        .info-table .label-cell {
            width: 180px;
            font-weight: normal;
        }

        .info-table .separator {
            width: 15px;
        }

        /* DATA TABLE - FORMAL STYLE */
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table.data th {
            border: 1px solid #000;
            padding: 8px 6px;
            font-size: 10pt;
            font-weight: bold;
            text-align: center;
            background: #fff;
        }

        table.data td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 10pt;
            vertical-align: top;
        }

        table.data td.text-center {
            text-align: center;
        }

        table.data td.text-right {
            text-align: right;
        }

        /* FOOTER */
        .footer {
            margin-top: 40px;
        }

        .footer-table {
            width: 100%;
        }

        .signature-section {
            text-align: center;
        }

        .signature-space {
            height: 70px;
        }

        .signer-name {
            font-weight: bold;
            text-decoration: underline;
        }

        @media print {
            body {
                margin: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- HEADER FORMAL -->
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

    <!-- TITLE -->
    <div class="report-title">
        <h2>LAPORAN DATA PENDAFTAR</h2>
        <p>{{ $periode->nama_periode }}</p>
    </div>

    <!-- INFO SECTION -->
    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="label-cell">Periode Pendaftaran</td>
                <td class="separator">:</td>
                <td>{{ $periode->nama_periode }}</td>
            </tr>
            <tr>
                <td class="label-cell">Tanggal Cetak</td>
                <td class="separator">:</td>
                <td>{{ now()->format('d F Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td class="label-cell">Rentang Waktu Pendaftaran</td>
                <td class="separator">:</td>
                <td>{{ $periode->tanggal_mulai->format('d F Y') }} s/d {{ $periode->tanggal_selesai->format('d F Y') }}
                </td>
            </tr>
            <tr>
                <td class="label-cell">Kuota Santri</td>
                <td class="separator">:</td>
                <td>{{ $periode->kuota_santri }} Orang</td>
            </tr>
            <tr>
                <td class="label-cell">Total Pendaftar</td>
                <td class="separator">:</td>
                <td>{{ $totalPendaftar }} Orang</td>
            </tr>
            <tr>
                <td class="label-cell">Sisa Kuota</td>
                <td class="separator">:</td>
                <td>{{ $periode->kuota_santri - $totalPendaftar }} Orang</td>
            </tr>
            <tr>
                <td class="label-cell">Status Terverifikasi</td>
                <td class="separator">:</td>
                <td>{{ $verified }} Orang</td>
            </tr>
            <tr>
                <td class="label-cell">Status Pending</td>
                <td class="separator">:</td>
                <td>{{ $pending }} Orang</td>
            </tr>
            <tr>
                <td class="label-cell">Status Ditolak</td>
                <td class="separator">:</td>
                <td>{{ $rejected }} Orang</td>
            </tr>
        </table>
    </div>

    <!-- DATA TABLE -->
    <table class="data">
        <thead>
            <tr>
                <th style="width: 35px;">No.</th>
                <th style="width: 110px;">No. Pendaftaran</th>
                <th>Nama Lengkap</th>
                <th style="width: 130px;">NIK</th>
                <th>Asal Sekolah</th>
                <th style="width: 60px;">Rata-rata Nilai</th>
                <th style="width: 90px;">Tanggal Submit</th>
                <th style="width: 100px;">Status Verifikasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendaftarans as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->no_pendaftaran }}</td>
                    <td>{{ $p->pengguna->profil->nama_lengkap ?? $p->pengguna->nama }}</td>
                    <td class="text-center">{{ $p->pengguna->profil->nik ?? '-' }}</td>
                    <td>{{ $p->asal_sekolah }}</td>
                    <td class="text-center">{{ $p->rata_nilai }}</td>
                    <td class="text-center">{{ $p->tanggal_submit->format('d/m/Y') }}</td>
                    <td class="text-center">
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
                    <td colspan="8" style="text-align: center; padding: 20px;">
                        Belum ada data pendaftar untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td style="width: 55%;"></td>
                <td style="width: 45%;">
                    <div class="signature-section">
                        <p>Kota Cimahi, {{ now()->format('d F Y') }}</p>
                        <p>Ketua Panitia PSB,</p>
                        <div class="signature-space"></div>
                        <p class="signer-name">_______________________</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
