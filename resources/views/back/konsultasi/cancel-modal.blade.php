<div class="modal fade" id="cancelKonsultasiModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">  
        <form action="{{ url('konsultasi')}}"  enctype="multipart/form-data" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Batalkan Permintaan Konsultasi</h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <hr class="my-1" />
            <div class="modal-body">
                <div class="alert alert-primary" role="alert">
                    Pilih Alasan Pembatalan Konsultasi. Alasan Tersebut akan dikirimkan kepada pengguna data melalui email
                </div>
                    <div class="mb-1">
                            <div class="input-group input-group-mege">
                                <span id="basic-icon-default-message2" class="input-group-text"><i class="bx bx-comment"></i></span>
                                <select id="alasan-pembatalan-cancel" class="form-select">
                                    <option value="" selected disabled>Pilih alasan pembatalan...</option>
                                    <option value="duplikat permohonan konsultasi">Duplikat permohonan konsultasi</option>
                                    <option value="pengguna layanan tidak hadir pada jadwal konsultasi">Pengguna layanan tidak hadir pada jadwal konsultasi</option>
                                </select>
                            </div>
                            <div class="invalid-feedback"></div>
                    </div>

                {{-- <div class="row">
                    <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Alasan Pembatalan</label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-fullname2" class="input-group-text"
                            ><i class="bx bx-link-alt"></i
                            ></span>
                            <input
                                type="text"
                                class="form-control @error('link_meeting') is-invalid @enderror"
                                id="link-meeting"
                                name="link_meeting"
                                 placeholder="John Doe"
                                aria-label="John Doe" 
                                aria-describedby="basic-icon-default-fullname2"
                            />
                        </div>
                       
                    </div>
                </div> --}}
            </div>
            <div class="modal-footer">
                <a href="#" id="btt-submit-cancel" data-id="" onclick="batalKonsultasi(this)" class="btn btn-primary">Batalkan Konsultasi</a>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </form>
    </div>
  </div>
@push('js')
<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
    }

    function batalKonsultasi(e){
        //console.log(e.getAttribute('data-id'));
        let id=e.getAttribute('data-id');
        let scheduleDate=e.getAttribute('data-schedule-date');
        let scheduleTime=e.getAttribute('data-schedule-time');
        let alasanPembatalan=$('#alasan-pembatalan-cancel').val();
        // console.log(alasanPembatalan);
        if(alasanPembatalan==""){
            console.log('Kosong alasan pembatalannya');
            $('.invalid-feedback').html('Alasan pembatalan harus diisi');
            $('.invalid-feedback').css('display','block');
            $('#alasan-pembatalan-cancel').attr('class','form-control is-invalid');
        }else{
            // Check if current time is after schedule time + 15 minutes
            // Only applies for "pengguna layanan tidak hadir pada jadwal konsultasi" reason
            if(alasanPembatalan === "pengguna layanan tidak hadir pada jadwal konsultasi" && scheduleDate && scheduleTime){
                let scheduleDateTimeString = scheduleDate + ' ' + scheduleTime;
                let scheduleDateTime = new Date(scheduleDateTimeString);
                let cancelDeadline = new Date(scheduleDateTime.getTime() + 15 * 60000); // Add 15 minutes
                let now = new Date();
                
                if(now < cancelDeadline){
                    let formattedSchedule = scheduleDateTime.toLocaleString('id-ID', { 
                        year: 'numeric', 
                        month: '2-digit', 
                        day: '2-digit', 
                        hour: '2-digit', 
                        minute: '2-digit' 
                    });
                    let formattedDeadline = cancelDeadline.toLocaleString('id-ID', { 
                        year: 'numeric', 
                        month: '2-digit', 
                        day: '2-digit', 
                        hour: '2-digit', 
                        minute: '2-digit' 
                    });
                    
                    $('#cancelKonsultasiModal').modal('toggle');
                    
                    Swal.fire({
                        title: "Tidak Dapat Dibatalkan",
                        html: "Konsultasi dijadwalkan pada <strong>" + formattedSchedule + "</strong><br/>" +
                              "Pembatalan hanya dapat dilakukan setelah <strong>" + formattedDeadline + "</strong>",
                        icon: "warning",
                        showConfirmButton: true
                    });
                    return;
                }
            }
            
            $('#cancelKonsultasiModal').modal('toggle');
            console.log('jalankan batalkan');
            Swal.fire({
                title: 'Tunggu Sebentar !',
                html: 'Sedang mengirimkan notifikasi pembatalan kepada konsumen ',// add html attribute if you want or remove
                showConfirmButton:false,
                allowOutsideClick: false,
                target: document.getElementsByClassName('layout-wrapper layout-content-navbar'),
            });
            $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type:'POST',
              url:'{{ config('app.url') }}batal-konsultasi',
              data:{
                id:id, 
                status:'Dibatalkan',
                alasan:alasanPembatalan},
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

    }

    function isUrlValid(url) {
        return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
    }

</script>
<script>
    $(document).ready(function(){
        
    })
</script>
@endpush