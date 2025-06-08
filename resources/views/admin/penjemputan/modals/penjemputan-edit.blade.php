<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editForm" method="POST" action="">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Jadwal Penjemputan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_jadwal" class="form-label">Jadwal Penjemputan</label>
            <input type="datetime-local" class="form-control" id="edit_jadwal" name="jadwal" required>
          </div>
          <div class="mb-3">
            <label for="edit_status" class="form-label">Status</label>
            <select class="form-select" id="edit_status" name="status" required>
              <option value="Terjadwal">Terjadwal</option>
              <option value="Selesai">Selesai</option>
              <option value="Batal">Batal</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_lokasi_koordinat" class="form-label">Lokasi Koordinat</label>
            <input type="text" class="form-control" id="edit_lokasi_koordinat" name="lokasi_koordinat" readonly required>
          </div>
          <div class="mb-3">
            <label for="edit_alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="edit_alamat" name="alamat" rows="2" readonly required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var editModal = document.getElementById('editModal');
  editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var id = button.getAttribute('data-id');
    var jadwal = button.getAttribute('data-jadwal');
    var status = button.getAttribute('data-status');
    var lokasi = button.getAttribute('data-lokasi');
    var alamat = button.getAttribute('data-alamat');

    var modal = this;
    modal.querySelector('#editForm').action = '/admin/penjemputan/' + id;
    modal.querySelector('#edit_jadwal').value = jadwal;
    modal.querySelector('#edit_status').value = status;
    modal.querySelector('#edit_lokasi_koordinat').value = lokasi;
    modal.querySelector('#edit_alamat').value = alamat;
  });
});
</script>
