<div class="modal fade" id="createKonsultasiModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">  
        <form action="{{ url('konsultasi')}}"  id='konsultasi-form' enctype="multipart/form-data" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Daftarkan Kagiatan Konsultasi</h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <hr class="my-1" />
            <div class="modal-body">
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-phone">Tanggal Konsultasi</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-phone2" class="input-group-text"
                    ><i class="bx bx-calendar-edit"></i
                    ></span>
                    <input
                        type="date"
                        id="tanggalKonsultasi"
                        name="tanggal_konsultasi"
                        min="{{$minDate}}" 
                        onkeypress="return isNumberKey(event)"
                        {{-- min="{{$minDate}}" --}}
                        class="form-control phone-mask @error('tanggal_konsultasi') is-invalid @enderror"
                        {{--placeholder="1"
                         aria-label="658 799 8941" --}}
                        aria-describedby="basic-icon-default-phone2"
                    />
                </div>
                <div class="invalid-feedback-date-time"></div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Waktu Konsultasi</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-time"></i
                    ></span>
                    <input 
                        id="waktuKonsultasi"
                        class="form-control"
                        name="waktu_konsultasi" 
                        type="time" 
                        min="08:00" 
                        {{-- min="{{$minTime}}"  --}}
                        max= "15:30" 
                        value="08:30"
                        id="html5-time-input" 
                    />
                </div>
                <div class="invalid-feedback-date-time"></div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Petugas Layanan</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-user"></i
                    ></span>
                    <select 
                        {{-- id="defaultSelect"  --}}
                        id="idPetugas"
                        class="form-select @error('id_petugas') is-invalid @enderror"
                        name="id_petugas"
                        value="{{ old('id_petugas') }}"
                        placeholder="Pilih Peran">
                        <option value="">-- Pilih Petugas Pelayanan --</option>
                        @foreach ($petugas as $item)
                            <option value="{{$item->id}}">{{$item->nama_petugas}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="invalid-feedback-petugas"></div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-email">Konsumen</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-group"></i></span>
                    <select 
                    {{-- id="defaultSelect"  --}}
                         id="idPengguna"
                        class="form-select @error('id_pengguna') is-invalid @enderror"
                        name="id_pengguna"
                        value="{{ old('id_pengguna') }}"
                        placeholder="Pilih Peran">
                        <option value="">-- Pilih Konsumen --</option>
                            @foreach ($pengguna as $item)
                                <option value="{{$item->id}}">{{$item->nama_pengguna}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="invalid-feedback-pengguna"></div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Topik Diskusi</label>
                <div class="col-sm-9">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                    ><i class="bx bx-user-pin"></i
                    ></span>
                    <textarea
                        name="topik_diskusi"
                        {{-- id="basic-default-message" --}}
                        id="topikDiskusi"
                        class="form-control"
                        value="{{ old('topik_diskusi') }}"
                        placeholder="Tuliskan topik utama diskusi yang akan dikonsultasikan"
                    ></textarea>
                </div>
                <div class="invalid-feedback-topik-diskusi"></div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Link Meeting</label>
                <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text"
                        ><i class="bx bx-link-alt"></i
                        ></span>
                        <input
                            type="text"
                            class="form-control @error('link_meeting') is-invalid @enderror"
                            id="basic-icon-default-fullname"
                            name="link_meeting"
                            value="{{ old('link_meeting') }}"
                            {{-- placeholder="John Doe"
                            aria-label="John Doe" --}}
                            aria-describedby="basic-icon-default-fullname2"
                        />
                    </div>
                    <div class="invalid-feedback-link-meeting"></div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
                <a href="#" id="btt-submit" data-id="" onclick="simpanKonsultasi()" class="btn btn-primary">Simpan</a>
                
                {{-- <button type="submit" class="btn btn-primary">Simpan</button> --}}
                
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

    function simpanKonsultasi(){
        var form = $("#konsultasi-form");
        var idValidDateTime=true;
        var idValidPetugas=true;
        var idValidPengguna=true;
        var idValidTopikDiskusi=true;

        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        var year = today.getFullYear();
        var todayDate = year + '-' + month + '-' + day;
        

        var tanggalKonsultasi=$('#tanggalKonsultasi').val();
        var waktuKonsultasi=$('#waktuKonsultasi').val();
        // tanggalKonsultasi
        //console.log('masuk change');

        if (tanggalKonsultasi && waktuKonsultasi) {
            var selectedDateTime = new Date(tanggalKonsultasi + 'T' + waktuKonsultasi);
            var now = new Date();
            //var minValidTime = new Date(now.getTime() + 2 * 60 * 60 * 1000); 

            if (selectedDateTime < now) {
                validasiError('date-time', 'Tanggal dan waktu tidak boleh kurang dari sekarang');
                idValidDateTime=false;

                console.log(selectedDateTime +' '+minValidTime);
            }else if (selectedDateTime.getHours() < 8 || 
                       (selectedDateTime.getHours() === 15 && selectedDateTime.getMinutes() > 30) || 
                       selectedDateTime.getHours() > 15) {
                validasiError('date-time', 'Waktu harus antara jam 8 sampai dengan jam 15.30');
                idValidDateTime=false;
            }else {
                validasiValid('date-time');
                idValidDateTime=true;
            }
        }
    
        if($('#idPengguna').val()==''){
            console.log('idPengguna Kosong');
            validasiError('pengguna', 'Pilih pengguna terlebih dahulu');
            idValidPengguna=false;
        }else{
            idValidPengguna=true;
            validasiValid('pengguna');
            //console.log('idPengguna oke');
        }

        if($('#idPetugas').val()==''){
            validasiError('petugas', 'Pilih petugas terlebih dahulu');
            idValidPetugas=false;
            //console.log('idPetugas Kosong');
        }else{
            idValidPengguna=true;
            validasiValid('petugas');
            //console.log('idPetugas oke');
        }

        if($('#topikDiskusi').val()==''){
            validasiError('topik-diskusi', 'Topik diskusi tidak boleh kosong');
            idValidTopikDiskusi=false;
            //console.log('Topik Diskusi Kosong');
        }else{
            idValidTopikDiskusi=true;
            validasiValid('topik-diskusi');
            //console.log('Topik Diskusi oke');
        }

        if(idValidTopikDiskusi && idValidPengguna && idValidPengguna && idValidDateTime){
            console.log('allvalid');
            $('#createKonsultasiModal').modal('toggle');
            Swal.fire({
                title: 'Tunggu Sebentar !',
                html: 'Reservasi sedang dibuat dan mengirimkan notifikasi kepada konsumen ',// add html attribute if you want or remove
                showConfirmButton:false,
                allowOutsideClick: false,
                target: document.getElementsByClassName('layout-wrapper layout-content-navbar'),
                // onBeforeOpen: () => {
                  
                //     //$('#createKonsultasiModal').dialog('close')
                //     Swal.showLoading();
                // },
            });
             form.submit();
             //swal.close();
        }
    }

    function validasiError(className, errorMessage){
        $('.invalid-feedback-'+className).html(errorMessage);
        $('.invalid-feedback-'+className).css('display','block');
        $('.invalid-feedback-'+className).css('color',' #ff3e1d');
       
    }
    function validasiValid(className){
        $('.invalid-feedback-'+className).html('');
        $('.invalid-feedback-'+className).css('display','none');
    }

    
</script>
<script>
    $(document).ready(function(){
        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        var year = today.getFullYear();
        var todayDate = year + '-' + month + '-' + day;

        var valid=true;

        $('#tanggalKonsultasi').val(todayDate);

        var hours = today.getHours() + 1;
        // var hours = today.getHours();
        var minutes = today.getMinutes();

        if (hours >= 24) {
            hours = hours - 24;
        }

        // Format the time to HH:MM
        var formattedHours = String(hours).padStart(2, '0');
        var formattedMinutes = String(minutes).padStart(2, '0');
        var defaultTime = formattedHours + ':' + formattedMinutes;

        $('#waktuKonsultasi').val(defaultTime);

        $('#tanggalKonsultasi').on('submit', function(event){
            var today = new Date();
            var day = String(today.getDate()).padStart(2, '0');
            var month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            var year = today.getFullYear();
            var todayDate = year + '-' + month + '-' + day;
            

            var tanggalKonsultasi=$('#tanggalKonsultasi').val();
            var waktuKonsultasi=$('#waktuKonsultasi').val();
            // tanggalKonsultasi
            //console.log('masuk change');

            if (tanggalKonsultasi && waktuKonsultasi) {
                var selectedDateTime = new Date(tanggalKonsultasi + 'T' + waktuKonsultasi);
                var now = new Date();
                var minValidTime = new Date(now.getTime() + 2 * 60 * 60 * 1000); 

                if (selectedDateTime < minValidTime) {
                    alert('Tanggal dan waktu tidak boleh lebih dari sekarang.');
                } else {
                    //errorMessage.text('');
                    alert('Tanggal dan waktu valid, form siap dikirim.');
                }
            }
        })
    })
</script>
@endpush