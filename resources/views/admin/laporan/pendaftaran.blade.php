<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Pendaftar</title>
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
            border-left: 4px solid #ea580c;
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
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 9pt;
        }
        .signature {
            margin-top: 50px;
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
        <h2 style="margin: 0; text-decoration: underline;">LAPORAN DATA PENDAFTAR</h2>
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
                <td><strong>Rentang Waktu</strong></td>
                <td>: {{ $periode->tanggal_mulai->format('d/m/Y') }} - {{ $periode->tanggal_selesai->format('d/m/Y') }}</td>
                <td><strong>Kuota Santri</strong></td>
                <td>: {{ $periode->kuota_santri }} Orang</td>
            </tr>
            <tr>
                <td><strong>Total Pendaftar</strong></td>
                <td>: {{ $totalPendaftar }} Orang</td>
                <td><strong>Sisa Kuota</strong></td>
                <td>: {{ $periode->kuota_santri - $totalPendaftar }} Orang</td>
            </tr>
        </table>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Rekapitulasi Status Verifikasi:</strong><br>
        <span class="badge badge-success">Terverifikasi: {{ $verified }}</span>
        <span class="badge badge-warning">Pending: {{ $pending }}</span>
        <span class="badge badge-danger">Ditolak: {{ $rejected }}</span>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 100px;">No. Pendaftaran</th>
                <th>Nama Lengkap</th>
                <th>NIK</th>
                <th>Asal Sekolah</th>
                <th style="width: 70px;">Rata Nilai</th>
                <th style="width: 90px;">Tgl Submit</th>
                <th style="width: 80px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendaftarans as $index => $p)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $p->no_pendaftaran }}</td>
                <td>{{ $p->pengguna->profil->nama_lengkap ?? $p->pengguna->nama }}</td>
                <td>{{ $p->pengguna->profil->nik ?? '-' }}</td>
                <td>{{ $p->asal_sekolah }}</td>
                <td style="text-align: center;">{{ $p->rata_nilai }}</td>
                <td style="text-align: center;">{{ $p->tanggal_submit->format('d/m/Y') }}</td>
                <td style="text-align: center;">
                    @if($p->status_verifikasi === 'diterima')
                        <span class="badge badge-success">Diterima</span>
                    @elseif($p->status_verifikasi === 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @else
                        <span class="badge badge-danger">Ditolak</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px; color: #6b7280;">
                    Belum ada data pendaftar untuk periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

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