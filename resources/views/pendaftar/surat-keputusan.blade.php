<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keputusan Kelulusan - {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        /* Base Reset */
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
            background-color: #f3f4f6;
            color: #000;
        }

        /* Kertas A4 */
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 10mm auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            box-sizing: border-box;
        }

        /* KOP SURAT BARU - FORMAL STYLE */
        .header-formal {
            border: 3px solid #000;
            background: linear-gradient(to bottom, #FFFF00 0%, #FFFF00 60%, #00FF00 60%, #00FF00 100%);
            padding: 15px;
            margin-bottom: 30px;
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

        .header-formal .location-info {
            font-size: 9pt;
            margin: 0 0 5px 0;
            line-height: 1.2;
        }

        .header-formal .regulation-info {
            font-size: 8pt;
            margin: 5px 0;
            line-height: 1.3;
        }

        .header-formal .bank-info {
            font-size: 9pt;
            font-weight: bold;
            margin: 5px 0;
            color: #c00;
        }

        .header-formal .npwp-info {
            font-size: 9pt;
            font-weight: bold;
            margin: 3px 0 0 0;
        }

        .header-formal .address-footer {
            font-size: 7pt;
            margin: 5px 0 0 0;
            line-height: 1.2;
        }

        /* Judul Surat */
        .letter-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .letter-title h2 {
            text-transform: uppercase;
            text-decoration: underline;
            margin: 0;
            font-size: 14pt;
        }

        .letter-number {
            margin: 5px 0 0 0;
            font-size: 11pt;
        }

        /* Isi Surat */
        .content {
            text-align: justify;
        }

        .data-table {
            margin-left: 30px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .data-table td {
            vertical-align: top;
            padding: 2px 0;
        }

        .label {
            width: 160px;
        }

        .sep {
            width: 20px;
            text-align: center;
        }

        .val {
            font-weight: bold;
        }

        /* Keputusan Box */
        .decision-box {
            text-align: center;
            margin: 30px 0;
            padding: 10px;
            border: 2px solid #000;
            font-weight: bold;
            font-size: 16pt;
            text-transform: uppercase;
        }

        /* Footer / Tanda Tangan */
        .footer-table {
            width: 100%;
            margin-top: 50px;
        }

        .signature-cell {
            width: 40%;
            text-align: center;
            float: right;
        }

        .signature-space {
            height: 80px;
        }

        /* Print Button */
        .no-print {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-family: sans-serif;
            font-size: 14px;
            cursor: pointer;
            border: none;
            display: inline-block;
        }

        .btn-back {
            background: #374151;
            color: white;
            margin-right: 10px;
        }

        .btn-print {
            background: #ea580c;
            color: white;
        }

        @media print {
            body {
                background: none;
                margin: 0;
                padding: 0;
            }

            .page {
                margin: 0;
                padding: 20mm;
                width: 100%;
                box-shadow: none;
                border: none;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="no-print">
        <button onclick="window.history.back()" class="btn btn-back">&larr; Kembali</button>
        <button onclick="window.print()" class="btn btn-print">Cetak Surat / Simpan PDF</button>
    </div>

    <div class="page">
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

        <div class="letter-title">
            <h2>SURAT KEPUTUSAN</h2>
            <p class="letter-number">Nomor: {{ $pendaftaran->no_pendaftaran }}/PSB/{{ date('Y') }}</p>
        </div>

        <div class="content">
            <p><strong>Perihal: PEMBERITAHUAN HASIL SELEKSI</strong></p>
            <br>
            <p>Kepada Yth,<br>
                Bapak/Ibu Orang Tua/Wali Calon Santri<br>
                di Tempat</p>

            <p><em>Assalamu'alaikum Warahmatullahi Wabarakatuh,</em></p>

            <p>Berdasarkan hasil seleksi administrasi, tes tulis, dan wawancara yang telah dilaksanakan pada periode
                <strong>{{ $pendaftaran->periode->nama_periode }}</strong>, Panitia Penerimaan Santri Baru
                {{ $pengaturan->nama_pesantren }} dengan ini memberitahukan bahwa:
            </p>

            <table class="data-table">
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td class="sep">:</td>
                    <td class="val" style="text-transform: uppercase;">
                        {{ $pendaftaran->pengguna->profil->nama_lengkap ?? $pendaftaran->pengguna->nama }}</td>
                </tr>
                <tr>
                    <td class="label">Nomor Pendaftaran</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $pendaftaran->no_pendaftaran }}</td>
                </tr>
                <tr>
                    <td class="label">Asal Sekolah</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $pendaftaran->asal_sekolah }}</td>
                </tr>
                <tr>
                    <td class="label">Nilai Akhir</td>
                    <td class="sep">:</td>
                    <td class="val">{{ number_format($pengumuman->nilai_akhir * 100, 2) }}</td>
                </tr>
            </table>

            <p>Dinyatakan:</p>

            <div class="decision-box">
                LULUS / DITERIMA
            </div>

            <p>Sebagai santri baru di {{ $pengaturan->nama_pesantren }} Tahun Ajaran
                {{ date('Y') }}/{{ date('Y') + 1 }}.</p>

            <p>Selanjutnya bagi calon santri yang dinyatakan diterima, <strong>WAJIB</strong> melakukan daftar ulang
                dengan ketentuan sebagai berikut:</p>
            <ol>
                <li>Membawa Surat Keputusan ini (dicetak).</li>
                <li>Menyerahkan berkas persyaratan fisik (KK, Akta, Ijazah/SKL) yang asli dan fotokopi.</li>
                <li>Menyelesaikan administrasi daftar ulang di sekretariat pondok.</li>
                <li>Batas waktu daftar ulang sampai dengan tanggal
                    <strong>{{ \Carbon\Carbon::parse($pendaftaran->periode->tanggal_selesai)->addDays(7)->translatedFormat('d F Y') }}</strong>.
                </li>
            </ol>

            <p>Demikian surat keputusan ini kami sampaikan. Keputusan panitia bersifat mutlak dan tidak dapat diganggu
                gugat.</p>

            <p><em>Wassalamu'alaikum Warahmatullahi Wabarakatuh.</em></p>
        </div>

        <table class="footer-table">
            <tr>
                <td style="width: 60%;"></td>
                <td class="signature-cell">
                    <p>Ditetapkan di: Kota Cimahi<br>
                        Pada Tanggal: {{ now()->translatedFormat('d F Y') }}</p>

                    <p style="margin-top: 15px;">Ketua Panitia PSB,</p>

                    <div class="signature-space"></div>

                    <p style="font-weight: bold; text-decoration: underline;">H. Ahmad Fauzi, S.Pd.I</p>
                    <p>NIP. 19800101 201001 1 001</p>
                </td>
            </tr>
        </table>

    </div>

</body>

</html>
