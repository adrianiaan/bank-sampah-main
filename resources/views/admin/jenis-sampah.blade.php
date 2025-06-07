@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endpush

@section('content')
    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home</span> / {{ $title }}</h5>
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="h5"> Input Data {{ $title }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('jenis_sampah.store') }}" method="post" id="form-jenis-sampah">
                        @csrf
                        <div class="form-floating form-floating-outline mb-3">
                            <input class="form-control" id="name" type="text" name="name" placeholder="Name"
                                autofocus />
                            <label for="name">Name</label>
                            <span class="text-danger name_error"></span>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <select name="kategori" id="kategori" class="form-control">
                                <option value="">--pilih--</option>
                                <option value="Organik">Organik</option>
                                <option value="Anorganik">Anorganik</option>
                                <option value="Bahan Berbahaya">Bahan Berbahaya</option>
                            </select>
                            <label for="kategori">Kategori</label>
                            <span class="text-danger kategori_error"></span>
                        </div>
                        <div class="mb-3">
                            <div class="input-group input-group-merge ">
                                <span class="input-group-text">Rp</span>
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" name="harga" id="harga"
                                        placeholder="499" aria-label="Amount (to the nearest dollar)" min="1" />
                                    <label>Harga Perkilo</label>
                                </div>
                            </div>
                            <span class="text-danger harga_error "></span>
                        </div>
                        <div class="mb-3">
                            <textarea name="deskripsi" id="deskripsi" cols="30" rows="5" class="form-control "></textarea>
                            <span class="text-danger deskripsi_error "></span>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <input class="form-control" id="foto" type="file" name="foto" placeholder="foto"
                                autofocus />
                            <label for="foto">foto</label>
                        </div>
                        <span class="text-danger foto_error"></span>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header  d-flex align-items-center justify-content-between">
                    <h5 class="h5">Data {{ $title }}</h5>
                </div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>


    {{-- Start modal tambah jabatan --}}
    {{-- @include('pages.jabatan.modals.tambah-jabatan') --}}
    {{-- End modal tambah jabatan --}}
    {{-- Start modal ubah jabatan --}}
    @include('admin.modals.jenis-sampah-edit')
    {{-- End modal ubah jabatan --}}
@endsection

@push('script')
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
    {{ $dataTable->scripts() }}

    <script src="{{ asset('js/jenis-sampah.js') }}"></script>
@endpush
