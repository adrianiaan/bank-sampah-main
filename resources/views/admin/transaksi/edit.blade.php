@extends('layouts.app')

@section('content')
    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home</span> / Edit Transaksi</h5>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="form-edit-transaksi" action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" id="user_id" value="{{ $transaksi->user_id }}">
                        <div class="mb-3">
                            <label for="user_name" class="form-label">User</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" value="{{ $transaksi->user->name }}" required>
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
                            <label for="nilai_saldo" class="form-label">Nilai Saldo</label>
                            <input type="number" class="form-control" id="nilai_saldo" name="nilai_saldo" step="0.01" value="{{ $transaksi->nilai_saldo }}" required readonly>
                        </div>

                        <div class="mb-3">
                            <label for="catatan_verifikasi" class="form-label">Catatan Verifikasi</label>
                            <textarea class="form-control" id="catatan_verifikasi" name="catatan_verifikasi" rows="3">{{ $transaksi->catatan_verifikasi }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="status_verifikasi" class="form-label">Status Verifikasi</label>
                            <select class="form-select" id="status_verifikasi" name="status_verifikasi">
                                <option value="">-- Pilih Status Verifikasi --</option>
                                <option value="terverifikasi" {{ $transaksi->status_verifikasi == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="ditolak" {{ $transaksi->status_verifikasi == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        $("#user_name").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('user.autocomplete') }}",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.name,
                                value: item.name,
                                id: item.id
                            }
                        }));
                    }
                });
            },
            select: function(event, ui) {
                $('#user_id').val(ui.item.id);
            }
        });

        $('#jenis_sampah_id').on('change', function() {
            var jenis_sampah_id = $(this).val();
            var berat_kg = $('#berat_kg').val();
            updateNilaiSaldo(jenis_sampah_id, berat_kg);
        });

       $('#berat_kg').on('input', function() {
            var jenis_sampah_id = $('#jenis_sampah_id').val();
            var berat_kg = parseFloat($(this).val());
            if(!isNaN(berat_kg) && berat_kg >= 0){
                updateNilaiSaldo(jenis_sampah_id, berat_kg);
            }
        });

        function updateNilaiSaldo(jenis_sampah_id, berat_kg) {
            if (jenis_sampah_id && berat_kg) {
                $.ajax({
                    url: '{{ url('/jenis_sampah/show/') }}/' + jenis_sampah_id,
                    type: 'GET',
                    success: function(data) {
                        var harga = data.harga;
                        var nilai_saldo = parseFloat(berat_kg) * parseFloat(harga);
                        $('#nilai_saldo').val(nilai_saldo);
                    },
                    error: function(xhr, status, error) {
                        console.log("response err", xhr.responseText);
                    }
                });
            } else {
                $('#nilai_saldo').val('');
            }
        }

        // Trigger nilai saldo calculation on page load
        $(document).ready(function() {
            var jenis_sampah_id = $('#jenis_sampah_id').val();
            var berat_kg = $('#berat_kg').val();
            updateNilaiSaldo(jenis_sampah_id, berat_kg);
        });
</script>
@endpush
