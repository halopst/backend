@extends('back.layout.template')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Dashboard /</span> Keahlian / {{$keahlian->nama_keahlian}}</h4>

    <!-- Striped Rows -->
    <div class="card">
        
        <div class="card-body">
            <div class="text-center">
                <img
                    src="{{asset($keahlian->icon)}}"
                    alt="user-avatar"
                    class="rounded-circle"
                    height="100"
                    width="100"
                    id="uploadedAvatar"
                />
            
            </div>
            <hr class="my-2 mt-0" />

            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <table-body>
                        <tr>
                            <td class="text-center"><b>Nama Kehalian</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">{{ $keahlian->nama_keahlian}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><b>Tampilkan</b></td>
                            <td class="text-center">:</td>
                            <td class="text-center">
                                @if ($keahlian->tampilkan == 1)
                                    Tampil
                                @else
                                    Tidak Tampil
                                @endif</td>
                        </tr>
                    </table-body>
                </table>
            </div>
        </div>
        <div class="card-footer float-end text-center">
            <a type="button" class="btn btn-secondary float-right" href="{{url('keahlian')}}">
                <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Kembali
            </a>
            <a type="button" class="btn btn-warning" href="{{$keahlian->id}}/edit">
                Edit
            </a>
            <a type="button" class="btn btn-danger" href="#" onclick="deleteKeahlian(this)" 
                data-id="{{$keahlian->id}}">
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
    function deleteKeahlian(e){
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
              url:'{{ config('app.url') }}keahlian/'+id,
              dataType:"json",
              success: function(response){
                Swal.fire({
                  title: "Berhasil Dihapus",
                  text: response.message,
                  icon: "success",
                  showConfirmButton:false,
                  timer : 2000
                }).then((result)=>{
                  window.location.href='{{ config('app.url') }}keahlian';
                })
              }
            })
          }
        });
      }

</script>

@endpush