@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Saldo Anda</h1>

        @if($saldo)
            <p>Jumlah Saldo: Rp. {{ number_format($saldo->jumlah_saldo, 2, ',', '.') }}</p>
            <p>Terakhir diperbarui: {{ $saldo->last_updated_at }}</p>
        @else
            <p>Saldo tidak ditemukan.</p>
        @endif
    </div>
@endsection
