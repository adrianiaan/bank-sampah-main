<a href="{{ route('jenis_sampah.edit', $data->id) }}" class="btn btn-sm btn-primary">Edit</a>
<form action="{{ url('/jenis_sampah/' . $data->id) }}" method="POST" style="display: inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus jenis sampah ini?')">Hapus</button>
</form>
