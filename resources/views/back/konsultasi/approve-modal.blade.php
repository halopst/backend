<div class="modal fade" id="approveKonsultasiModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">  
        <form action="{{ url('konsultasi')}}"  id="konsultasi-form-approve" enctype="multipart/form-data" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title mb-0" id="backDropModalTitleApprove">Setujui Permintaan Konsultasi</h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <hr class="my-1 mt-0" />
            <div class="modal-body pt-2">
                <div class="alert alert-primary" role="alert">Untuk Melakukan Persetujuan Konsultasi Perhatikan beberapa hal  
                    <ul class="mb-0 pb-0">
                        <li> <b>Tanggal</b> dan <b>Waktu</b> Konsultasi</li>
                        <li> <b>Petugas</b> yang akan melayani</li>
                    </ul>
                    <p class="mb-0">Ubah petugas layanan, waktu dan tanggal sesuai kesediaan lalu <b>isikan link meeting.</b></p>
                </div>
                <div class="border border-2 rounded mb-2 p-1">
                    <small class="text-light fw-semibold">Informasi Konsumen Layanan</small>
                    <div class="row mb-0 pb-0">
                        <label class="col-sm-4 col-form-label" for="basic-icon-default-phone">Nama</label>
                        <div class="col-sm-8" id="label-nama-konsumen">
                            La Ode Ahmad Arafat
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label " for="basic-icon-default-phone">Email</label>
                        <div class="col-sm-8" id="label-email-konsumen">
                            odearafat@gmail.com
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label pt-1" for="basic-icon-default-phone">Pekerjaan</label>
                        <div class="col-sm-8" id="label-pekerjaan-konsumen">
                            Mahasiswa
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label pt-1" for="basic-icon-default-phone">Topik Diskusi</label>
                        <div class="col-sm-8" id="label-topik-diskusi">
                            
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-4 col-form-label" for="basic-icon-default-phone">Tanggal Konsultasi</label>
                    <div class="col-sm-8">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-phone2" class="input-group-text"
                        ><i class="bx bx-calendar-edit"></i
                        ></span>
                        <input
                            type="date"
                            id="tanggalKonsultasiApprove"
                            name="tanggal_konsultasi"
                            min="{{$minDate}}" 
                            onkeypress="return isNumberKey(event)"
                            value="2026-06-02"
                            {{-- min="{{$minDate}}" --}}
                            class="form-control phone-mask @error('tanggal_konsultasi') is-invalid @enderror"
                            {{--placeholder="1"
                             aria-label="658 799 8941" --}}
                            aria-describedby="basic-icon-default-phone2"
                        />
                    </div>
                    <div class="invalid-feedback-date-time-approve"></div>
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-4 col-form-label" for="basic-icon-default-fullname">Waktu Konsultasi</label>
                    <div class="col-sm-8">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text"
                        ><i class="bx bx-time"></i
                        ></span>
                        <input 
                            id="waktuKonsultasiApprove"
                            class="form-control"
                            name="waktu_konsultasi" 
                            type="time" 
                            min="08:00" 
                            value="08:00"
                            {{-- min="{{$minTime}}"  --}}
                            max= "15:30" 
                            {{-- value="08:30" --}}
                            id="html5-time-input" 
                        />
                    </div>
                    <div class="invalid-feedback-date-time-approve"></div>
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-4 col-form-label" for="basic-icon-default-fullname">Petugas Layanan</label>
                    <div class="col-sm-8">
                    
                        <div class="input-group input-group-merge" id="petugasContainer">
                            <span id="basic-icon-default-fullname2" class="input-group-text"
                            ><i class="bx bx-user"></i
                            ></span>
                            <select 
                                id="idPetugasApprove"
                                class="form-select @error('id_petugas') is-invalid @enderror"
                                name="id_petugas"
                                value="{{ old('id_petugas') }}"
                                placeholder="Pilih Peran">
                                <option value="">-- Pilih Petugas Pelayanan --</option>
                            </select>
                        </div>
                   
                       <div class="mt-1" id="label-petugas" ></div>
                  
                    <div class="invalid-feedback-petugas-approve"></div>
                    </div>
                </div>
                <div class="row mb-1">
                    <label class="col-sm-4 col-form-label" for="basic-icon-default-fullname">Link Meeting</label>
                    <div class="col-sm-8">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-fullname2" class="input-group-text"
                            ><i class="bx bx-link-alt"></i></span>
                            <input
                                type="text"
                                class="form-control @error('link_meeting') is-invalid @enderror"
                                id="link-meeting-approve"
                                name="link_meeting"
                                {{-- placeholder="John Doe"
                                aria-label="John Doe" --}}
                                aria-describedby="basic-icon-default-fullname2"
                            />
                        </div>
                        <div class="invalid-feedback-link-meeting-approve"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" id="btt-submit-setuju" data-id="" onclick="setujuiKonsultasi(this)" class="btn btn-primary">Ya, Setujui</a>
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

    function setujuiKonsultasi(e){
        // console.log('masuk bos');
        var form = $("#konsultasi-form-approve");
        let id=e.getAttribute('data-id');
        let linkMeetApprove=$('#link-meeting-approve').val();
        let idPetugasApprove=$('#idPetugasApprove').val();
        let waktuKonsultasiApprove=$('#waktuKonsultasiApprove').val();
        let tanggalKonsultasiApprove=$('#tanggalKonsultasiApprove').val();

        var isValidLinkMeetApprove=true;
        var isValidPetugasApprove=true;
        var isValidDateTimeApprove=true;

        console.log(linkMeetApprove);
        console.log(isUrlValidApprove(linkMeetApprove));
        if(isUrlValidApprove(linkMeetApprove)){
            isValidLinkMeetApprove=true;
            validasiValid('link-meeting-approve');
        }else{
            isValidLinkMeetApprove=false;
            validasiError('link-meeting-approve', 'Link tidak valid, mohon periksa lagi');
        }

        if(idPetugasApprove==""){
            isValidPetugasApprove=false;
            validasiError('petugas-approve', 'Pilih Petugas Pelayanan');
        }else{
            isValidPetugasApprove=true;
            validasiValid('petugas-approve');
        }


        if (tanggalKonsultasiApprove && waktuKonsultasiApprove) {
            var selectedDateTime = new Date(tanggalKonsultasiApprove + 'T' + waktuKonsultasiApprove);
            var now = new Date();
            //var minValidTime = new Date(now.getTime() + 2 * 60 * 60 * 1000); 

            if (selectedDateTime < now) {
                validasiError('date-time-approve', 'Tanggal dan waktu tidak boleh kurang dari sekarang');
                isValidDateTimeApprove=false;
            }else if (selectedDateTime.getHours() < 8 || 
                       (selectedDateTime.getHours() === 15 && selectedDateTime.getMinutes() > 30) || 
                       selectedDateTime.getHours() > 15) {
                validasiError('date-time-approve', 'Waktu harus antara jam 8 sampai dengan jam 15.30');
                isValidDateTimeApprove=false;
            }else {
                validasiValid('date-time-approve');
                isValidDateTimeApprove=true;
            }
        }


        if(isValidLinkMeetApprove && isValidPetugasApprove && isValidDateTimeApprove){
            $('#approveKonsultasiModal').modal('toggle');
            Swal.fire({
                title: 'Tunggu Sebentar !',
                html: 'Sedang mengirimkan link meeting dan notifikasi kepada konsumen ',// add html attribute if you want or remove
                showConfirmButton:false,
                allowOutsideClick: false,
                target: document.getElementsByClassName('layout-wrapper layout-content-navbar'),
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url:'{{ config('app.url') }}setujui-konsultasi',
                data:{  id:id, 
                        status:'Disetujui', 
                        link:linkMeetApprove,
                        id_petugas:idPetugasApprove,
                        waktu_konsultasi:waktuKonsultasiApprove,
                        tanggal_konsultasi:tanggalKonsultasiApprove
                    },
                dataType:"json",
                success: function(response){
                //console.log('sudah dibatalkan');
                Swal.fire({
                    title: "Sukses",
                    text: response.message,
                    icon: "success",
                    showConfirmButton:false,
                    timer : 2000
                }).then((result)=>{
                    window.location.href='{{ config('app.url') }}konsultasi';
                })
                }
            });
            

        }else{
            console.log('masih ada yanng invalid');
        }       
    }

    function isUrlValidApprove(url) {
        return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
    }

</script>
<script>
    
</script>
@endpush