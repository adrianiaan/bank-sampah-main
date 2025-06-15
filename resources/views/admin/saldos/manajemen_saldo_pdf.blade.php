<!DOCTYPE html>
<html>
<head>
    <title>Daftar Manajemen Saldo</title>
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
    <h2>Daftar Manajemen Saldo</h2>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Jumlah Saldo</th>
                <th>Last Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($saldo as $item)
            <tr>
                <td>{{ $item->user->name ?? 'N/A' }}</td>
                <td>{{ number_format($item->jumlah_saldo, 2) }}</td>
                <td>{{ is_string($item->last_updated_at) ? $item->last_updated_at : $item->last_updated_at->format('d-m-Y H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Dokumen ini dicetak pada tanggal {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
    </div>
</body>
</html>
