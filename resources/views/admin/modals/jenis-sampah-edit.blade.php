<div class="modal fade" id="modalEditJenisSampah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-lg modal-add-new-cc">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center">
                    <h3>Edit Jenis Sampah</h3>
                </div>
                <hr>
                <form action="{{ url('/jenis_sampah/edit') }}" method="POST" id="form-edit-jenis-sampah">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" id="jenis_sampah_id">
                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" id="name-ubah" type="text" name="name" placeholder="Name"
                            autofocus />
                        <label for="name">Name</label>
                        <span class="text-danger name_error"></span>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <select name="kategori" id="kategori_ubah" class="form-control">
                            <option value="">--pilih--</option>
                            <option value="Organik">Organik</option>
                            <option value="Anorganik">Anorganik</option>
                            <option value="Bahan Berbahaya">Bahan Berbahaya</option>
                        </select>
                        <label for="kategori">Kategori</label>
                        <span class="text-danger kategori_error"></span>
                    </div>
                    <div class="mb-3">
                        <div class="input-group input-group-merge ">
                            <span class="input-group-text">Rp</span>
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" name="harga" id="harga_ubah"
                                    placeholder="499" aria-label="Amount (to the nearest dollar)" min="1" />
                                <label>Harga Perkilo</label>
                            </div>
                        </div>
                        <span class="text-danger harga_error "></span>
                    </div>
                    <div class="mb-3">
                        <textarea name="deskripsi" id="deskripsi_ubah" cols="30" rows="5" class="form-control "></textarea>
                        <span class="text-danger deskripsi_error "></span>
                    </div>

                    {{-- <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" id="foto" type="file" name="foto" placeholder="foto"
                            autofocus />
                        <label for="foto">foto</label>
                    </div>
                    <span class="text-danger foto_error"></span> --}}
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary btn-reset" data-bs-dismiss="modal"
                            aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
