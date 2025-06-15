<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Penarikan Saldo - {{ $user->name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 30px;
            color: #888;
        }
    </style>
</head>
<body>
    <h2>NOTA PENCAIRAN SALDO</h2>
    <p>Nama Pengguna: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <table>
        <thead>
            <tr>
                <th>Tanggal Penarikan</th>
                <th>Saldo Sebelum Penarikan (Rp)</th>
                <th>Jumlah Penarikan (Rp)</th>
                <th>Saldo Setelah Penarikan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $riwayat->tanggal_penarikan }}</td>
                <td>{{ number_format($riwayat->saldo_sebelum, 2, ',', '.') }}</td>
                <td>{{ number_format($riwayat->jumlah_penarikan, 2, ',', '.') }}</td>
                <td>{{ number_format($riwayat->saldo_setelah, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <div class="footer">
        Nota ini dicetak pada tanggal {{ date('d-m-Y H:i:s') }}
    </div>
</body>
</html>
