<!DOCTYPE html>
<html>
<head>
    <title>Daftar Jenis Sampah</title>
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
        img {
            max-width: 80px;
            height: auto;
        }
    </style>
</head>
<body>
    <h2>DAFTAR JENIS SAMPAH</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga Per Kilo (Rp)</th>
                <th>Deskripsi</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jenis_sampah as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ number_format($item->harga, 2, ',', '.') }}</td>
                <td>{{ $item->deskripsi }}</td>
                <td>
                    @if($item->foto)
                        <img src="{{ public_path('storage/' . $item->foto) }}" alt="Foto">
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Dokumen ini dicetak pada tanggal {{ date('d-m-Y H:i:s') }}
    </div>
</body>
</html>
