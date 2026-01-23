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

        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0;
            font-size: 9pt;
        }

        .info-box {
            background: #f3f4f6;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #10b981;
        }

        .info-box table {
            width: 100%;
        }

        .info-box td {
            padding: 3px 0;
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
            margin-top: 30px;
            text-align: right;
            font-size: 9pt;
        }

        .signature {
            margin-top: 50px;
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
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $pengaturan->nama_pesantren ?? 'Pondok Pesantren Al-Badru' }}</h1>
        <p>{{ $pengaturan->alamat ?? '' }}</p>
        <p>Telp: {{ $pengaturan->telepon ?? '' }} | Email: {{ $pengaturan->email ?? '' }}</p>
    </div>

    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="margin: 0; text-decoration: underline;">LAPORAN HASIL SELEKSI AKHIR</h2>
        <p style="margin: 5px 0;">{{ $periode->nama_periode }}</p>
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

    <div style="margin-top: 20px; padding: 10px; background: #fef3c7; border-left: 4px solid #f59e0b;">
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
