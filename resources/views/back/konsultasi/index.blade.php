@extends('back.layout.template')

@push('css')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/datatable/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{ asset('css/datatable/dataTables.bootstrap5.css')}}">

    <style>
        input[type=time]::-webkit-datetime-edit-ampm-field {
              display: none;
          }
    </style>
@endpush

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Konsultasi Layanan</h4>

    <!-- Striped Rows -->
    <div class="card">
        <div class="container mt-3">
            <div class="row">
              <div class="col">
                <h5 style="display: inline !important;">Daftar Pemintaan Konsultasi</h5> 
              </div>
              {{-- <div class="col-auto">
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        data-bs-toggle="modal"
                        data-bs-target="#createKonsultasiModal">
                        <span class="tf-icons bx bx-add-to-queue"></span>&nbsp; Tambah Kegiatan Konsultasi
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
              <th>Tanggal </th>
              <th>Waktu </th>
              <th>Topik Konsultasi</th>
              <th >Petugas Layanan</th>
              <th >Konsumen</th>
              {{-- <th>E-Mail BPS</th>
              <th>E-Mail Google</th> --}}
              <th>Status</th>
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
    @include('back.konsultasi.create-modal')
    <!-- Modal Approve Modal-->
    @include('back.konsultasi.approve-modal')
    @include('back.konsultasi.cancel-modal')
    @include('back.konsultasi.finish-modal')
    {{-- @include('back.konsultasi.edit-modal') --}}
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

      function openApproveModal(id, event){
         console.log(event);
         var userStatus = "{{ session('keycloak_user')['status'] }}";

          $('#approveKonsultasiModal').modal('show');
          $('#btt-submit-setuju').attr('data-id',id)
          $('#link-meeting').attr('class','form-control');
          $('.invalid-feedback').html('');

          if(event=='approve'){
            $('#backDropModalTitleApprove').html('Setujui Permintaan Konsultasi');
          }else{
            $('#backDropModalTitleApprove').html('Edit Permintaan Konsultasi');
          }
          
         
          if (userStatus == 'Admin') {
              $('#label-petugas').hide();
              $('#petugasContainer').show();
          }else{
            $('#label-petugas').show();
            $('#petugasContainer').hide();
          }

          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type:'POST',
              url:'{{ config('app.url') }}get-konsultasi',
              dataType:"json",
              data:{id:id},
              success: function(response){
                $('#label-nama-konsumen').html(response.konsultasi.pengguna.nama_pengguna);
                $('#label-email-konsumen').html(response.konsultasi.pengguna.email_google);
                $('#label-pekerjaan-konsumen').html(response.konsultasi.pengguna.pekerjaan);
                $('#label-topik-diskusi').html(response.konsultasi.topik_diskusi);
                $('#tanggalKonsultasiApprove').val(response.konsultasi.tanggal_konsultasi);
                $('#waktuKonsultasiApprove').val(response.konsultasi.waktu_konsultasi.substring(0, 5));
                $('#link-meeting-approve').val(response.konsultasi.link_meeting);
                var idPetugas=response.konsultasi.petugas.id;

                $.ajax({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  type:'POST',
                  url:'{{ config('app.url') }}get-petugas',
                  dataType:"json",
                  data:{id:id},
                  success: function(response){
                    $('#idPetugasApprove')
                      .empty()
                      .append('<option value="">-- Pilih Petugas Pelayanan --</option>');
                    response.petugas.forEach(function(option) {
                      console.log(option.id);
                        let optionElement = new Option(option.nama_petugas, option.id);
                        if (option.id === idPetugas ) {
                          console.log('masuk'+option.id);
                            optionElement.selected = true;  // Set option sebagai selected
                            $('#label-petugas').text(option.nama_petugas);
                        }
                        $('#idPetugasApprove').append(optionElement);
                    });
                  }
                });
              }
            });
        
      }


      function openCancelModal(id){
        // console.log('open');
          $('#cancelKonsultasiModal').modal('show');
          $('#btt-submit-cancel').attr('data-id',id)
          $('#alasan-pembatalan').attr('class','form-control');
          $('.invalid-feedback').html('');
          $(".invalid-feedback").css("display", "none");
      }

      function openFinishModal(id){
        // console.log('open');
          $('#finishKonsultasiModal').modal('show');
          $('#btt-submit-finish').attr('data-id',id)
          $('#link-dokumentasi').attr('class','form-control');
          $('.invalid-feedback').html('');
          $(".invalid-feedback").css("display", "none");
      }

      //function batalkan
      function batalkanKonsultasi(e){
        let id=e.getAttribute('data-id');
    
        Swal.fire({
          title: "Batalkan Konsultasi",
          text: "Anda yakin membatalkan reservasi konsultasi ini ?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Ya, Batalkan",
          cancelButtonText: "Tidak"
        }).then((result) => {
          if(result.value){
            $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type:'POST',
              url:'{{ config('app.url') }}edit-status-konsultasi',
              data:{
                id:id, 
                status:'Dibatalkan'},
              dataType:"json",
              success: function(response){
                //console.log('sudah dibatalkan');
                Swal.fire({
                  title: "Dibatalkan",
                  text: response.message,
                  icon: "success",
                  showConfirmButton:false,
                  timer : 2000
                }).then((result)=>{
                  window.location.href='{{ config('app.url') }}konsultasi';
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
            columns: [{ width: '2%' }, { width: '10%' }, { width: '7%' }, { width: '20%' }, { width: '10%' }, { width: '10%' }, { width: '10%' },{ width: '20%' } ],
            columns:[
              {
                data:'DT_RowIndex',
                name:'DT_RowIndex',
                className: "text-center"
              },
              {
                data:'tanggal_konsultasi',
                name:'tanggal_konsultasi'
              },
              {
                data:'waktu_konsultasi',
                className: "text-center",
                name:'waktu_konsultasi'
              },
              {
                data:'topik_diskusi',
                name:'topik_diskusi',
                className:'text-wrap'
              },
              {
                data:'id_petugas',
                name:'id_petugas'
              },
              {
                data:'id_pengguna',
                name:'id_pengguna'
              },
             
              {
                data:'status',
                className: "text-center",
                name:'status'
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
