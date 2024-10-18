<div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ url('satker')}}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Tambah Satuan Kerja</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameBackdrop" class="form-label ">Kode Satker</label>
              <input
                type="text"
                id="nameBackdrop"
                name="id_satker"
                class="form-control @error('id_satker') is-invalid @enderror"
                value="{{old('id_satker')}}"
                placeholder="Isikan Kode Satker"
              />
              @error('id_satker')
              <div class="invalid-feedback">
                  {{ $message}}
              </div>
            @enderror
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBackdrop" class="form-label">Nama Satker</label>
              <input
                type="text"
                id="nameBackdrop"
                name="nama_satker"
                class="form-control @error('nama_satker') is-invalid @enderror"
                value="{{old('nama_satker')}}"
                placeholder="Isikan Nama Satker"
              />
              @error('nama_satker')
                <div class="invalid-feedback">
                    {{ $message}}
                </div>
              @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Tutup
          </button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>