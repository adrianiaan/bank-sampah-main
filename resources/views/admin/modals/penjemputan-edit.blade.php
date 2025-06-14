<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="editPenjemputanForm" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Jadwal Penjemputan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="mb-3">
          <label for="editJadwal" class="form-label">Jadwal Penjemputan</label>
          <input type="datetime-local" class="form-control" id="editJadwal" name="jadwal" required>
          <span class="text-danger jadwal_error"></span>
        </div>

        <div class="mb-3">
          <label for="editStatus" class="form-label">Status</label>
          <select class="form-select" id="editStatus" name="status" required>
            <option value="Terjadwal">Terjadwal</option>
            <option value="Selesai">Selesai</option>
            <option value="Batal">Batal</option>
          </select>
          <span class="text-danger status_error"></span>
        </div>

        <div class="mb-3">
          <label for="editLokasiKoordinat" class="form-label">Lokasi Koordinat</label>
          <input type="text" class="form-control" id="editLokasiKoordinat" name="lokasi_koordinat" required>
          <span class="text-danger lokasi_koordinat_error"></span>
        </div>

        <div class="mb-3">
          <label for="editAlamat" class="form-label">Alamat</label>
          <textarea class="form-control" id="editAlamat" name="alamat" rows="2" required></textarea>
          <span class="text-danger alamat_error"></span>
        </div>
      </div>
      <div class="modal-footer">
        <a href="{{ route('penjemputan.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<script>
  $('#editModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    const id = button.data('id');
    const jadwal = button.data('jadwal');
    const status = button.data('status');
    const lokasi = button.data('lokasi');
    const alamat = button.data('alamat');

    const modal = $(this);
    modal.find('form').attr('action', '/admin/penjemputan/' + id);
    modal.find('#editJadwal').val(jadwal);
    modal.find('#editStatus').val(status);
    modal.find('#editLokasiKoordinat').val(lokasi);
    modal.find('#editAlamat').val(alamat);
  });

  $('#editPenjemputanForm').on('submit', function(e) {
    e.preventDefault();
    const form = $(this);
    const url = form.attr('action');
    const data = form.serialize();

    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      success: function(response) {
        alert('Data penjemputan berhasil diperbarui');
        $('#editModal').modal('hide');
        $('#penjemputan-table').DataTable().ajax.reload(null, false);
      },
      error: function(xhr) {
        alert('Gagal memperbarui data penjemputan');
      }
    });
  });
</script>
</create_file>
