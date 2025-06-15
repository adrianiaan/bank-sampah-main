@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Riwayat Penarikan Saldo: {{ $user->name }}</h1>

        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Kembali</a>

        {{-- Hapus tombol Cetak PDF utama --}}
        {{-- <a href="{{ route('admin.saldo.riwayat.penarikan.pdf', $user->id) }}" class="btn btn-primary mb-3" target="_blank">Cetak PDF</a> --}}

        @if($riwayatPenarikan && $riwayatPenarikan->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal Penarikan</th>
                        <th>Saldo Sebelum Penarikan (Rp)</th>
                        <th>Jumlah Penarikan (Rp)</th>
                        <th>Saldo Setelah Penarikan (Rp)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayatPenarikan as $riwayat)
                        <tr>
                            <td>{{ $riwayat->tanggal_penarikan }}</td>
                            <td>{{ number_format($riwayat->saldo_sebelum, 2, ',', '.') }}</td>
                            <td>{{ number_format($riwayat->jumlah_penarikan, 2, ',', '.') }}</td>
                            <td>{{ number_format($riwayat->saldo_setelah, 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('admin.saldo.riwayat.penarikan.pdf', $riwayat->id) }}" class="btn btn-sm btn-primary" target="_blank">Cetak PDF</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada riwayat penarikan saldo.</p>
        @endif
    </div>
@endsection
