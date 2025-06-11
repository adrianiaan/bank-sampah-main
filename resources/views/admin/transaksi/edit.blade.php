@extends('layouts.app')

@section('content')
    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home</span> / Edit Transaksi</h5>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="penjemputan_id" class="form-label">Penjemputan</label>
                            <select class="form-select" id="penjemputan_id" name="penjemputan_id">
                                <option value="">-- Pilih Penjemputan --</option>
                                @foreach($penjemputans as $penjemputan)
                                    <option value="{{ $penjemputan->id }}" {{ $transaksi->penjemputan_id == $penjemputan->id ? 'selected' : '' }}>{{ $penjemputan->id }} - {{ $penjemputan->alamat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User</label>
                            <input type="number" class="form-control" id="user_id" name="user_id" value="{{ $transaksi->user_id }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_sampah_id" class="form-label">Jenis Sampah</label>
                            <select class="form-select" id="jenis_sampah_id" name="jenis_sampah_id">
                                <option value="">-- Pilih Jenis Sampah --</option>
                                @foreach($jenis_sampahs as $jenis_sampah)
                                    <option value="{{ $jenis_sampah->id }}" {{ $transaksi->jenis_sampah_id == $jenis_sampah->id ? 'selected' : '' }}>{{ $jenis_sampah->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="berat_kg" class="form-label">Berat (Kg)</label>
                            <input type="number" class="form-control" id="berat_kg" name="berat_kg" step="0.01" value="{{ $transaksi->berat_kg }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_per_kilo_saat_transaksi" class="form-label">Harga / Kg</label>
                            <input type="number" class="form-control" id="harga_per_kilo_saat_transaksi" name="harga_per_kilo_saat_transaksi" step="0.01" value="{{ $transaksi->harga_per_kilo_saat_transaksi }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="nilai_saldo" class="form-label">Nilai Saldo</label>
                            <input type="number" class="form-control" id="nilai_saldo" name="nilai_saldo" step="0.01" value="{{ $transaksi->nilai_saldo }}" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                            <input type="datetime-local" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" value="{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="dicatat_oleh_user_id" class="form-label">Dicatat Oleh (User ID)</label>
                            <input type="number" class="form-control" id="dicatat_oleh_user_id" name="dicatat_oleh_user_id" value="{{ $transaksi->dicatat_oleh_user_id }}">
                        </div>
                        <div class="mb-3">
                            <label for="status_verifikasi" class="form-label">Status Verifikasi</label>
                            <select class="form-select" id="status_verifikasi" name="status_verifikasi">
                                <option value="">-- Pilih Status --</option>
                                <option value="terverifikasi" {{ $transaksi->status_verifikasi == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="ditolak" {{ $transaksi->status_verifikasi == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="catatan_verifikasi" class="form-label">Catatan Verifikasi</label>
                            <textarea class="form-control" id="catatan_verifikasi" name="catatan_verifikasi" rows="3">{{ $transaksi->catatan_verifikasi }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#berat_kg, #harga_per_kilo_saat_transaksi').on('input', function() {
            var berat_kg = parseFloat($('#berat_kg').val()) || 0;
            var harga_per_kilo = parseFloat($('#harga_per_kilo_saat_transaksi').val()) || 0;
            var nilai_saldo = berat_kg * harga_per_kilo;
            $('#nilai_saldo').val(nilai_saldo.toFixed(2));
        });
    });
</script>
@endpush
