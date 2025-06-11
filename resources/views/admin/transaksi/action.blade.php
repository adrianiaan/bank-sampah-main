<a href="{{ route('transaksi.edit', $transaksi->id) }}" class="btn btn-sm btn-primary">Edit</a>
<form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST" style="display: inline-block;">
    @csrf
    @method('DELETE')
    @if(Auth::user()->role != 'end_user')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</button>
    @endif
</form>
