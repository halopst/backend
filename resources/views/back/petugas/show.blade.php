@extends('back.layout.template')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Dashboard /</span> Petugas Pelayanan/ {{$petugas->nama_petugas}}</h4>

    <!-- Striped Rows -->
    <div class="card">
        {{-- <h5 class="card-header">Detail Petugas Pelayanan</h5> --}}
        <div class="card-body">
            <div class="text-center">
                <img
                    src="{{asset($petugas->foto)}}"
                    alt="user-avatar"
                    class="rounded-circle"
                    height="100"
                    width="100"
                    id="uploadedAvatar"
                />
                <h4 class="m-0 mt-2">{{$petugas->nama_petugas}}</h3>
                <h6 class="mt-2"> {{$petugas->Satker->nama_satker}}</h6>
            </div>
            <hr class="my-2 mt-0" />

            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <table-body>
                        <tr>
                            <td class="text-center"><b>Nama Panggilan</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">{{ $petugas->nama_panggilan}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><b>Jabatan</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">{{ $petugas->jabatan}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><b>Email BPS </b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">{{ $petugas->email_bps}}</td>
                        </tr>
                        
                        <tr>
                            <td class="text-center"><b>Email Google</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">{{ $petugas->email_google}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><b>Jenis Kelamin</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">
                                @if ($petugas->jenis_kelamin == 1)
                                    Laki-Laki
                                @else
                                    Perempuan
                                @endif</td>
                        </tr>
                        <tr>
                            <td class="text-center"><b>Nomor HP</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">{{ $petugas->no_hp}}</td>
                        </tr>

                        <tr>
                            <td class="text-center"><b>Peran</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">
                                @if ($petugas->status=="Admin")
                                    <span class="badge bg-danger"> {{ $petugas->status}} </span>
                                @else
                                    <span class="badge bg-success"> {{ $petugas->status}} </span>
                                @endif
                                </td>
                        </tr>
                        <tr>
                            <td class="text-center"><b>Nip Lama</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">{{ $petugas->nip_lama}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><b>Tampilkan</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">
                                @if ($petugas->tampil=="0")
                                    <span class="badge bg-danger"> Tidak Tampil</span>
                                @else
                                    <span class="badge bg-success">  Tampil </span>
                                @endif
                            
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><b>Keahlian</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">
                                @foreach ($petugas->keahlian as $ahli)
                                    @if($loop->last)
                                        {{ $ahli->nama_keahlian }}
                                    @else
                                        {{ $ahli->nama_keahlian.' dan ' }}
                                    @endif
                                  
                                @endforeach                            
                            </td>
                        </tr>
                    </table-body>
                </table>
            </div>
        </div>
        <div class="card-footer float-end text-center">
            <a type="button" class="btn btn-secondary float-right" href="{{url('petugas')}}">
                <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Kembali
            </a>
            <a type="button" class="btn btn-warning" href="{{$petugas->id}}/edit">
                Edit
            </a>
            <a type="button" class="btn btn-danger" href="#" onclick="deletePetugas(this)" 
                data-id="{{$petugas->id}}">
             Hapus
            </a>
           
            
            
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('sweetalert/sweetalert2@11')}}"></script>
<script>
    //function delete
    function deletePetugas(e){
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
              url:'{{ config('app.url') }}petugas/'+id,
              dataType:"json",
              success: function(response){
                Swal.fire({
                  title: "Berhasil Dihapus",
                  text: response.message,
                  icon: "success",
                  showConfirmButton:false,
                  timer : 2000
                }).then((result)=>{
                  window.location.href='{{ config('app.url') }}petugas';
                })
              }
            })
          }
        });
      }

</script>

@endpush