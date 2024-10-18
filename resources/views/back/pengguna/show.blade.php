@extends('back.layout.template')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Dashboard /</span> Konsumen / {{$pengguna->nama_pengguna}}</h4>

    <!-- Striped Rows -->
    <div class="card">
        {{-- <h5 class="card-header">Detail Pengguna Pelayanan</h5> --}}
        <div class="card-body">
            <div class="text-center">
                <img
                    src="{{asset($pengguna->foto)}}"
                    alt="user-avatar"
                    class="rounded-circle"
                    height="100"
                    width="100"
                    id="uploadedAvatar"
                />
                <h4 class="m-0 mt-2">{{$pengguna->nama_pengguna}}</h3>
                <h6 class="mt-2"> {{$pengguna->email_google}}</h6>
            </div>
            <hr class="my-2 mt-0" />

            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <table-body>
                        <tr>
                            <td class="text-center"><b>Given Name </b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">{{ $pengguna->given_name}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><b>Family Name</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">{{ $pengguna->family_name}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><b>Nomor HP</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">{{ $pengguna->nmr_telp}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><b>Tanggal Lahir</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">{{ $pengguna->tanggal_lahir}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><b>Pekerjaan</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">{{ $pengguna->pekerjaan}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><b>Pendidikan</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">{{ $pengguna->pendidikan}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><b>Jenis Kelamin</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">{{ $pengguna->jenis_kelamin}}</td>
                        
                        </tr>
                        <tr>
                            <td class="text-center"><b>Alamat </b></td>
                            <td class="text-center">:</td>
                            @if($pengguna->Kabupaten==null)
                                <td class="text-center">-</td>                           
                            @else
                                <td class="text-center">{{ $pengguna->Kabupaten->nama_kab.' - '.$pengguna->Provinsi->nama_prov}}</td>
                            @endif
                            </tr>
                    </table-body>
                </table>
            </div>
        </div>
        @if(session('keycloak_user')['id_satker']=='3500' && session('keycloak_user')['status']=='Admin'){
             
            <div class="card-footer float-end text-center">
                <a type="button" class="btn btn-secondary float-right" href="{{url('pengguna')}}">
                    <span class="tf-icons bx bx-arrow-back"></span>
                    &nbsp; Kembali
                </a>
                {{-- <a type="button" class="btn btn-warning" href="{{$pengguna->id}}/edit">
                    Edit
                </a> --}}
                <a type="button" class="btn btn-danger" href="#" onclick="deletePengguna(this)" 
                        data-id="{{$pengguna->id}}">
                        <span class="tf-icons bx bx-trash"></span>
                    Hapus
                </a>    
            </div>
        @endif 
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('sweetalert/sweetalert2@11')}}"></script>
<script>
    //function delete
    function deletePengguna(e){
        let id=e.getAttribute('data-id');

        Swal.fire({
          title: "Hapus",
          text: "Anda yakin menghapus data ini ?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor:"#d33",
          cancelButtonColor:  "#3085d6",
          confirmButtonText: "Hapus",
          cancelButtonText: "Batal"
        }).then((result) => {
          if(result.value){
            $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type:'DELETE',
              url:'{{ config('app.url') }}pengguna/'+id,
              dataType:"json",
              success: function(response){
                Swal.fire({
                  title: "Berhasil Dihapus",
                  text: response.message,
                  icon: "success",
                  showConfirmButton:false,
                  timer : 2000
                }).then((result)=>{
                  window.location.href='{{ config('app.url') }}pengguna';
                })
              }
            })
          }
        });
      }

</script>

@endpush