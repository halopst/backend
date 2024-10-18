@extends('back.layout.template')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-8 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Selamat Datang {{ session('keycloak_user')['name']}} ! 🎉</h5>
                <p class="mb-4">
                  @if($jumlahKonsultasiHariIni==0)
                    Belum ada Jadwal Konsultasi  untuk hari ini. 
                  @else 
                    Ada <b>{{$jumlahKonsultasiHariIni}} </b>permintaan konsultasi hari ini untukmu
                  @endif
                  Lihat jadwal, rating dan kritik saran dari pengguna pada
                  <span class="fw-bold"> menu konsultasi. </span>
                </p>

                <a href="konsultasi" class="btn btn-sm btn-outline-primary">Lihat Jadwal Konsultasi</a>
              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img
                  src="{{ asset('img/illustrations/man-with-laptop-light.png')}}"
                  height="140"
                  alt="View Badge User"
                  data-app-dark-img="illustrations/man-with-laptop-dark.png"
                  data-app-light-img="illustrations/man-with-laptop-light.png"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 order-1">
        <div class="row">
          <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img
                      src="{{asset('img/icons/unicons/chart-success.png')}}"
                      alt="chart success"
                      class="rounded"
                    />
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      id="cardOpt3"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                      <a class="dropdown-item" href="javascript:void(0);">View More</a>
                      <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                    </div>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Petugas Layanan</span>
                <h3 class="card-title mb-2">{{$jumlahPetugas}}</h3>
                {{-- <small class="text-success fw-semibold"> --}}
                  {{-- <i class="bx bx-up-arrow-alt"></i> --}}
                   {{-- orang</small> --}}
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img
                      src="{{ asset('img/icons/unicons/wallet-info.png')}}"
                      alt="Credit Card"
                      class="rounded"
                    />
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      id="cardOpt6"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                      <a class="dropdown-item" href="javascript:void(0);">View More</a>
                      <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                    </div>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Konsumen Layanan</span>
                <h3 class="card-title text-nowrap mb-1">{{$jumlahPengguna}}</h3>
                {{-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Total Revenue -->
      <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card">
          <div class="row row-bordered g-0">
            <div class="col-md-12">
              <h5 class="card-header m-0 me-2 pb-3">Jumlah Permintaan Konsultasi Menurut Kabupaten/Kota</h5>
              <div id="totalRevenueChart" data-konsultasi-selesai="{{ json_encode($jumlahKonsultasiBySatkerSelesai)}}" 
                      data-konsultasi="{{ json_encode($jumlahKonsultasiKabkot) }}" class="px-2"></div>
            </div>
            {{-- <div class="col-md-4">
              <div class="card-body">
                <div class="text-center">
                  <div class="dropdown">
                    <button
                      class="btn btn-sm btn-outline-primary dropdown-toggle"
                      type="button"
                      id="growthReportId"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      2022
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                      <a class="dropdown-item" href="javascript:void(0);">2021</a>
                      <a class="dropdown-item" href="javascript:void(0);">2020</a>
                      <a class="dropdown-item" href="javascript:void(0);">2019</a>
                    </div>
                  </div>
                </div>
              </div>
              <div id="growthChart"></div>
              <div class="text-center fw-semibold pt-3 mb-2">62% Pertumbuhan Permintaan</div>

              <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                <div class="d-flex">
                  <div class="me-2">
                    <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                  </div>
                  <div class="d-flex flex-column">
                    <small>2022</small>
                    <h6 class="mb-0">100</h6>
                  </div>
                </div>
                <div class="d-flex">
                  <div class="me-2">
                    <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                  </div>
                  <div class="d-flex flex-column">
                    <small>2023</small>
                    <h6 class="mb-0">168</h6>
                  </div>
                </div>
              </div>
            </div> --}}
          </div>
        </div>
      </div>
      <!--/ Total Revenue -->
      <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
        <div class="row">
          <div class="col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img src="{{ asset('img/icons/unicons/paypal.png')}}" alt="Credit Card" class="rounded" />
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      id="cardOpt4"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                      <a class="dropdown-item" href="javascript:void(0);">View More</a>
                      <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                    </div>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Permintaan Konsultasi</span>
                <h3 class="card-title text-nowrap mb-2">{{$jumlahkonsultasi}}</h3>
                {{-- <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small> --}}
              </div>
            </div>
          </div>
          <div class="col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img src="{{asset('img/icons/unicons/cc-primary.png')}}" alt="Credit Card" class="rounded" />
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      id="cardOpt1"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                      <a class="dropdown-item" href="javascript:void(0);">View More</a>
                      <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                    </div>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Konsultasi Selesai</span>
                <h3 class="card-title mb-2">{{$jumlahSelesaiKonsultasi}}</h3>
                {{-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.14%</small> --}}
              </div>
            </div>
          </div>
          <!-- </div>
          <div class="row"> -->
          <div class="col-12 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                  <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                    <div class="card-title">
                      <h5 class="text-nowrap mb-2">Tren Jumlah Konsultasi</h5>
                      <span class="badge bg-label-warning rounded-pill">{{$growth[1]}}</span>
                    </div>
                    <div class="mt-sm-auto">
                      <h3 class="mb-0">{{$growth[2]}}</h3>
                            @if($growth[0]<0)
                              <small class="text-danger text-nowrap fw-semibold">
                                <i class="bx bx-chevron-down"></i> {{$growth[0]}}%</small>
                            @else
                              <small class="text-success text-nowrap fw-semibold">
                                <i class="bx bx-chevron-up"></i> {{$growth[0]}}%</small>
                            @endif
                     

                      
                      
                     
                    </div>
                  </div>
                  <div id="profileReportChart" bulan-konsultasi="{{ json_encode($bulanKonsultasi) }}"
                       data-konsultasi-per-bulan="{{ json_encode($jumlahKonsultasiPerBulan) }}"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- <div class="row">
      <!-- Order Statistics -->
      <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between pb-0">
            <div class="card-title mb-0">
              <h5 class="m-0 me-2">Order Statistics</h5>
              <small class="text-muted">42.82k Total Sales</small>
            </div>
            <div class="dropdown">
              <button
                class="btn p-0"
                type="button"
                id="orederStatistics"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                <a class="dropdown-item" href="javascript:void(0);">Share</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="d-flex flex-column align-items-center gap-1">
                <h2 class="mb-2">8,258</h2>
                <span>Total Orders</span>
              </div>
              <div id="orderStatisticsChart"></div>
            </div>
            <ul class="p-0 m-0">
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary"
                    ><i class="bx bx-mobile-alt"></i
                  ></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Electronic</h6>
                    <small class="text-muted">Mobile, Earbuds, TV</small>
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">82.5k</small>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Fashion</h6>
                    <small class="text-muted">T-shirt, Jeans, Shoes</small>
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">23.8k</small>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Decor</h6>
                    <small class="text-muted">Fine Art, Dining</small>
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">849k</small>
                  </div>
                </div>
              </li>
              <li class="d-flex">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-secondary"
                    ><i class="bx bx-football"></i
                  ></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Sports</h6>
                    <small class="text-muted">Football, Cricket Kit</small>
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">99</small>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div> --}}
      <!--/ Order Statistics -->

      <!-- Expense Overview -->
      {{-- <div class="col-md-6 col-lg-4 order-1 mb-4">
        <div class="card h-100">
          <div class="card-header">
            <ul class="nav nav-pills" role="tablist">
              <li class="nav-item">
                <button
                  type="button"
                  class="nav-link active"
                  role="tab"
                  data-bs-toggle="tab"
                  data-bs-target="#navs-tabs-line-card-income"
                  aria-controls="navs-tabs-line-card-income"
                  aria-selected="true"
                >
                  Income
                </button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab">Expenses</button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab">Profit</button>
              </li>
            </ul>
          </div>
          <div class="card-body px-0">
            <div class="tab-content p-0">
              <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                <div class="d-flex p-4 pt-3">
                  <div class="avatar flex-shrink-0 me-3">
                    <img src="{{ asset('img/icons/unicons/wallet.png')}}" alt="User" />
                  </div>
                  <div>
                    <small class="text-muted d-block">Total Balance</small>
                    <div class="d-flex align-items-center">
                      <h6 class="mb-0 me-1">$459.10</h6>
                      <small class="text-success fw-semibold">
                        <i class="bx bx-chevron-up"></i>
                        42.9%
                      </small>
                    </div>
                  </div>
                </div>
                <div id="incomeChart"></div>
                <div class="d-flex justify-content-center pt-4 gap-2">
                  <div class="flex-shrink-0">
                    <div id="expensesOfWeek"></div>
                  </div>
                  <div>
                    <p class="mb-n1 mt-1">Expenses This Week</p>
                    <small class="text-muted">$39 less than last week</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> --}}
      <!--/ Expense Overview -->

      <!-- Transactions -->
      {{-- <div class="col-md-6 col-lg-4 order-2 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Transactions</h5>
            <div class="dropdown">
              <button
                class="btn p-0"
                type="button"
                id="transactionID"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <ul class="p-0 m-0">
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="{{ asset('img/icons/unicons/paypal.png')}}" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <small class="text-muted d-block mb-1">Paypal</small>
                    <h6 class="mb-0">Send money</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0">+82.6</h6>
                    <span class="text-muted">USD</span>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="{{asset('img/icons/unicons/wallet.png')}}" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <small class="text-muted d-block mb-1">Wallet</small>
                    <h6 class="mb-0">Mac'D</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0">+270.69</h6>
                    <span class="text-muted">USD</span>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="{{ asset('img/icons/unicons/chart.png')}}" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <small class="text-muted d-block mb-1">Transfer</small>
                    <h6 class="mb-0">Refund</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0">+637.91</h6>
                    <span class="text-muted">USD</span>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="{{ asset('img/icons/unicons/cc-success.png')}}" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <small class="text-muted d-block mb-1">Credit Card</small>
                    <h6 class="mb-0">Ordered Food</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0">-838.71</h6>
                    <span class="text-muted">USD</span>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="{{ asset('img/icons/unicons/wallet.png')}}" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <small class="text-muted d-block mb-1">Wallet</small>
                    <h6 class="mb-0">Starbucks</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0">+203.33</h6>
                    <span class="text-muted">USD</span>
                  </div>
                </div>
              </li>
              <li class="d-flex">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="{{ asset('img/icons/unicons/cc-warning.png')}}" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <small class="text-muted d-block mb-1">Mastercard</small>
                    <h6 class="mb-0">Ordered Food</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0">-92.45</h6>
                    <span class="text-muted">USD</span>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div> --}}
      <!--/ Transactions -->
    </div>
  </div>
  <!-- / Content -->
    
  
@endsection

@push('js')
<!-- Page JS -->
{{-- <script src="{{ asset('js/dashboards-analytics.js') }}"> --}}
  
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var jumlahKonsultasiKabkot = JSON.parse(document.getElementById('totalRevenueChart').getAttribute('data-konsultasi'));
    var jumlahKonsultasiBySatkerSelesai=  JSON.parse(document.getElementById('totalRevenueChart').getAttribute('data-konsultasi-selesai'));  
    var jumlahKonsultasiPerBulan = JSON.parse(document.getElementById('profileReportChart').getAttribute('data-konsultasi-per-bulan'));
    var bulanKonsultasi = JSON.parse(document.getElementById('profileReportChart').getAttribute('bulan-konsultasi'));
  
    console.log(jumlahKonsultasiPerBulan);
    let cardColor, headingColor, axisColor, shadeColor, borderColor;

    cardColor = config.colors.white;
    headingColor = config.colors.headingColor;
    axisColor = config.colors.axisColor;
    borderColor = config.colors.borderColor;

  // Total Revenue Report Chart - Bar Chart
  // --------------------------------------------------------------------
  const totalRevenueChartEl = document.querySelector('#totalRevenueChart'),
    totalRevenueChartOptions = {
      series: [
        {
          name: 'Jumlah Permintaan Konsultasi',
          data: jumlahKonsultasiKabkot
        },
        {
          name: 'Jumlah Konsultasi Selesai',
          data: jumlahKonsultasiBySatkerSelesai
        }
        // {
        //   name: 'Selesai',
        //   data: [18, 7, 15, 29, 18, 12, 9]
        // }
        // ,
        // {
        //   name: 'Dibatalkan',
        //   data: [-13, -18, -9, -14, -5, -17, -15]
        // }
      ],
      chart: {
        height: 300,
        stacked: false,
        type: 'bar'
        // ,
        // toolbar: { show: false }
      },
      plotOptions: {
        bar: {
          vertical: true ,
          //  columnWidth: '33%',
           borderRadius: 12,
           dataLabels: {
            position: "top" // top, center, bottom
          }
          //  startingShape: 'rounded'
          //  endingShape: 'rounded'
        }
      },
      colors: [config.colors.primary, config.colors.info],
      dataLabels: {
        enabled: true,
        style: {
          // fontSize: "12px",
          colors: ["#304758"]
        },
        formatter: function(val) {
          return val;
        },
        offsetY: -20
      },
        // stroke: {
        //   curve: 'smooth',
        //   width: 6,
        //   lineCap: 'round',
        //   colors: [cardColor]
        // },
      legend: {
        show: true,
        horizontalAlign: 'left',
        position: 'top',
        markers: {
          height: 8,
          width: 8,
          radius: 12,
          offsetX: -3
        },
        labels: {
          colors: axisColor
        },
        itemMargin: {
          horizontal: 10
        }
      },
      grid: {
        borderColor: borderColor,
        padding: {
          top: 0,
          bottom: -8,
          left: 20,
          right: 20
        }
      },
      xaxis: {
        categories: ['3500', '3501', '3502', '3503', '3504', '3506', '3507', '3508'
            , '3509', '3510', '3511', '3512', '3513', '3514'
            , '3515', '3516', '3517', '3518', '3519', '3520'
            , '3521', '3522', '3523', '3524', '3525', '3526'
            , '3527', '3528', '3529', '3571', '3572', '3573'
            , '3574', '3575', '3576', '3577', '3578', '3579'],
        labels: {
          style: {
            fontSize: '10px',
            colors: axisColor
          }
        },
        axisTicks: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        labels: {
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        }
      },
      responsive: [
        {
          breakpoint: 1700,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '32%'
              }
            }
          }
        }
        // ,
        // {
        //   breakpoint: 1580,
        //   options: {
        //     plotOptions: {
        //       bar: {
        //         borderRadius: 10,
        //         columnWidth: '35%'
        //       }
        //     }
        //   }
        // },
        // {
        //   breakpoint: 1440,
        //   options: {
        //     plotOptions: {
        //       bar: {
        //         borderRadius: 10,
        //         columnWidth: '42%'
        //       }
        //     }
        //   }
        // },
        // {
        //   breakpoint: 1300,
        //   options: {
        //     plotOptions: {
        //       bar: {
        //         borderRadius: 10,
        //         columnWidth: '48%'
        //       }
        //     }
        //   }
        // },
        // {
        //   breakpoint: 1200,
        //   options: {
        //     plotOptions: {
        //       bar: {
        //         borderRadius: 10,
        //         columnWidth: '40%'
        //       }
        //     }
        //   }
        // },
        // {
        //   breakpoint: 1040,
        //   options: {
        //     plotOptions: {
        //       bar: {
        //         borderRadius: 11,
        //         columnWidth: '48%'
        //       }
        //     }
        //   }
        // },
        // {
        //   breakpoint: 991,
        //   options: {
        //     plotOptions: {
        //       bar: {
        //         borderRadius: 10,
        //         columnWidth: '30%'
        //       }
        //     }
        //   }
        // },
        // {
        //   breakpoint: 840,
        //   options: {
        //     plotOptions: {
        //       bar: {
        //         borderRadius: 10,
        //         columnWidth: '35%'
        //       }
        //     }
        //   }
        // },
        // {
        //   breakpoint: 768,
        //   options: {
        //     plotOptions: {
        //       bar: {
        //         borderRadius: 10,
        //         columnWidth: '28%'
        //       }
        //     }
        //   }
        // },
        // {
        //   breakpoint: 640,
        //   options: {
        //     plotOptions: {
        //       bar: {
        //         borderRadius: 10,
        //         columnWidth: '32%'
        //       }
        //     }
        //   }
        // },
        // {
        //   breakpoint: 576,
        //   options: {
        //     plotOptions: {
        //       bar: {
        //         borderRadius: 10,
        //         columnWidth: '37%'
        //       }
        //     }
        //   }
        // },
        // {
        //   breakpoint: 480,
        //   options: {
        //     plotOptions: {
        //       bar: {
        //         borderRadius: 10,
        //         columnWidth: '45%'
        //       }
        //     }
        //   }
        // },
        // {
        //   breakpoint: 420,
        //   options: {
        //     plotOptions: {
        //       bar: {
        //         borderRadius: 10,
        //         columnWidth: '52%'
        //       }
        //     }
        //   }
        // },
        // {
        //   breakpoint: 380,
        //   options: {
        //     plotOptions: {
        //       bar: {
        //         borderRadius: 10,
        //         columnWidth: '60%'
        //       }
        //     }
        //   }
        // }
      ],
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
  if (typeof totalRevenueChartEl !== undefined && totalRevenueChartEl !== null) {
    const totalRevenueChart = new ApexCharts(totalRevenueChartEl, totalRevenueChartOptions);
    totalRevenueChart.render();
  }
  

   
  const profileReportChartEl = document.querySelector('#profileReportChart'),
    profileReportChartConfig = {
      chart: {
        height: 115,
        // width: 175,
        type: 'line',
        toolbar: {
          show: false
        },
        dropShadow: {
          enabled: true,
          top: 10,
          left: 5,
          blur: 3,
          color: config.colors.warning,
          opacity: 0.15
        },
        sparkline: {
          enabled: true
        }
      },
      grid: {
        show: false,
        padding: {
          right: 8
        }
      },
      colors: [config.colors.warning],
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 5,
        curve: 'smooth'
      },
      series: [
        {
          name:'Permintaan Konsultasi',
          // data:[10, 20, 15, 25, 5, 85]
          data: jumlahKonsultasiPerBulan
          // data: jumlahKonsultasiPerBulan
        }
        // ,
        // {
        //   name:'b',
        //   data:[10, 20, 15, 25, 5, 85]
        // }
      ],
      xaxis: {
        categories: bulanKonsultasi,
        show: false,
        lines: {
          show: false
        },
        labels: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        show: false
      }
    };
  if (typeof profileReportChartEl !== undefined && profileReportChartEl !== null) {
    const profileReportChart = new ApexCharts(profileReportChartEl, profileReportChartConfig);
    profileReportChart.render();
  }
});
  </script>

<script>
  
</script>
@endpush
