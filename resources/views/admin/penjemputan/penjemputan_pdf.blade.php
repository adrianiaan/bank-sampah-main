<!DOCTYPE html>
<html>
<head>
    <title>Daftar Jadwal Penjemputan</title>
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
    <h2>Daftar Jadwal Penjemputan</h2>
    <table>
        <thead>
            <tr>
                <th>Jadwal</th>
                <th>Status</th>
                <th>Lokasi Koordinat</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjemputan as $item)
            <tr>
                <td>{{ $item->jadwal }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->lokasi_koordinat }}</td>
                <td>{{ $item->alamat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Dokumen ini dicetak pada tanggal {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
    </div>
</body>
</html>
