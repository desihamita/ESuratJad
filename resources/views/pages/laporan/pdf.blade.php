<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Dosen</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #000;
            text-align: left;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Laporan Data Dosen</h2>
    <p>Periode: {{ $start_date ?? 'Semua Tanggal' }} - {{ $end_date ?? 'Semua Tanggal' }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan Akademik Sebelumnya</th>
                <th>Jabatan Akademik Diusulkan</th>
                <th>Tanggal Proses</th>
                <th>Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $d)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $d->nama_dosen }}</td>
                    <td>{{ $d->jabatan_akademik_sebelumnya }}</td>
                    <td>{{ $d->jabatan_akademik_di_usulkan }}</td>
                    <td>{{ $d->tanggal_proses }}</td>
                    <td>{{ $d->tanggal_selesai }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
