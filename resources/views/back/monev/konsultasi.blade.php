@extends('back.layout.template')

@push('css')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/datatable/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{ asset('css/datatable/dataTables.bootstrap5.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@endpush

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Monitoring /</span> Konsultasi</h4>
    
  <div class="card">
        <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 style="display: inline !important;color:#696cff"> Jumlah Konsultasi Menurut Bulan </h5> 
                
              </div>
            </div>
            <div class="row justify-content-start">
              <div class="col-3">
                <select class="form-select btn btn-sm btn-outline-primary" id="filter-tahun-1">
                  <option value ="" selected>-- Pilih Tahun --</option>
                </select>
              </div>
              <div class="col-3">
                <select class="form-select btn btn-sm btn-outline-primary" id="filter-satker-1">
                  <option value ="" selected>-- Pilih Satker --</option>
                </select>
              </div>
              <!-- <div class="col-2">
                <button type="button" class="btn btn-primary" id="filter-tombol-card1">Terapkan</button>
              </div> -->
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div id="chart1"></div>
                </div>
            </div>
          
        </div>
    </div> 
  <br>

  <div class="card">
        <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 style="display: inline !important;color:#696cff">Status Konsultasi Menurut Satuan Kerja </h5> 
                <br>
              </div>
            </div>
            <div class="row justify-content-start">
              <div class="col-3">
                <select class="form-select btn btn-sm btn-outline-primary" id="filter-tahun-2">
                  <option value ="" selected>-- Pilih Tahun --</option>
                  
                </select>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div id="chart2"></div>
                </div>
            </div>
          
        </div>
    </div> 
  <br>
  
  <div class="card">
        <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 style="display: inline !important;color:#696cff">Performa Petugas Konsultasi</h5> 
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <table id="konsultasiTable" class="table table-hover" style="width:100%">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Nama Petugas</th>
                              <th>Nama Satker</th>
                              <th>Jumlah Konsultasi</th>
                              <th>Success Rate</th>
                              <th>Rata-rata Rating</th>
                              
                              <th>Aksi</th>
                          </tr>
                      </thead>
                  </table>
                </div>
            </div>
          
        </div>
    </div>
</div> 

    
@endsection

@push('js')
<!-- Page JS -->



<script src="{{ asset('js/datatable/jquery-3.7.1.js') }}"></script>
<script src="{{ asset('js/datatable/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('js/datatable/dataTables.js')}}"></script>
<script src="{{ asset('js/datatable/dataTables.bootstrap5.js')}}"></script>
<script src="{{ asset('js/datatable/dataTables.responsive.js')}}"></script>
<script src="{{ asset('js/datatable/responsive.bootstrap5.js')}}"></script>
<script src="{{ asset('sweetalert/sweetalert2@11')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0"></script>


<script>
/**
 * Document ready function to initialize the page.
 * 
 * 1. fetchSatkers: Mengambil daftar Satker untuk kebutuhan filter data.
 * 2. fetchTahun: Mengambil daftar tahun untuk kebutuhan filter data.
 * 3. renderChart1: Merender chart pertama (Jumlah Konsultasi Menurut Bulan).
 * 4. fetchMonevData: Mengambil data monitoring dan evaluasi berdasarkan tahun dan Satker.
 * 5. renderChart2: Merender chart kedua (Status Konsultasi Menurut Satuan Kerja).
 * 6. fetchMonevDataBySatker: Mengambil data monitoring dan evaluasi berdasarkan Satker.
 * 
 * Event Listeners:
 * - Mengambil data monitoring dan evaluasi ketika filter tahun atau Satker berubah.
 * - Mengambil data monitoring dan evaluasi ketika tombol filter diklik.
 * 
 * Initial Data Fetch:
 * - Mengambil data monitoring dan evaluasi saat pertama kali halaman dimuat dengan tahun saat ini.
 */
</script>

<script>
  
  $(document).ready(function () {


    //0. Menyimpan variabel Chart supaya ketika didestroy bisa diinisialisasi ulang
    let chartone = null;
    let chart2 = null;
    let chart3 = null;


    // 1. Fungsi Untuk Mengambil Daftar Satker Untuk Kebutuhan Filter Data
    function fetchSatkers() {
      $.ajax({
        url: "/get-data-satker",
        type: "GET",
        success: function (response) {
          //console.log("Data Satker:", response);
          
          // Kosongkan dulu select sebelum menambahkan data baru
          $("#filter-satker-1").empty().append('<option value="">-- Pilih Satker --</option>');

          $("#filter-satker-1").append(
              `<option value="">Seluruh Satker</option>`
            );
          // Looping data dan tambahkan ke select
          $.each(response, function (index, satker) {
            $("#filter-satker-1").append(
              `<option value="${satker.id_satker}">${satker.nama_satker}</option>`
            );
          });
        },
        error: function (xhr, status, error) {
          //console.error("Error:", error);
        }
      });
    }


    // 2. Fungsi Untuk Mengambil Daftar Tahun Untuk Kebutuhan Filter Data
    function fetchTahun() {
      $.ajax({
        url: "/get-tahun", // Menggunakan route baru
        type: "GET",
        success: function (response) {
          //console.log("Daftar Tahun:", response); // Cek di console

          // Kosongkan dulu select sebelum menambahkan data baru
          $("#filter-tahun-1").empty().append('<option value="">-- Pilih Tahun --</option>');
          $("#filter-tahun-2").empty().append('<option value="">-- Pilih Tahun --</option>');

          // Tambahkan setiap tahun ke dalam select
          $.each(response, function (index, tahun) {
            $("#filter-tahun-1").append(
              `<option value="${tahun}">${tahun}</option>`
            );
            $("#filter-tahun-2").append(
              `<option value="${tahun}">${tahun}</option>`
            );
            $("#filter-tahun-3").append(
              `<option value="${tahun}">${tahun}</option>`
            );
          });
        },
        error: function (xhr, status, error) {
          //console.error("Error:", error);
        }
      });
    }

    // Run fungsi 1 dan 2 untuk mengambil datanya dan ditampilkan pada filter
    fetchSatkers();
    fetchTahun();


    /*
    * Fungsi untuk merender chart pertama (Jumlah Konsultasi Menurut Bulan)
      1. Fungsi Chart 1
      2. Fetch Data
      3. Generate Chart
      4. Event Listener Kalau Filter Berubah
      5. Jalankan Fungsi 1,2,3 saat pertanma kali load halaman dengan default tahun 2024 dengan filter seluruh satker
    */


    //1. Fungsi Chart 1
    function renderChart1(categories, diajukan, disetujui, selesai, dibatalkan) {

      
      
      var options = {
        series: [
            { name: "Diajukan", data: diajukan },
            { name: "Disetujui", data: disetujui },
            { name: "Selesai", data: selesai },
            { name: "Dibatalkan", data: dibatalkan }
        ],
        chart: { type: "bar", height: 400 },
        xaxis: { categories: categories },
        colors: ["#ffc107", "#0dcaf0", "#20c997", "#dc3545"],
        tooltip: {
            y: {
                formatter: function (val) {
                    return Math.round(val); // Menghilangkan desimal
                }
            }
        }
    };


    if (window.chart1 && typeof window.chart1.destroy === "function") {
            window.chart1.destroy();
            //console.log('didestroy');
        }

    window.chart1 = new ApexCharts(document.querySelector("#chart1"), options);
    window.chart1.render();
      }


    //2. Fetch Data
    function fetchMonevData(tahun, idSatker = null) {
      $.ajax({
        url: "/get-data-konsultasi",
        type: "GET",
        data: {
          tahun: tahun,
          id_satker: idSatker
        },
        success: function (response) {
          //console.log("Data Konsultasi:", response);
          if (response.length === 0) { 
            Swal.fire({
              icon: "warning",
              title: "Data Tidak Ditemukan",
              text: "Tidak ada hasil untuk filter yang dipilih.",
            });
          }
          
          //console.log('disini');// Menampilkan hasil ke console

          

          const namaBulan = [
              "Januari", "Februari", "Maret", "April", "Mei", "Juni",
              "Juli", "Agustus", "September", "Oktober", "November", "Desember"
          ];

           // Inisialisasi data dengan semua bulan dan nilai 0
            let dataMap = {};
            namaBulan.forEach((bulan, index) => {
                dataMap[index + 1] = { // Index+1 agar sesuai dengan bulan (1-12)
                    bulan: bulan,
                    diajukan: 0,
                    disetujui: 0,
                    selesai: 0,
                    dibatalkan: 0
                };
            });

            // Isi dataMap dengan hasil query dari database
            response.forEach(item => {
                let bulanIndex = item.bulan; // Bulan dari DB (1-12)
                dataMap[bulanIndex] = {
                    bulan: namaBulan[bulanIndex - 1], // Nama bulan
                    diajukan: item.diajukan,
                    disetujui: item.disetujui,
                    selesai: item.selesai,
                    dibatalkan: item.dibatalkan
                };
            });

          let bulan = [];
          let bulan2 = [];
          let diajukan = [];
          let disetujui = [];
          let selesai = [];
          let dibatalkan = [];

          Object.values(dataMap).forEach(item => {
                bulan2.push(item.bulan);
                diajukan.push(item.diajukan);
                disetujui.push(item.disetujui);
                selesai.push(item.selesai);
                dibatalkan.push(item.dibatalkan);
            });
          

          //3. Render Chart
          //console.log('hahaha');
          renderChart1(bulan2, diajukan, disetujui, selesai, dibatalkan);


        },
        error: function (xhr, status, error) {
          //console.error("Error:", error);
        }
      });


      //4. Event Listener Kalau Filter Berubah
      


      

    }
    
    $('#filter-tahun-1').on('change', function() {
        let tahun = $(this).val();
        let idSatker = $('#filter-satker-1').val();
        event.preventDefault(); // Mencegah reload halaman
        fetchMonevData(tahun, idSatker);
      });

      $('#filter-satker-1').on('change', function() {
        let idSatker = $(this).val();
        let tahun = $('#filter-tahun-1').val();
        event.preventDefault(); // Mencegah reload halaman
        fetchMonevData(tahun, idSatker);
      });








    /*
    * Fungsi untuk merender chart kedua (Status Konsultasi Menurut Satuan Kerja)
      1. Fungsi Chart 2
      2. Fetch Data
      3. Generate Chart
      4. Event Listener Kalau Filter Berubah
      5. Jalankan Fungsi 1,2,3 saat pertanma kali load halaman dengan defaut tahun 2024
    */

    //1. Fungsi Chart 2
    function renderChart2(data) {
        let categories = data.map(item =>  item.nama_satker);
        let diajukan = data.map(item => item.diajukan);
        let disetujui = data.map(item => item.disetujui);
        let selesai = data.map(item => item.selesai);
        let dibatalkan = data.map(item => item.dibatalkan);

        let options = {
            chart: {
                type: "bar",
                stacked : true,
                height: 800
            },
            legend: {
              position: 'top'
            },
            series: [
                { name: "Diajukan", data: diajukan },
                { name: "Disetujui", data: disetujui },
                { name: "Selesai", data: selesai },
                { name: "Dibatalkan", data: dibatalkan }
            ],
            plotOptions:{
              bar :{
                horizontal:true
              }
            },
            xaxis: {
                categories: categories
            },
            colors: ["#ffc107", "#0dcaf0", "#20c997", "#dc3545"]
        };

        if (window.chart2 && typeof window.chart2.destroy === "function") {
            window.chart2.destroy();
        }

        window.chart2 = new ApexCharts(document.querySelector("#chart2"), options);
        window.chart2.render();
    }

    //2. Fetch Data
    function fetchMonevDataBySatker(tahun) {
      $.ajax({
          url: "/get-data-konsultasi-group-satker", // Sesuaikan dengan endpoint
          type: "GET",
          data: { tahun: tahun },
          success: function(response) {
              //console.log("Data Monev per Satker:", response);
              if (response.length === 0) {
                  Swal.fire("Data Tidak Ditemukan", "Tidak ada data untuk tahun ini.", "warning");
                  return;
              }
              //3. Generate Chart
              renderChart2(response);
          },
          error: function(xhr, status, error) {
              //console.error("Error:", error);
          }
      });
    }

    //4. Event Listener Kalau Filter Berubah
    $('#filter-tahun-2').on('change', function() {
        let tahun = $(this).val();
        event.preventDefault(); // Mencegah reload halaman
        fetchMonevDataBySatker(tahun);
    });

    /* SELESAI CHART 2 */


    $('#konsultasiTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ url('monev-konsultasi-petugas') }}",
          type: "GET",
          dataSrc: function(json) {
              //console.log("DataTables Response: ", json); // Debug JSON response
              return json.data;
          },
        },
        scrollX: true,
        responsive: true,
        columns: [
            { data: "DT_RowIndex", name: "DT_RowIndex" }, // Menggunakan index dari server
            { data: "nama_petugas", name: "nama_petugas" },
            { data: "nama_satker", name: "nama_satker" },
            { data: "total_konsultasi", name: "total_konsultasi" },
            {
              data:'success_rate',
              name:'success_rate',
              render: function(data) {
                  let rate = parseFloat(data) || 0;
                  return `
                      <div class="progress" style="height: 15px;">
                          <div class="progress-bar bg-success" role="progressbar" style="width: ${rate}%;"
                              aria-valuenow="${data}" aria-valuemin="0" aria-valuemax="100">
                                ${Math.round(rate)}%
                          </div>
                      </div>
                  `;
              }
            },
            { 
              data: 'rata_rata_rating',
              name: 'rata_rata_rating',
              render: function(data) {
                  if(data===null){
                    return ""; 
                  }
                  else{
                    let stars = "";
                    let fullStars = Math.floor(data); // Bintang penuh
                    let halfStar = data % 1 !== 0; // Bintang setengah jika rating desimal

                    // Tambahkan bintang penuh
                    for (let i = 0; i < fullStars; i++) {
                        stars += "<i class='fas fa-star text-warning'></i> ";
                    }

                    // Tambahkan bintang setengah jika ada
                    if (halfStar) {
                        stars += "<i class='fas fa-star-half-alt text-warning'></i> ";
                    }

                    // Jika rating kurang dari 5, tambahkan bintang kosong
                    for (let i = fullStars + (halfStar ? 1 : 0); i < 10; i++) {
                        stars += "<i class='far fa-star text-warning'></i> ";
                    }

                    return stars;
                  }
              }
            },
            
            { 
                data: 'id_petugas', 
                name: 'id_petugas', 
                orderable: false, 
                searchable: false,
                render: function(data, type, row) {
                return `<button class="btn btn-sm btn-outline-primary show-detail" data-id="${data}">
                             <i class="fas fa-search"></i>
                        </button>`;
                }
            }
        ]
        
    });

    //5. Event Listener untuk tombol Lihat Detail
    $(document).on('click', '.show-detail', function() {
      let petugasId = $(this).data('id'); 

      Swal.fire({
          title: 'Detail Konsultasi',
          html: `<table id="modalTable" class="table table-hover" style="width:100%">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Tanggal</th>
                              <th>Topik</th>
                              <th>Status</th>
                              <th>Rating</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody></tbody>
                </table>`,
          width: '60%',
          didOpen: () => {
              $('#modalTable').DataTable({
                  processing: true,
                  serverSide: true,
                  ajax: '/get-detail-konsultasi/' + petugasId,
                  columns: [
                      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                      {data: 'tanggal_konsultasi',
                        render: function(data) {
                            let date = new Date(data);
                            return date.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
                        }
                      },
                      { data: 'topik_diskusi',
                          render: function(data, type, row) {
                              return data.length > 25 ? data.substr(0, 25) + "..." : data;
                          }
                      },
                      { data: 'status', name: 'status', render: function(data, type, row) {
                          if (data === "Selesai") {
                              return `<span class="badge rounded-pill bg-success">Selesai</span>`;
                          } else if (data === "Diajukan") {
                              return `<span class="badge rounded-pill bg-warning ">Diajukan</span>`;
                          } else if (data === "Dibatalkan") {
                              return `<span class="badge rounded-pill bg-danger">Batal</span>`;
                          }else {
                              return `<span class="badge rounded-pill bg-info ">Disetujui</span>`;
                          }
                      }},
                      { data: 'rating', name: 'rating',
                        render: function(data) {
                          // console.log(data);
                          if(data===null){
                            return ""; 
                          }
                          else{
                            let stars = "";
                            let fullStars = Math.floor(data); // Bintang penuh
                            let halfStar = data % 1 !== 0; // Bintang setengah jika rating desimal

                            // Tambahkan bintang penuh
                            for (let i = 0; i < fullStars; i++) {
                                stars += "<i class='fas fa-star text-warning'></i> ";
                            }

                            // Tambahkan bintang setengah jika ada
                            if (halfStar) {
                                stars += "<i class='fas fa-star-half-alt text-warning'></i> ";
                            }

                            // Jika rating kurang dari 5, tambahkan bintang kosong
                            for (let i = fullStars + (halfStar ? 1 : 0); i < 10; i++) {
                                stars += "<i class='far fa-star text-warning'></i> ";
                            }

                            return stars;
                            }
                        }
                      },
                      {
                      data: 'id',
                      name: 'id', 
                      orderable: false, 
                      searchable: false,
                      render: function(data, type, row) {
                          return `<a href="/konsultasi/${data}" class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener noreferrer">
                                    <i class="fas fa-eye"></i>
                                </a>`;
                          }
                      }
                  ],
                  columnDefs: [
                      { targets: 2, className: "text-start" } // Kolom index ke-3 (judul_konsultasi)
                  ],
                  scrollX: false
              });
          }
      });
    });














    //5. Jalankan Fungsi 1,2,3 saat pertama kali load halaman dengan default tahun saat ini
    let currentYear = new Date().getFullYear();
    fetchMonevData(currentYear);
    fetchMonevDataBySatker(currentYear);

  }); // End of document ready function


  
</script>



@endpush
<!-- Page JS -->
  
