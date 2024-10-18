@extends('back.layout.template')

@section('content')
@push('css') 
  <link rel="stylesheet" href="{{asset('vendor/libs/select2/select2.css')}}">
@endpush
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Dashboard / Edit Petugas Pelayanan/ </span>{{$keahlian->nama_keahlian}}</h4>
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
            <form action="{{ url('keahlian/'.$keahlian->id)}}"  enctype="multipart/form-data" method="POST" >
                @method('PUT')
                @csrf
                    {{-- <h5 class="modal-title" id="backDropModalTitle">Tambah Petugas Pelayanan</h5> --}}
                {{-- <hr class="my-1" /> --}}
                <input type="hidden" name="old_icon" value="{{$keahlian->icon}}">
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
                            value=" {{ $keahlian->nama_keahlian }}"
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
                                    <option value="1" {{ $keahlian->tampilkan ==1 ? "selected" : null}}>Ya</option>
                                    <option value="2" {{ $keahlian->tampilkan ==2 ? "selected" : null}}>Tidak</option>
                              </select>
                        </div>
                        </div>
                    </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="basic-icon-default-phone">Foto</label>
                    <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                        <input class="form-control @error('icon') is-invalid @enderror" 
                            type="file" 
                            id="formFile" 
                            name="icon"
                            value=""
                            accept="image/*"/>
                    </div>
                    <div class="mt-1">
                        <small><a href="{{ asset($keahlian->icon)}}"> icon Sebelumnya</small></a>
                    </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                   
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a type="button" class="btn btn-secondary float-right" href="{{url('keahlian')}}">
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
