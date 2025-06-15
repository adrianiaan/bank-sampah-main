<!DOCTYPE html>
<html>
<head>
    <title>Daftar Transaksi</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Daftar Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>Pengguna</th>
                <th>Jenis Sampah</th>
                <th>Berat (kg)</th>
                <th>Nilai Saldo</th>
                <th>Status Verifikasi</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $item)
            <tr>
                <td>{{ $item->user->name ?? 'N/A' }}</td>
                <td>{{ $item->jenis_sampah->nama ?? 'N/A' }}</td>
                <td>{{ $item->berat_kg }}</td>
                <td>{{ number_format($item->nilai_saldo, 2) }}</td>
                <td>{{ $item->status_verifikasi ?? 'Belum Verifikasi' }}</td>
                <td>{{ is_string($item->tanggal_transaksi) ? $item->tanggal_transaksi : $item->tanggal_transaksi->format('d-m-Y H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Dokumen ini dicetak pada tanggal {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
    </div>
</body>
</html>
