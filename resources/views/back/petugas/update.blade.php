@extends('back.layout.template')

@section('content')
@push('css') 
  <link rel="stylesheet" href="{{asset('vendor/libs/select2/select2.css')}}">
@endpush
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Dashboard / Edit Petugas Pelayanan/ </span>{{$petugas->nama_petugas}}</h4>
    {{-- {{  $keahlianUser[0]->id }} --}}
    <!-- Striped Rows -->
    <div class="card">
        @if ($errors->any())
          <div class="m-4 mb-1">
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>
                    {{ $error }}
                  </li>
                @endforeach
              </ul>
            </div>
          </div>      
          @endif
        
          @if (session('success'))
          <div class="m-4 mb-1">
            <div class="alert alert-success">
                {{ session('success')}}
            </div>
          </div>      
          @endif
        <div class="card-body">
            <form action="{{ url('petugas/'.$petugas->id)}}"  enctype="multipart/form-data" method="POST" >
                @method('PUT')
                @csrf
                    {{-- <h5 class="modal-title" id="backDropModalTitle">Tambah Petugas Pelayanan</h5> --}}
                {{-- <hr class="my-1" /> --}}
                <input type="hidden" name="old_foto" value="{{$petugas->foto}}">
                <div class="modal-body">
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Nama</label>
                    <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text"
                        ><i class="bx bx-user"></i
                        ></span>
                        <input
                            type="text"
                            class="form-control @error('nama_petugas') is-invalid @enderror"
                            {{-- id="exampleFormControlReadOnlyInput1" --}}
                            readonly=""
                            name="nama_petugas"
                            value="{{ $petugas->nama_petugas }}"
                            {{-- placeholder="John Doe"
                            aria-label="John Doe" --}}
                            aria-describedby="basic-icon-default-fullname2"
                        />
                    </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Satuan Kerja</label>
                    <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text"
                        ><i class="bx bx-buildings"></i
                        ></span>
                        <input 
                            type="text"
                            class="form-control @error('id_satker') is-invalid @enderror d-none"
                            {{-- id="exampleFormControlReadOnlyInput1" --}}
                            readonly=""
                            name="id_satker"
                            value="{{ $petugas->id_satker }}"
                            {{-- placeholder="John Doe"
                            aria-label="John Doe" --}}
                            aria-describedby="basic-icon-default-fullname2"
                        />
                        <input
                            type="text"
                            class="form-control @error('id_satker_view') is-invalid @enderror"
                            {{-- id="exampleFormControlReadOnlyInput1" --}}
                            readonly=""
                            name="id_satker_view"
                            value="{{ $petugas->Satker->nama_satker }}"
                            {{-- placeholder="John Doe"
                            aria-label="John Doe" --}}
                            aria-describedby="basic-icon-default-fullname2"
                        />
                        {{-- <select id="defaultSelect" 
                            class="form-select @error('id_satker') is-invalid @enderror"
                            name="id_satker"
                            readonly=""
                            {{-- value="{{ $petugas->id_satker }}" --}}
                            {{-- placeholder="Pilih Satuan Kerja">
                            @foreach ($satkers as $item)
                                <option value="{{$item->id_satker}}" {{ $petugas->id_satker==$item->id_satker ? "selected" : null }}
                                    >{{$item->nama_satker}}</option>
                            @endforeach
                          </select>  --}}
                    </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Jabatan</label>
                    <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text"
                        ><i class="bx bx-street-view"></i
                        ></span>
                        <input
                            type="text"
                            class="form-control @error('jabatan') is-invalid @enderror"
                            readonly=""
                            name="jabatan"
                            value="{{ $petugas->jabatan }}"
                            {{-- placeholder="John Doe"
                            aria-label="John Doe" --}}
                            aria-describedby="basic-icon-default-fullname2"
                        />
                    </div>
                    </div>
                </div>
                <div class="row mb-2">
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
                                readonly=""
                                name="nip_lama"
                                onkeypress="return isNumberKey(event)"
                                value="{{ $petugas->nip_lama }}"
                                aria-describedby="basic-icon-default-company2"
                            />
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-icon-default-email">Email BPS</label>
                    <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                        <input
                        type="text"
                        id="basic-icon-default-email"
                        class="form-control @error('email_bps') is-invalid @enderror"
                        value="{{ substr($petugas->email_bps, 0, strpos($petugas->email_bps, '@')) }}"
                        name="email_bps"
                        readonly=""
                        {{-- placeholder="john.doe"
                        aria-label="john.doe" --}}
                        aria-describedby="basic-icon-default-email2"
                        />
                        <span id="basic-icon-default-email2" class="input-group-text">@bps.go.id</span>
                    </div>
                    {{-- <div class="form-text">You can use letters, numbers & periods</div> --}}
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
                            value="{{ $petugas->nama_panggilan }}"
                            aria-describedby="basic-icon-default-fullname2"
                        />
                    </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Peran</label>
                    <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text"
                        ><i class="bx bx-run"></i
                        ></span>
                        <select id="defaultSelect" 
                            class="form-select @error('status') is-invalid @enderror"
                            name="status"
                            {{-- value="{{ $petugas->status }}" --}}
                            placeholder="Pilih Peran">
                                <option value="Admin" {{ $petugas->status =="Admin" ? "selected" : null}}>Admin</option>
                                <option value="Operator" {{ $petugas->status =="Operator" ? "selected" : null}}>Operator</option>
                                <option value="Pemantau" {{ $petugas->status =="Pemantau" ? "selected" : null}}>Pemantau</option>
                            </select>
                    </div>
                    </div>
                </div>
                
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Jenis Kelamin</label>
                    <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text"
                        ><i class="bx bx-run"></i
                        ></span>
                        <select id="defaultSelect" 
                            class="form-select @error('status') is-invalid @enderror"
                            name="jenis_kelamin"
                            {{-- value="{{ $petugas->status }}" --}}
                            placeholder="Pilih Jenis Kelamin">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="1" {{ $petugas->jenis_kelamin ==1 ? "selected" : null}}>Laki-Laki</option>
                                <option value="2" {{ $petugas->jenis_kelamin ==2 ? "selected" : null}}>Perempuan</option>
                            </select>
                    </div>
                    </div>
                </div>
                
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-icon-default-email">Email Google</label>
                    <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                        <input
                        type="text"
                        id="basic-icon-default-email"
                        class="form-control @error('email_google') is-invalid @enderror"
                        value="{{ substr($petugas->email_google, 0, strpos($petugas->email_google, '@')) }}"
                        name="email_google"
                        {{-- placeholder="john.doe"
                        aria-label="john.doe" --}}
                        aria-describedby="basic-icon-default-email2"
                        />
                        <span id="basic-icon-default-email2" class="input-group-text">@gmail.com</span>
                    </div>
                    
                    </div>
                </div>
                <div class="row mb-2">
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
                        value="{{ $petugas->no_hp}}"
                        onkeypress="return isNumberKey(event)"
                        class="form-control phone-mask @error('no_hp') is-invalid @enderror"
                         placeholder="081xxxxxxxx"
                        {{-- aria-label="658 799 8941" --}}
                        aria-describedby="basic-icon-default-phone2"
                        />
                    </div>
                    </div>
                </div>
                <div class="row mb-2">
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
                                <option value="1" {{ $petugas->tampil =="1" ? "selected" : null}}>Ya</option>
                                <option value="0" {{ $petugas->tampil =="0" ? "selected" : null}}>Tidak</option>
                          </select>
                    </div>
                    <div class="form-text">Pilih Tidak, jika petugas tidak ditampilkan untuk user </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-icon-default-phone">Foto</label>
                    <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                        <input class="form-control @error('foto') is-invalid @enderror" 
                            type="file" 
                            id="formFile" 
                            name="foto"
                            {{-- value="{{ $petugas->foto }}" --}}
                            accept="image/*"/>
                    </div>
                    <div class="mt-1">
                        <small><a href="{{ asset($petugas->foto)}}"> Foto Sebelumnya</small></a>
                    </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-icon-default-email">Spesialisasi</label>
                    <div class="col-sm-9 pr-0">
                        <div class="input-group input-group-merge">
                            <select name="keahlian[]" id="select2Primary" class="select2 form-select" multiple>
                                @foreach ($keahlian as $item)
                                    <option value="{{$item->id}}" {{ in_array($item->id, $keahlianUser) ? 'selected' : ''}} > {{$item->nama_keahlian}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="invalid-feedback-keahlian"></div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                   
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a type="button" class="btn btn-secondary float-right" href="{{url('petugas')}}">
                        Kembali
                    </a>
                    
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')

<script src="{{ asset('vendor/libs/select2/select2.js')}}" defer></script>

<script>

$(document).ready(function() {
            $(".select2").select2({});
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
        }
    )

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    return true;
  }

  function validasiError(className, errorMessage){
        $('.invalid-feedback-'+className).html(errorMessage);
        $('.invalid-feedback-'+className).css('display','block');
        $('.invalid-feedback-'+className).css('color',' #ff3e1d');
       
    }
    function validasiValid(className){
        $('.invalid-feedback-'+className).html('');
        $('.invalid-feedback-'+className).css('display','none');
    }
</script>
@endpush
