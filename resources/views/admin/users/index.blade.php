@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css" />
@endpush

@section('content')
    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home</span> / Manajemen Pengguna</h5>
    <div class="row">
        @if(auth()->user()->role !== 'kepala_dinas')
        <div class="col-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="h5"> Input Data Manajemen Pengguna</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="post" id="form-user-management">
                        @csrf
                        <div class="form-floating form-floating-outline mb-3">
                            <input class="form-control" id="name" type="text" name="name" placeholder="Name" autofocus />
                            <label for="name">Name</label>
                            <span class="text-danger name_error"></span>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <input class="form-control" id="email" type="email" name="email" placeholder="Email" />
                            <label for="email">Email</label>
                            <span class="text-danger email_error"></span>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <select name="role" id="role" class="form-control">
                                <option value="">--pilih--</option>
                                <option value="super_admin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            <label for="role">Role</label>
                            <span class="text-danger role_error"></span>
                        </div>

                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        <div class="@if(auth()->user()->role === 'kepala_dinas') col-12 @else col-8 @endif">
            <div class="card">
                <div class="card-header  d-flex align-items-center justify-content-between">
                    <h5 class="h5">Data Manajemen Pengguna</h5>
                </div>
                <div class="card-body">
                    @if(auth()->user()->role === 'kepala_dinas')
                        {{ $dataTable->table(['action' => false]) }}
                    @else
                        {{ $dataTable->table() }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('admin.modals.user-management-edit')
@endsection

@push('script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
    {{ $dataTable->scripts() }}

    <script src="{{ asset('js/user-management.js') }}"></script>
@endpush
