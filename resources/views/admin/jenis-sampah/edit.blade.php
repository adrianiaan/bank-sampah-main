@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
@endpush

@section('content')
    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home</span> / Edit Jenis Sampah</h5>

    <div class="row">
        <div class="col-12 d-flex flex-column">
            <div class="card flex-grow-1 d-flex flex-column" style="min-height: 600px;">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="h5">Edit Jenis Sampah</h5>
                    <a href="{{ route('jenis_sampah.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
                <div class="card-body flex-grow-1 overflow-auto">
                    <form action="{{ route('jenis_sampah.update', $jenis_sampah->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $jenis_sampah->name) }}" required autofocus>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select name="kategori" id="kategori" class="form-select" required>
                                <option value="">--pilih--</option>
                                <option value="Organik" {{ old('kategori', $jenis_sampah->kategori) == 'Organik' ? 'selected' : '' }}>Organik</option>
                                <option value="Anorganik" {{ old('kategori', $jenis_sampah->kategori) == 'Anorganik' ? 'selected' : '' }}>Anorganik</option>
                                <option value="Bahan Berbahaya" {{ old('kategori', $jenis_sampah->kategori) == 'Bahan Berbahaya' ? 'selected' : '' }}>Bahan Berbahaya</option>
                            </select>
                            @error('kategori')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Perkilo</label>
                            <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $jenis_sampah->harga) }}" min="1" required>
                            @error('harga')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" cols="30" rows="5" class="form-control">{{ old('deskripsi', $jenis_sampah->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input class="form-control" id="foto" type="file" name="foto" />
                            @if($jenis_sampah->foto)
                                <img src="{{ asset('storage/' . $jenis_sampah->foto) }}" alt="Foto" style="width: 100px; height: auto; margin-top: 10px;">
                            @endif
                            @error('foto')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
