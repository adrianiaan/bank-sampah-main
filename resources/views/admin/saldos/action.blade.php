<div>
    <a href="{{ route('admin.saldo.show', $saldo->user_id) }}" class="btn btn-primary me-2">Lihat Saldo</a>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#withdrawModal{{ $saldo->id }}">
        Penarikan Saldo
    </button>

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
