@extends('back.layout.template')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Master Keahlian</h4>

    <!-- Striped Rows -->
    <div class="card">
        <div class="container mt-3">
            <div class="row">
              <div class="col">
                <h5 style="display: inline !important;">Daftar Keahlian</h5> 
              </div>
              <div class="col-auto">
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        data-bs-toggle="modal"
                        data-bs-target="#createKeahlianModal">
                        <span class="tf-icons bx bx-add-to-queue"></span>&nbsp; Tambah Keahlian
                    </button>
              
              </div>
            </div>
          </div>
        
          @if ($errors->any())
          <div class="m-4">
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
        
          {{-- Success Alert --}}
          <div class="swal" data-swal="{{ session('success')}}"></div>
        
          {{-- @if (session('success'))
          <div class="m-4">
            <div class="alert alert-success">
                {{ session('success')}}
            </div>
          </div>      
          @endif --}}
      <div class="table-responsive text-nowrap">
        <table class="table table-striped">
          <thead>
            <tr>
              {{-- <th>No</th> --}}
              <th class="text-center">Kode Keahlian</th>
              <th>Nama Keahlian</th>
              <th>Tampilkan</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach ($keahlian as $item)

            <tr>
                {{-- <td>{{ $loop->iteration }}</td> --}}
                <td class="text-center">{{ $item->id }}</td>
                <td>{{ $item->nama_keahlian }}</td>
                @if($item->tampilkan==1)
                  <td> Tampil</td>
                @else
                  <td>Tidak Tampil</td>
                @endif
                <td>
                    <div class="text-center">
                      <a type="button" class="btn btn-sm btn-primary" href="keahlian/{{$item->id}}"
                        >
                        <span class="tf-icons bx bx-detail"></span>&nbsp; Detail
                    </a>
                      <a type="button" class="btn btn-sm btn-danger" href="#" onclick="deleteKeahlian(this)" 
                                data-id="{{$item->id}}"><span class="tf-icons bx bx-trash"></span>&nbsp; Hapus</a>
                        <a type="button" class="btn btn-sm btn-warning" href="keahlian/{{$item->id}}/edit">
                          <span class="tf-icons bx bx-edit"></span>&nbsp; Edit
                      </a>
                    </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <!--/ Striped Rows -->

    <hr class="my-5" />

    <!-- Modal Create Modal-->
    @include('back.keahlian.create-modal')
    <!-- Modal Delete Modal-->
    {{-- @include('back.satker.delete-modal') --}}
    <!-- Modal Update Modal-->
    {{-- @include('back.satker.update-modal') --}}
  <!-- / Content -->
    
@endsection

@push('js')
<script src="{{ asset('sweetalert/sweetalert2@11')}}"></script>

<script >
  const swal=$('.swal').data('swal');
  if(swal){
      Swal.fire({
      'title' : 'Pesan Sukses',
      'text'  : swal,
      'icon'  : 'success',
      'showConfirmButton':false,
      'timer' : 3000
    });
  }

  //function delete
  function deleteKeahlian(e){
    let id=e.getAttribute('data-id');

    Swal.fire({
      title: "Hapus",
      text: "Anda yakin menghapus data ini ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
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

      // if (result.isConfirmed) {
      //   Swal.fire({
      //     title: "Deleted!",
      //     text: "Your file has been deleted.",
      //     icon: "success"
      //   });
      // }
    });
  }
  
</script>
@endpush
