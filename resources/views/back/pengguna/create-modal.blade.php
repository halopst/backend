<div class="modal fade" id="createPenggunaModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">  
        <form action="{{ url('pengguna')}}"  enctype="multipart/form-data" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Daftarkan Konsumen Layanan</h5>
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
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Nama Konsumen</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-user"></i
                    ></span>
                    <input
                    type="text"
                    class="form-control @error('nama_pengguna') is-invalid @enderror"
                    id="basic-icon-default-fullname"
                    name="nama_pengguna"
                    value="{{ old('nama_pengguna') }}"
                    {{-- placeholder="John Doe"
                    aria-label="John Doe" --}}
                    aria-describedby="basic-icon-default-fullname2"
                    />
                </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Family Name</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-user"></i
                    ></span>
                    <input
                    type="text"
                    class="form-control @error('family_name') is-invalid @enderror"
                    id="basic-icon-default-fullname"
                    name="family_name"
                    value="{{ old('family_name') }}"
                    {{-- placeholder="John Doe"
                    aria-label="John Doe" --}}
                    aria-describedby="basic-icon-default-fullname2"
                    />
                </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Given Name</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-user"></i
                    ></span>
                    <input
                        type="text"
                        class="form-control @error('given_name') is-invalid @enderror"
                        id="basic-icon-default-fullname"
                        name="given_name"
                        value="{{ old('given_name') }}"
                        {{-- placeholder="John Doe"
                        aria-label="John Doe" --}}
                        aria-describedby="basic-icon-default-fullname2"
                    />
                </div>
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
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Jenis Kelamin</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-user-pin"></i
                    ></span>
                    <select id="defaultSelect" 
                        class="form-select @error('jenis_kelamin') is-invalid @enderror"
                        name="jenis_kelamin"
                        value="{{ old('jenis_kelamin') }}"
                        placeholder="Pilih Peran">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                      </select>
                </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-phone">Tanggal Lahir</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-phone2" class="input-group-text"
                    ><i class="bx bx-baby-cariage"></i
                    ></span>
                    <input
                        type="date"
                        id="html5-date-input"
                        name="tanggal_lahir"
                        onkeypress="return isNumberKey(event)"
                        value="{{ old('tanggal_lahir') }}"
                        class="form-control phone-mask @error('tanggal_lahir') is-invalid @enderror"
                        {{--placeholder="1"
                         aria-label="658 799 8941" --}}
                        aria-describedby="basic-icon-default-phone2"
                    />
                </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Pendidikan Terakhir</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-run"></i
                    ></span>
                    <select id="defaultSelect" 
                        class="form-select @error('pendidikan') is-invalid @enderror"
                        name="pendidikan"
                        value="{{ old('pendidikan') }}"
                        placeholder="Pilih Peran">
                        <option value="">-- Pilih Pendidikan --</option>
                            <option value="<=SMA"><=SMA</option>
                            <option value="Diploma">Diploma</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                    </select>
                </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Pekerjaan</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-run"></i
                    ></span>
                    <select id="defaultSelect" 
                        class="form-select @error('pekerjaan') is-invalid @enderror"
                        name="pekerjaan"
                        value="{{ old('pekerjaan') }}"
                        placeholder="Pilih Peran">
                        <option value="">-- Pilih Pekerjaan --</option>
                            <option value="Aparatur Sipil Negara">Aparatur Sipil Negara</option>
                            <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                            <option value="Karyawan Swasta">Karyawan Swasta</option>
                            <option value="Wiraswasta">Wiraswasta</option>
                            <option value="Dosen/Peneliti">Dosen/Peneliti</option>
                            <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Provinsi</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-buildings"></i
                    ></span>
                    <select id="prov" 
                        class="form-select @error('id_prov') is-invalid @enderror"
                        name="id_prov"
                        value="{{ old('id_prov') }}"
                        placeholder="Pilih Provinsi">
                        <option value="">--Pilih Provinsi--</option>
                        @foreach ($provinsis as $item)
                            <option value="{{$item->id_prov}}">{{$item->nama_prov}}</option>
                        @endforeach
                      </select>
                </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Kabupaten/Kota</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-buildings"></i
                    ></span>
                    <select id="kab" 
                        class="form-select @error('id_kab') is-invalid @enderror"
                        name="id_kab"
                        value="{{ old('id_kab') }}"
                        placeholder="Pilih Kabupaten">
                        <option value="">-- Pilih Kabupaten --</option>
                      </select>
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
                        name="nmr_telp"
                        onkeypress="return isNumberKey(event)"
                        value="{{ old('nmr_telp') }}"
                        class="form-control phone-mask @error('nmr_telp') is-invalid @enderror"
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
    $(document).ready(function(){
        $('#prov').change(function(event){
            //console.log(this.value);
            $('#kab').html('');
            var idProv=this.value;

            $.ajax({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
                url:'{{ config('app.url') }}get-master-kab',
                type:'POST',
                dataType:'json',
                data:{id_prov:idProv},
                success:function(response){
                    $('#kab').html('<option value="">-- Pilih Kabupaten -- </option>');
                    $.each(response.kabupatens, function(index, val){
                        $('#kab').append('<option value="'+val.id_kab+'">'+val.nama_kab+'</option>');
                    })
                    
                }
            })
        })
    })
</script>
@endpush