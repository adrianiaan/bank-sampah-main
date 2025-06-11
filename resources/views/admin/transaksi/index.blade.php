@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <style>
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
    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home</span> / Data Transaksi</h5>

    <div class="row">
        <div class="col-12 d-flex flex-column">
            <div class="card flex-grow-1 d-flex flex-column" style="min-height: 600px;">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="h5">Data Transaksi</h5>
                    @if(Auth::user()->role == 'super_admin' || Auth::user()->role == 'end_user')
                        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
                    @endif

                </div>
                 <div class="card-body flex-grow-1 overflow-auto">
                    {{ $dataTable->table(['class' => 'table table-striped table-bordered'], true) }}
                    </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    {{ $dataTable->scripts() }}
@endpush
