@extends('back.layout.template')

@push('css')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/datatable/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{ asset('css/datatable/dataTables.bootstrap5.css')}}">
@endpush

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Pengguna Layanan</h4>

    <!-- Striped Rows -->
    <div class="card">
        <div class="container mt-3">
            <div class="row">
              <div class="col">
                <h5 style="display: inline !important;">Daftar Pengguna Layanan</h5> 
              </div>
              {{-- <div class="col-auto">
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        data-bs-toggle="modal"
                        data-bs-target="#createPenggunaModal">
                        <span class="tf-icons bx bx-add-to-queue"></span>&nbsp; Daftarkan Konsumen
                    </button>
              </div> --}}
            </div>
          </div>
        
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

          {{-- Success Alert --}}
          <div class="swal" data-swal="{{ session('success')}}"></div>
        
          {{-- @if (session('success'))
          <div class="m-4 mb-1">
            <div class="alert alert-success">
                {{ session('success')}}
            </div>
          </div>      
          @endif --}}
      <div class="table-responsive text-nowrap m-4 mt-0">
        <table class="table table-striped" id="dataTable">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th>Nama Konsumen </th>
              {{-- <th >Satuan Kerja</th> --}}
              <th>E-Mail </th>
              {{--<th>E-Mail Google</th> --}}
               <th>Pekerjaan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
          </tbody>
        </table>
      </div>
    </div>
    <!--/ Striped Rows -->

    <hr class="my-5" />

    <!-- Modal Create Modal-->
    @include('back.pengguna.create-modal')
    <!-- Modal Delete Modal-->
    {{-- @include('back.satker.delete-modal') --}}
    <!-- Modal Update Modal-->
    {{-- @include('back.satker.update-modal') --}}
  <!-- / Content -->
    
@endsection

@push('js')
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}
    <script src="{{ asset('js/datatable/jquery-3.7.1.js') }}"></script>
    {{-- ?<script src="{{ asset('js/datatable/bootstrap.bundle.min.js')}}"></script> --}}
    <script src="{{ asset('js/datatable/dataTables.js')}}"></script>
    <script src="{{ asset('js/datatable/dataTables.bootstrap5.js')}}"></script>
    <script src="{{ asset('js/datatable/dataTables.responsive.js')}}"></script>
    <script src="{{ asset('js/datatable/responsive.bootstrap5.js')}}"></script>
    <script src="{{ asset('sweetalert/sweetalert2@11')}}"></script>

    {{-- Sweetalert --}}
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
      function deletePengguna(e){
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

    {{-- Data Table --}}
    <script>
      // new DataTable('#dataTable', {
     $(document).ready(function(){
        $('#dataTable').DataTable({
            responsive: true,
            processing:true,
            serverside:true,
            ajax:'{{url()->current()}}',
            columns:[
              {
                data:'DT_RowIndex',
                name:'DT_RowIndex',
                className: "text-center"
              },
              {
                data:'nama_pengguna',
                name:'nama_pengguna'
              },
              {
                data:'email_google',
                name:'email_google'
              },
              {
                data:'pekerjaan',
                name:'pekerjaan'
              },
               {
                data:'aksi',
                className: "text-center",
                name:'aksi'
              }
            ]
        })
      })
          
    </script>
@endpush
