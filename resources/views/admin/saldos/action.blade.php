<div>
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ $saldo->id }}" data-bs-toggle="dropdown" aria-expanded="false">
            Aksi
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $saldo->id }}">
            <li><a class="dropdown-item" href="{{ route('admin.saldo.show', $saldo->user_id) }}">Lihat Saldo</a></li>
            @if(auth()->user()->role === 'super_admin')
            <li>
                <!-- Button trigger modal -->
                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#withdrawModal{{ $saldo->id }}">
                    Penarikan Saldo
                </button>
            </li>
            {{-- Hapus tombol Edit --}}
            {{-- <li><a class="dropdown-item" href="{{ route('admin.saldo.edit', $saldo->id) }}">Edit</a></li> --}}
            {{-- Hapus tombol Delete --}}
            {{-- <li>
                <form action="{{ route('admin.saldo.destroy', $saldo->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus saldo ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                </form>
            </li> --}}
            @endif
        </ul>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="withdrawModal{{ $saldo->id }}" tabindex="-1" aria-labelledby="withdrawModalLabel{{ $saldo->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.saldo.withdraw', $saldo->user->id) }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="withdrawModalLabel{{ $saldo->id }}">Penarikan Saldo - {{ $saldo->user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jumlah_penarikan_{{ $saldo->id }}">Jumlah Penarikan:</label>
                        <input type="number" class="form-control" id="jumlah_penarikan_{{ $saldo->id }}" name="jumlah_penarikan" min="0" max="{{ $saldo->jumlah_saldo }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Cairkan Saldo</button>
                </div>
            </form>
        </div>
    </div>
</div>
