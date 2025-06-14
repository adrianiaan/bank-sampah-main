@extends('layouts.app')

@section('content')
    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home</span> / Edit Jadwal Penjemputan</h5>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="form-edit-penjemputan" action="{{ route('penjemputan.update', $penjemputan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="jadwal" class="form-label">Jadwal Penjemputan</label>
                            <input type="datetime-local" class="form-control" id="jadwal" name="jadwal" value="{{ \Carbon\Carbon::parse($penjemputan->jadwal)->format('Y-m-d\TH:i') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Terjadwal" {{ $penjemputan->status == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                                <option value="Selesai" {{ $penjemputan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Batal" {{ $penjemputan->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi_koordinat" class="form-label">Lokasi Koordinat</label>
                            <input type="text" class="form-control" id="lokasi_koordinat" name="lokasi_koordinat" value="{{ $penjemputan->lokasi_koordinat }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ $penjemputan->alamat }}</textarea>
                        </div>

                        <a href="{{ route('penjemputan.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
