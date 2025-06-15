<div class="modal fade" id="modalEditJenisSampah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Jenis Sampah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/jenis_sampah/edit') }}" method="POST" id="form-edit-jenis-sampah">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <input type="hidden" name="id" id="jenis_sampah_id" />
                    <div class="mb-3">
                        <label for="name-ubah" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name-ubah" name="name" placeholder="Name" autofocus />
                        <span class="text-danger name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="kategori_ubah" class="form-label">Kategori</label>
                        <select name="kategori" id="kategori_ubah" class="form-select">
                            <option value="">--pilih--</option>
                            <option value="Organik">Organik</option>
                            <option value="Anorganik">Anorganik</option>
                            <option value="Bahan Berbahaya">Bahan Berbahaya</option>
                        </select>
                        <span class="text-danger kategori_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="harga_ubah" class="form-label">Harga Perkilo</label>
                        <input type="number" class="form-control" name="harga" id="harga_ubah" placeholder="499" min="1" />
                        <span class="text-danger harga_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_ubah" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi_ubah" cols="30" rows="5" class="form-control"></textarea>
                        <span class="text-danger deskripsi_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                    <button type="reset" class="btn btn-outline-secondary btn-reset" data-bs-dismiss="modal" aria-label="Close">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
