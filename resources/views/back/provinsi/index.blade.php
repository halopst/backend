@extends('back.layout.template')

@push('css')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/datatable/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{ asset('css/datatable/dataTables.bootstrap5.css')}}">
@endpush

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Petugas Pelayanan</h4>

    <!-- Striped Rows -->
    <div class="card">
        <div class="container mt-3">
            <div class="row">
              <div class="col">
                <h5 style="display: inline !important;">Daftar Petugas Pelayanan</h5> 
              </div>
              <div class="col-auto">
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        data-bs-toggle="modal"
                        data-bs-target="#createPetugasModal">
                        <span class="tf-icons bx bx-add-to-queue"></span>&nbsp; Tambah Master Provinsi
                    </button>
              
              </div>
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
              <th>Kode Provinsi</th>
              <th>Nama Provinsi</th>
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
    {{-- @include('back.petugas.create-modal') --}}
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
          'title' : 'Sukses',
          'text'  : swal,
          'icon'  : 'success',
          'showConfirmButton':false,
          'timer' : 3000
        });
      }

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
                data:'id_prov',
                name:'id_prov',
                className: "text-center"
              },
              {
                data:'nama_prov',
                name:'nama_prov'
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
