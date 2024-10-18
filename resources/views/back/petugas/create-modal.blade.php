@push('css') 
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

 
<div class="modal fade" id="createPetugasModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">  
        <form action="{{ url('petugas')}}"  enctype="multipart/form-data" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Tambah Petugas Pelayanan</h5>
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
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Nama</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-user"></i
                    ></span>
                    <input
                    type="text"
                    class="form-control @error('nama_petugas') is-invalid @enderror"
                    id="basic-icon-default-fullname"
                    name="nama_petugas"
                    value="{{ old('nama_petugas') }}"
                    {{-- placeholder="John Doe"
                    aria-label="John Doe" --}}
                    aria-describedby="basic-icon-default-fullname2"
                    />
                </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Satuan Kerja</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-buildings"></i
                    ></span>
                    <select id="defaultSelect" 
                        class="form-select @error('id_satker') is-invalid @enderror"
                        name="id_satker"
                        value="{{ old('id_satker') }}"
                        placeholder="Pilih Satuan Kerja">
                        <option value=""> -- Pilih Satuan Kerja --</option>
                        @foreach ($satkers as $item)
                            <option value="{{$item->id_satker}}">{{$item->nama_satker}}</option>
                        @endforeach
                      </select>
                </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Jabatan</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-street-view"></i
                    ></span>
                    <select id="defaultSelect" 
                        class="form-select @error('jabatan') is-invalid @enderror"
                        name="jabatan"
                        value="{{ old('jabatan') }}"
                        placeholder="Pilih Jabatan">
                        <option value="">-- Pilih Jabatan -- </option>
                            <option value="Statistisi Ahli Pertama">Statistisi Ahli Pertama</option>
                            <option value="Statistisi Ahli Muda">Statistisi Ahli Muda</option>
                            <option value="Statistisi Ahli Madya">Statistisi Ahli Madya</option>
                            <option value="Statistisi Terampil">Statistisi Terampil</option>
                            <option value="Statistisi Mahir">Statistisi Mahir</option>
                            <option value="Statistisi Penyelia">Statistisi Penyelia</option>
                            <option value="Prakom Ahli Pertama">Prakom Ahli Pertama</option>
                            <option value="Prakom Ahli Muda">Prakom Ahli Muda</option>
                            <option value="Prakom Ahli Madya">Prakom Ahli Madya</option>
                            <option value="Prakom Pemula">Prakom Pemula</option>
                            <option value="Prakom Pelaksana">Prakom Pelaksana</option>
                            <option value="Prakom Pelaksana Lanjutan">Prakom Pelaksana Lanjutan</option>
                            <option value="Prakom Penyelia">Prakom Penyelia</option>
                      </select>
                
                  
                </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Peran</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-run"></i
                    ></span>
                    <select id="defaultSelect" 
                        class="form-select @error('status') is-invalid @enderror"
                        name="status"
                        value="{{ old('status') }}"
                        placeholder="Pilih Peran">
                        <option value="">-- Pilih Peran -- </option>
                            <option value="Admin">Admin</option>
                            <option value="Operator">Operator</option>
                            <option value="Operator">Pemantau</option>
                      </select>
                </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-company">Nip Lama</label>
                <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"
                        ><i class="bx bx-id-card"></i
                        ></span>
                        <input
                        type="text"
                        id="basic-icon-default-company"
                        class="form-control @error('nip_lama') is-invalid @enderror"
                        name="nip_lama"
                        value="{{ old('nip_lama') }}"
                        onkeypress="return isNumberKey(event)"
                        {{-- placeholder="ACME Inc."
                        aria-label="ACME Inc." --}}
                        aria-describedby="basic-icon-default-company2"
                        />
                    </div>
                    <div class="form-text">masukkan nip lama BPS 9 digit 3400xxxxx</div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-email">Email BPS</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                    <input
                    type="text"
                    id="basic-icon-default-email"
                    class="form-control @error('email_bps') is-invalid @enderror"
                    value="{{ old('email_bps') }}"
                    name="email_bps"
                    {{-- placeholder="john.doe"
                    aria-label="john.doe" --}}
                    aria-describedby="basic-icon-default-email2"
                    />
                    <span id="basic-icon-default-email2" class="input-group-text">@bps.go.id</span>
                </div>
                {{-- <div class="form-text">You can use letters, numbers & periods</div> --}}
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-email">Email Google</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                    <input
                    type="text"
                    id="basic-icon-default-email"
                    class="form-control @error('email_google') is-invalid @enderror"
                    value="{{ old('email_google') }}"
                    name="email_google"
                    {{-- placeholder="john.doe"
                    aria-label="john.doe" --}}
                    aria-describedby="basic-icon-default-email2"
                    />
                    <span id="basic-icon-default-email2" class="input-group-text">@gmail.com</span>
                </div>
                
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-phone">No Telp</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-phone2" class="input-group-text"
                    ><i class="bx bx-phone"></i
                    ></span>
                    <input
                        type="text"
                        id="basic-icon-default-phone"
                        name="no_hp"
                        onkeypress="return isNumberKey(event)"
                        value="{{ old('no_hp') }}"
                        class="form-control phone-mask @error('no_hp') is-invalid @enderror"
                        placeholder="081xxxxxxxx"
                        {{-- aria-label="658 799 8941" --}}
                        aria-describedby="basic-icon-default-phone2"
                    />
                </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-phone">Foto</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    {{-- <span id="basic-icon-default-phone2" class="input-group-text"
                    ><i class="bx bx-phone"></i
                    ></span> --}}
                    <input class="form-control @error('foto') is-invalid @enderror" 
                        type="file" 
                        id="formFile" 
                        name="foto"
                        value="{{ old('foto') }}"
                        accept="image/*"/>
                </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Peran</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text">
                        <i class="bx bx-check-square"></i></span>
                    <select id="defaultSelect" 
                        class="form-select @error('tampil') is-invalid @enderror"
                        name="tampil"
                        value="{{ old('tampil') }}"
                        placeholder="Pilih Peran">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                      </select>
                </div>
                <div class="form-text">Pilih Tidak, jika petugas tidak ditampilkan untuk user </div>
                </div>
            </div>
            
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                
            </div>
            <select class="js-example-basic-single" name="state">
                <option value="AL">Alabama</option>
                <option>Jamaica</option>
                <option>Kenya</option>
                <option>French Guiana</option>
                <option>Mayotta</option>
                <option>Liechtenstein</option>
                <option>Denmark</option>
                  
                <option value="WY">Wyoming</option>
              </select>
                {{-- <select class="form-select" id="multiple-select-field" data-placeholder="Pilih" multiple>
                    <option>Christmas Island</option>
                    <option>South Sudan</option>
                    <option>Jamaica</option>
                    <option>Kenya</option>
                    <option>French Guiana</option>
                    <option>Mayotta</option>
                    <option>Liechtenstein</option>
                    <option>Denmark</option>
                    <option>Eritrea</option>
                    <option>Gibraltar</option>
                    <option>Saint Helena, Ascension and Tristan da Cunha</option>
                    <option>Haiti</option>
                    <option>Namibia</option>
                    <option>South Georgia and the South Sandwich Islands</option>
                    <option>Vietnam</option>
                    <option>Yemen</option>
                    <option>Philippines</option>
                    <option>Benin</option>
                    <option>Czech Republic</option>
                    <option>Russia</option>
                </select> --}}
        </form>
        
    </div>
  </div>
  
@push('js')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    return true;
  }

  
  </script>
  <script>
   
    // $( '#multiple-select-field' ).select2( {
    //     theme: "bootstrap-5",
    //     width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    //     placeholder: $( this ).data( 'placeholder' ),
    //     closeOnSelect: false,
    // } );
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
  </script>
  
@endpush

