<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="" id="editUserForm">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editUserModalLabel">Edit Pengguna</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editName" class="form-label">Nama</label>
            <input type="text" class="form-control" id="editName" name="name" required>
          </div>
          <div class="mb-3">
            <label for="editEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="editEmail" name="email" required>
          </div>
          <div class="mb-3">
            <label for="editRole" class="form-label">Role</label>
            <select class="form-select" id="editRole" name="role" required>
              <option value="super_admin">Super Admin</option>
              <option value="kepala_dinas">Kepala Dinas</option>
              <option value="end_user">End User</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="editPassword" class="form-label">Password (kosongkan jika tidak diubah)</label>
            <input type="password" class="form-control" id="editPassword" name="password" autocomplete="new-password">
          </div>
          <div class="mb-3">
            <label for="editPasswordConfirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" id="editPasswordConfirmation" name="password_confirmation" autocomplete="new-password">
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
