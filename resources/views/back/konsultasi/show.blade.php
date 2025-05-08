@extends('back.layout.template')
@section('content')

@push('css')
<link rel="stylesheet" href="{{ asset('css/rateyo/jquery.rateyo.min.css')}}">
@endpush
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Dashboard /</span> Detail Konsultasi</h4>

    <div class="row mb-5">
        <div class="col-md-12 col-lg-6 mb-3">
          <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Informasi Konsultasi</h5>
                <h6 class="card-subtitle text-muted">Tanggal, Waktu & Status</h6>
                <hr class="hr hr-primary">

                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Tanggal</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"> {{$konsultasi->tanggal_konsultasi}}</div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Waktu</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"> {{$konsultasi->waktu_konsultasi}}</div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Topik Diskusi</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"> {{$konsultasi->topik_diskusi}}</div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Link Meeting</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"><a href="{{$konsultasi->link_meeting}}" target="_blank"> {{$konsultasi->link_meeting}}</a></div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Status</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    
                    @if ($konsultasi->status=='Diajukan')
                        <div class="col-sm-8"> 
                            <span class="badge bg-primary mt-1"> Diajukan </span>
                        </div>
                    @elseif($konsultasi->status=='Disetujui')
                        <div class="col-sm-8"> 
                            <span class="badge bg-warning mt-1"> Disetujui </span>
                        </div>
                    @elseif($konsultasi->status=='Dibatalkan')
                        <div class="col-sm-8"> 
                            <span class="badge bg-danger mt-1"> Dibatalkan </span>
                        </div>
                    @elseif($konsultasi->status=='Selesai')
                    <div class="col-sm-8"> 
                        <span class="badge bg-success mt-1"> Selesai </span>
                    </div>
                    @endif
                    </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Penilaian Konsumen</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1">
                        <div id="rateYo"></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Kritik dan Saran</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"> {{$konsultasi->kritik_saran}}</div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Alasan Pembatalan</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"> {{$konsultasi->alasan_pembatalan}}</div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Tanggal diajukan</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"> {{$konsultasi->created_at}}</div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Tanggal diubah</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"> {{$konsultasi->updated_at}}</div>
                </div>
            </div>
            
            {{-- <img class="img-fluid" src="{{ asset('img/elements/13.jpg')}}" alt="Card image cap" /> --}}
            {{-- <div class="card-body">
              <p class="card-text">Bear claw sesame snaps gummies chocolate.</p>
              <a href="javascript:void(0);" class="card-link">Card link</a>
              <a href="javascript:void(0);" class="card-link">Another link</a>
            </div> --}}
          </div>
        </div>
        <div class="col-md-12 col-lg-6 mb-3">
          <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Informasi Petugas & Konsumen</h5>
                <h6 class="card-subtitle text-muted">Detail Petugas & Konsumen Layanan</h6> 
                <hr class="hr hr-primary">
                    {{-- <div class="divider-text"></div> --}}
                
                </hr>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Nama Konsumen</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"> {{$konsultasi->Pengguna->nama_pengguna}}</div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Email</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"> {{$konsultasi->Pengguna->email_google}}</div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Pekerjaan</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"> {{$konsultasi->Pengguna->pekerjaan}}</div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Pendidikan</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"> {{$konsultasi->Pengguna->pendidikan}}</div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Pendidikan</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"> {{$konsultasi->Pengguna->nmr_telp}}</div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Alamat</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    @if($konsultasi->Pengguna->Kabupaten==null)
                        <div class="col-sm-8 mt-1"> -</div>                         
                    @else
                        <div class="col-sm-8 mt-1"> {{$konsultasi->Pengguna->Kabupaten->nama_kab.' - '.$konsultasi->Pengguna->Provinsi->nama_prov}}</div>
                    @endif
                </div>

                <div class="divider divider-primary">
                    <div class="divider-text">Petugas Pelayanan</div>
                </div>

                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Nama Petugas Layanan</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"> {{$konsultasi->Petugas->nama_petugas}}</div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label" for="basic-default-name">Email Google</label>
                    <label class="col-sm-1 col-form-label" for="basic-default-name">:</label>
                    <div class="col-sm-8 mt-1"> {{$konsultasi->Petugas->email_bps}}</div>
                </div>
            </div>
          </div>
        </div>
      </div>
    
</div>
@endsection

@push('js')
<script src="{{ asset('js/rateyo/jquery.rateyo.min.js')}}"></script>
<script>
    $(function () {
        
        $("#rateYo").rateYo({
            rating: {{$konsultasi->rating}},
            maxValue : 10,
            readOnly: true
        });
        });
</script>
@endpush