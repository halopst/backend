@push('css') 
  <link rel="stylesheet" href="{{asset('vendor/libs/select2/select2.css')}}">
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
                <div class="row mb-1">
                    <label class="col-sm-3 col-form-label" for="basic-icon-default-email">Email BPS</label>
                    <div class="col-sm-6 pr-0">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                            <input
                                type="text"
                                id="email_bps"
                                class="form-control @error('email_bps') is-invalid @enderror"
                                value="{{ old('email_bps') }}"
                                name="email_bps"
                                {{-- placeholder="john.doe"
                                aria-label="john.doe" --}}
                                aria-describedby="basic-icon-default-email2"
                            />
                            <span id="basic-icon-default-email2" class="input-group-text">@bps.go.id</span>
                    </div>
                    <div class="form-text">masukkan email tanpa @bps.go.id</div>
                    </div>
                    <div class="col-sm-3 px-0">
                        
                        <button type="button" id="cekDataBtn" class="btn btn-primary btn-block">
                            <div id="spinLoad" class="spinner-border spinner-border-sm text-light d-none" role="status">
                                <span class="visually-hidden">Loading...</span>
                              </div>
                            Cek Data
                        </button>
                    </div>
                </div>
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Nama</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-user"></i
                    ></span>
                    <input
                    type="text"
                    class="form-control @error('nama_petugas') is-invalid @enderror pl-1"
                    id="exampleFormControlReadOnlyInput1"
                    name="nama_petugas"
                    readonly=""
                    value="{{ old('nama_petugas') }}"
                    {{-- placeholder="John Doe"
                    aria-label="John Doe" --}}
                    aria-describedby="basic-icon-default-fullname2"
                    />
                </div>
                </div>
            </div>
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Satuan Kerja</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-building"></i
                    ></span>
                    <input
                    type="text"
                    class="form-control @error('satuan_kerja_view') is-invalid @enderror"
                    id="exampleFormControlReadOnlyInput1"
                    name="satuan_kerja_view"
                    readonly=""
                    value="{{ old('satuan_kerja_view') }}"
                    {{-- placeholder="John Doe"
                    aria-label="John Doe" --}}
                    aria-describedby="basic-icon-default-fullname2"
                    />
                </div>
                </div>
            </div>
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Nama Panggilan</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-user"></i
                    ></span>
                    <input
                        type="text"
                        class="form-control @error('nama_panggilan') is-invalid @enderror pl-1"
                        id="basic-icon-default-company"
                        name="nama_panggilan"
                        value="{{ old('nama_panggilan') }}"
                        aria-describedby="basic-icon-default-fullname2"
                    />
                </div>
                </div>
            </div>
            <div class="row mb-1">
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
            <div class="row mb-1 d-none">
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
                            placeholder="ACME Inc."
                            aria-label="ACME Inc." 
                            aria-describedby="basic-icon-default-company2"
                        />
                        <input
                            type="text"
                            id="basic-icon-default-company"
                            class="form-control @error('jabatan') is-invalid @enderror"
                            name="jabatan"
                            value="{{ old('jabatan') }}"
                            onkeypress="return isNumberKey(event)"
                            placeholder="ACME Inc."
                            aria-label="ACME Inc." 
                            aria-describedby="basic-icon-default-company2"
                        />
                        <input
                            type="text"
                            id="basic-icon-default-company"
                            class="form-control @error('id_satker') is-invalid @enderror"
                            name="id_satker"
                            value="{{ old('id_satker') }}"
                            onkeypress="return isNumberKey(event)"
                            placeholder="ACME Inc."
                            aria-label="ACME Inc." 
                            aria-describedby="basic-icon-default-company2"
                        />
                        <input
                            type="text"
                            id="basic-icon-default-company"
                            class="form-control @error('jenis_kelamin') is-invalid @enderror"
                            name="jenis_kelamin"
                            value="{{ old('jenis_kelamin') }}"
                            onkeypress="return isNumberKey(event)"
                            placeholder="ACME Inc."
                            aria-label="ACME Inc." 
                            aria-describedby="basic-icon-default-company2"
                        />
                    </div>
                </div>
            </div>
            
            <div class="row mb-1">
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
            <div class="row mb-1">
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
            
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-phone">Foto</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <input class="form-control @error('foto') is-invalid @enderror" 
                        type="file" 
                        id="formFile" 
                        name="foto"
                        value="{{ old('foto') }}"
                        accept="image/*"/>
                </div>
                <div class="form-text">Untuk tampilan foto terbaik gunakan file dengan baju putih dan background putih dan dimensi foto 4:5 </div>
                </div>
            </div>
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Tampilkan</label>
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
                <div class="form-text">Pilih Tidak, jika petugas tidak ditampilkan untuk pengguna data di halaman konsultasi </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-email">Spesialisasi</label>
                <div class="col-sm-9 pr-0">
                    <div class="input-group input-group-merge">
                        <select name="keahlian[]" id="select2Primary" class="select2 form-select" multiple>
                            @foreach ($keahlian as $item)
                                <option value="{{$item->id}}">{{$item->nama_keahlian}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="invalid-feedback-keahlian"></div>
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

<script src="{{ asset('vendor/libs/select2/select2.js')}}" defer></script>
<script>
        $(document).ready(function() {
            $(".select2").select2({
                dropdownParent: $('.modal')
            });

            $('.select2').on('change', function() {
                if ($(this).val().length > 2) {
                    // Ambil nilai yang dipilih
                    var selectedValues = $(this).val();
                    // Hapus nilai terakhir yang ditambahkan
                    selectedValues.pop();
                    // Set nilai yang diperbarui kembali ke elemen select
                    $(this).val(selectedValues).trigger('change');
                    // Tampilkan pesan peringatan (opsional)
                    validasiError('keahlian', 'Pilihan keahlian dibatasi maksimal 2 pilihan');
                }else{
                    validasiValid('keahlian');
                }
            });
            $('.js-example-basic-single').select2();
            $('#cekDataBtn').on('click', function() {
                var username = $('#email_bps').val();
                if(username === '') {
                    swallOpen('warning', 'Masukkan Email', false)
                    clearData();
                    return;
                }
                $('#spinLoad').removeClass('d-none');
                $.ajax({
                    url: '{{ config('app.url') }}pegawai/username/' + username,
                    type: 'GET',
                    success: function(data) {
                        if(data.error) {
                            $('#pegawaiData').html('<div class="alert alert-danger">' + data.error + '</div>');
                        } else {
                            //cek email ada di data BPS
                            if(data[0]){
                                //cek apakah sudah pernah didaftarkan
                                $.ajax({
                                    url: '{{ config('app.url') }}cekpetugas/'+username+'@bps.go.id',
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(datab) {
                                        //console.log(data[0].attributes['attribute-organisasi'][0]);
                                        satkerUsers='{{session('keycloak_user')['kd_organisasi']}}';
                                        satker=(data[0].attributes['attribute-organisasi'][0]).substring(0,4);
                                        satkerProv=(data[0].attributes['attribute-organisasi'][0]).substring(0,2);
                                        satkerUser=satkerUsers.substring(0,4);

                                        if(datab.output==true){
                                            swallOpen('warning', 'Pegawai sudah ditambahkan sebagai petugas', true);
                                            clearData();
                                        }else if(satkerProv!=='35'){
                                            swallOpen('warning', 'Anda Tidak Diperkenankan Menambahkan Pegawai Tersebut', true);
                                            clearData();
                                        }else if((satkerUser!='3500' && satker!=satkerUser)){
                                            swallOpen('warning', 'Anda Tidak Diperkenankan Menambahkan Pegawai Tersebut', true);
                                            clearData();
                                        }else{
                                            isiData(data[0]);
                                            //console.log(data[0]);
                                        }
                                        $('#spinLoad').addClass('d-none');
                                    },error: function(xhr) {
                                        swallOpen('warning', 'Gagal Validasi Data', true)
                                        $('#spinLoad').addClass('d-none');
                                        clearData();
                                    }
                                })
                            }else{
                                $('#spinLoad').addClass('d-none');
                                clearData();
                                swallOpen('warning', 'Data Email Tidak Ada', true)
                                return;
                            }
                        }
                    },
                    error: function(xhr) {
                        $('#pegawaiData').html('<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi nanti.</div>');
                    }
                });
            });

            function clearData(){
                $("input[name='nama_petugas']").val('');
                $("input[name='nip_lama']").val('');
                $("input[name='jabatan']").val('');
                $("input[name='satuan_kerja_view']").val('');
                $("input[name='no_hp']").val('');
                $("input[name='email_google']").val('');
                $("input[name='email_bps']").val('');
                $("input[name='nama_panggilan']").val('');
                $("input[name='jenis_kelamin']").val('');
            }
            function isiData(data){
                // console.log((data.attributes['attribute-nip'][0]).substring(14,15));
                // console.log((data.attributes['attribute-nip'][0]));
                nama_petugas='';
                nama_panggilan='';
                if(data.attributes['attribute-last-name']=='-'){
                    nama_petugas= data.attributes['attribute-first-name'];
                    nama_panggilan= nama_petugas;
                }else{
                    nama_petugas=data.attributes['attribute-first-name']+' '+data.attributes['attribute-last-name'];
                    nama_panggilan= data.attributes['attribute-last-name'];
                }

                //199109162014101002
                $("input[name='nama_petugas']").val(nama_petugas);
                $("input[name='nip_lama']").val(data.attributes['attribute-nip-lama']);
                $("input[name='jabatan']").val(data.attributes['attribute-jabatan']);
                $("input[name='jenis_kelamin']").val((data.attributes['attribute-nip'][0]).substring(14,15));
                $("input[name='nama_panggilan']").val(nama_panggilan);
                $("input[name='id_satker']").val((data.attributes['attribute-organisasi'][0]).substring(0,4));
                $("input[name='satuan_kerja_view']").val('BPS '+data.attributes['attribute-kabupaten']);
            }
           
            function swallOpen(icon, pesan, confirmButton){
                if(confirmButton==false ){
                    Swal.fire({
                        'title' : pesan,
                        'text'  : swal,
                        'icon'  : icon,
                        'showConfirmButton':false,
                        'timer' : 3000,
                        'target': document.getElementById('createPetugasModal'),
                    });
                }else{
                    Swal.fire({
                        'title' : pesan,
                        'text'  : swal,
                        'icon'  : icon,
                        'showConfirmButton':true,
                        'target': document.getElementById('createPetugasModal'),
                    });
                }
            }
        });
</script>
<script>    
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    return true;
  }
  </script>
  
@endpush

