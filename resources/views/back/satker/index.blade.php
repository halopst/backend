@extends('back.layout.template')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Satuan Kerja</h4>

    <!-- Striped Rows -->
    <div class="card">
        <div class="container mt-3">
            <div class="row">
              <div class="col">
                <h5 style="display: inline !important;">Daftar Satuan Kerja</h5> 
              </div>
              <div class="col-auto">
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModal">
                        <span class="tf-icons bx bx-add-to-queue"></span>&nbsp; Tambah Satuan Kerja
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
        
          @if (session('success'))
          <div class="m-4">
            <div class="alert alert-success">
                {{ session('success')}}
            </div>
          </div>      
          @endif
      <div class="table-responsive text-nowrap">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Satker</th>
              <th>Nama Satker</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach ($satker as $item)

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->id_satker }}</td>
                <td>{{ $item->nama_satker }}</td>
                <td>
                    <div class="text-center">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalDelete{{$item->id_satker}}">
                            <span class="tf-icons bx bx-trash"></span>&nbsp; Hapus
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalUpdate{{$item->id_satker}}">
                            <span class="tf-icons bx bx-edit"></span>&nbsp; Edit
                        </button>
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
    @include('back.satker.create-modal')
    <!-- Modal Delete Modal-->
    @include('back.satker.delete-modal')
    <!-- Modal Update Modal-->
    @include('back.satker.update-modal')
  <!-- / Content -->
    
@endsection
