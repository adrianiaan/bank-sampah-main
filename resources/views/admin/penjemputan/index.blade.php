@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-bottom: 1rem;
            min-height: 400px;
            min-width: 100%;
        }
        /* Perbaikan tampilan dropdown status di tabel */
        select.status-select {
            min-width: 100px;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
            background-color: #fff;
            color: #495057;
            height: 30px;
        }
        select.status-select:focus {
            outline: none;
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
    </style>
@endpush

@section('content')
    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home</span> / Jadwal Penjemputan</h5>

    <div class="row" style="align-items: stretch;">
        @if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'end_user')
        <div class="col-4 d-flex flex-column">
            <div class="card flex-grow-1 d-flex flex-column">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="h5">Input Jadwal Penjemputan</h5>
                </div>
                <div class="card-body flex-grow-1 overflow-auto">
                    <form id="form-penjemputan" method="POST" action="{{ route('penjemputan.store') }}" class="h-100 d-flex flex-column">
                        @csrf
                        @include('admin.penjemputan.map')

                        <div class="mb-3">
                            <label for="jadwal" class="form-label">Jadwal Penjemputan</label>
                            <input type="datetime-local" class="form-control" id="jadwal" name="jadwal" required>
                            <span class="text-danger jadwal_error"></span>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi_koordinat" class="form-label">Lokasi Koordinat</label>
                            <input type="text" class="form-control" id="lokasi_koordinat" name="lokasi_koordinat" readonly required>
                            <span class="text-danger lokasi_koordinat_error"></span>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" readonly required></textarea>
                            <span class="text-danger alamat_error"></span>
                        </div>

                        <button type="submit" class="btn btn-primary mt-auto">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        <div class="@if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'end_user') col-8 @else col-12 @endif d-flex flex-column">
            <div class="card flex-grow-1 d-flex flex-column" style="min-height: 600px;">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="h5">Data Jadwal Penjemputan</h5>
                    @if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'kepala_dinas')
                    <a href="{{ route('admin.penjemputan.cetak.pdf') }}" target="_blank" class="btn btn-secondary btn-sm">Cetak PDF</a>
                    @endif
                </div>
                <div class="card-body flex-grow-1 overflow-auto">
                    {{ $dataTable->table(['class' => 'table table-striped table-bordered'], true) }}
                </div>
            </div>
        </div>
    </div>

    @include('admin.modals.penjemputan-edit')
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script>
    // Pastikan tombol edit mengisi data dengan benar
    $(document).on('click', 'button[data-bs-target="#editModal"]', function () {
        var button = $(this);
        var id = button.data('id');
        var jadwal = button.data('jadwal');
        var status = button.data('status');
        var lokasi = button.data('lokasi');
        var alamat = button.data('alamat');

        var modal = $('#editModal');
        modal.find('form').attr('action', '/admin/penjemputan/' + id);
        modal.find('#editJadwal').val(jadwal);
        modal.find('#editStatus').val(status);
        modal.find('#editLokasiKoordinat').val(lokasi);
        modal.find('#editAlamat').val(alamat);
    });
</script>
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    {{ $dataTable->scripts() }}

    <script>
        $(document).ready(function() {
            // Event delegation for status select change
            $('#penjemputan-table').on('change', '.status-select', function() {
                var id = $(this).data('id');
                var status = $(this).val();

                $.ajax({
                    url: '/admin/penjemputan/' + id,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status,
                        jadwal: $(this).data('jadwal'),
                        lokasi_koordinat: $(this).data('lokasi'),
                        alamat: $(this).data('alamat')
                    },
                    success: function(response) {
                        alert('Status berhasil diperbarui');
                        $('#penjemputan-table').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        alert('Gagal memperbarui status');
                    }
                });
            });
        });
    </script>
@endpush
