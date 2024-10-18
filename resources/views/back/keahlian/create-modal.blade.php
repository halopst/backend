<div class="modal fade" id="createKeahlianModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">  
        <form action="{{ url('keahlian')}}"  enctype="multipart/form-data" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Tambah Keahlian</h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <hr class="my-1" />
            <div class="modal-body">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Nama Keahlian</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-run"></i
                    ></span>
                    <input
                    type="text"
                    class="form-control @error('nama_keahlian') is-invalid @enderror"
                    id="basic-icon-default-fullname"
                    name="nama_keahlian"
                    value="{{ old('nama_keahlian') }}"
                    {{-- placeholder="John Doe"
                    aria-label="John Doe" --}}
                    aria-describedby="basic-icon-default-fullname2"
                    />
                </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Tampilkan</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-user-pin"></i
                    ></span>
                    <select id="defaultSelect" 
                        class="form-select @error('tampilkan') is-invalid @enderror"
                        name="tampilkan"
                        value="{{ old('tampilkan') }}"
                        placeholder="Tampilkan">
                            <option value="1">Ya</option>
                            <option value="2">Tidak</option>
                      </select>
                </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-phone">Icon</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    {{-- <span id="basic-icon-default-phone2" class="input-group-text"
                    ><i class="bx bx-phone"></i
                    ></span> --}}
                    <input class="form-control @error('icon') is-invalid @enderror" 
                        type="file" 
                        id="formFile" 
                        name="icon"
                        value="{{ old('icon') }}"
                        accept="image/*"/>
                </div>
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
@push('js')
<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
    }
</script>
<script>
    
</script>
@endpush