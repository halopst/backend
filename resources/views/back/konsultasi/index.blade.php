<?php

namespace App\Http\Controllers\back;

use App\Models\Konsultasi;
use App\Models\Petugas;
use App\Models\Pengguna;
use App\Models\User;
use App\Models\Whatsapp;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKonsultasiRequest;
use Carbon\Carbon;
use App\Notifications\NotificationPST;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KonsultasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$konsultasi=Konsultasi::with('pengguna','petugas')->latest()->get();
        //print_r($konsultasi);
        //
        if(request()->ajax()){
            $konsultasi=[];
            //dd(session('keycloak_user'));
            if(session('keycloak_user')['id_satker']=='3500' && session('keycloak_user')['status']=='Admin'){
                $konsultasi=Konsultasi::with('pengguna','petugas')->latest()->get();
            }
            else if(session('keycloak_user')['status']=='Operator'){
                $konsultasi=Konsultasi::with(['pengguna', 'petugas' => function($query) {
                    $query->where('id_satker', session('keycloak_user')['id_satker']);
                }])->whereHas('petugas', function($query) {
                    $query
                        ->where('id_satker', session('keycloak_user')['id_satker'])
                        ->where('id', session('keycloak_user')['id_petugas']);
                })->latest()->get();
            }
            else{
                $konsultasi=Konsultasi::with(['pengguna', 'petugas' => function($query) {
                    $query->where('id_satker', session('keycloak_user')['id_satker']);
                }])->whereHas('petugas', function($query) {
                    $query->where('id_satker', session('keycloak_user')['id_satker']);
                })->latest()->get();
            }

            //dd($konsultasi);
           
            return DataTables::of($konsultasi)
            ->addIndexColumn()
            ->addColumn('id_pengguna', function($konsultasi){
                return $konsultasi->Pengguna->nama_pengguna;
            })
            ->addColumn('id_petugas', function($konsultasi){
                return $konsultasi->Petugas->nama_petugas;
            })
            ->addColumn('aksi', function($konsultasi){
                $button='
                <div class="btn-group" id="dropdown-icon-demo">
                <button
                  type="button"
                  class="btn-xs btn-secondary dropdown-toggle"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <i class="bx bx-menu"></i> Aksi
                </button>
                <ul class="dropdown-menu">';
                    if($konsultasi->status=='Diajukan'){
                        $button=$button.
                            '<li>
                                <a href="#" onclick="openApproveModal('.$konsultasi->id.', \'approve\')" class="dropdown-item d-flex align-items-center"
                                ><i class="bx bx-message-rounded-check scaleX-n1-rtl"></i>&nbsp Setujui</a
                                >
                            </li>
                            <li>
                                <a href="konsultasi/'.$konsultasi->id.'" class="dropdown-item d-flex align-items-center"
                                ><i class="bx bx-message-rounded-detail scaleX-n1-rtl"></i>&nbsp Detail</a
                                >
                            </li>
                            <li>
                                <a href="#" onclick="openCancelModal('.$konsultasi->id.')" 
                                    class="dropdown-item d-flex align-items-center">
                                    <i class="bx bx-message-x scaleX-n1-rtl"></i>&nbsp 
                                    Batal
                                </a>
                            </li>
                            ';
                    }elseif($konsultasi->status=='Disetujui'){
                        $button=$button.
                        '
                        <li>
                            <a href="'.$konsultasi->link_meeting.'" class="dropdown-item d-flex align-items-center"
                            ><i class="bx bx-video scaleX-n1-rtl"></i>&nbsp Link Pertemuan</a
                            >
                        </li>
                        <li>
                                <a href="konsultasi/'.$konsultasi->id.'"  class="dropdown-item d-flex align-items-center"
                                ><i class="bx bx-message-rounded-detail scaleX-n1-rtl"></i>&nbsp Detail</a
                                >
                        </li>
                        <li>
                            <a href="#" onclick="openApproveModal('.$konsultasi->id.',\'edit\')"  
                                class="dropdown-item d-flex align-items-center">
                                <i class="bx bx-comment-edit scaleX-n1-rtl"></i>&nbsp 
                                Edit
                            </a>
                        </li>
                        <li>
                            <a href="#" onclick="openCancelModal('.$konsultasi->id.')"  
                                class="dropdown-item d-flex align-items-center">
                                <i class="bx bx-message-x scaleX-n1-rtl"></i>&nbsp 
                                Batal
                            </a>
                        </li>
                        <li>
                            <a href="#" onclick="openFinishModal('.$konsultasi->id.')"  
                                class="dropdown-item d-flex align-items-center">
                                <i class="bx bx-comment-dots scaleX-n1-rtl"></i>&nbsp 
                                Selesai
                            </a>
                        </li>
                        ';
                    }elseif($konsultasi->status=='Dibatalkan'){
                        $button=$button.
                        '<li>
                            <a href="konsultasi/'.$konsultasi->id.'" class="dropdown-item d-flex align-items-center">
                                <i class="bx bx-message-rounded-detail scaleX-n1-rtl"></i>
                                &nbsp Detail
                            </a>
                        </li>'
                        ;
                    }else{
                        $button=$button.
                        '
                        <li>
                                <a href="konsultasi/'.$konsultasi->id.'"  class="dropdown-item d-flex align-items-center"
                                ><i class="bx bx-message-rounded-detail scaleX-n1-rtl"></i>&nbsp Detail</a
                                >
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                            ><i class="bx bx-message-edit scaleX-n1-rtl"></i>&nbsp Laporan</a>
                        </li>';
                    }
                    
                    return $button.'</ul></div>';
                })
            ->addColumn('status', function($petugas){
                if ($petugas->status =='Diajukan') {
                    return '<span class="badge bg-primary"> Diajukan </span>';
                }elseif($petugas->status =='Disetujui'){
                    return '<span class="badge bg-warning"> Disetujui </span>';
                
                }elseif($petugas->status =='Dibatalkan'){
                    return '<span class="badge bg-danger"> Dibatalkan</span>';
                }
                else {
                    return '<span class="badge bg-success">Selesai</span>';
                }
            })
            ->rawColumns(['id_pengguna','id_petugas','aksi','status']) 
            ->make();
        }

        $now = Carbon::now();
        $minDate = $now->format('Y-m-d');
        $minTime = $now->copy()->addHours(3)->format('H:i');

        return view('back.konsultasi.index',[
            'petugas'=>Petugas::where('id_satker', session('keycloak_user')['id_satker'])->get(),
            'pengguna'=>Pengguna::get(),
            'minDate'=>$minDate,
            'minTime'=>$minTime,
            //'kabupatens'=>Kabupaten::get()
        ]);
    }

    // <li>
    //     <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
    //     ><i class="bx bx-message-edit scaleX-n1-rtl"></i>&nbsp Ubah</a
    //     >
    // </li>
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKonsultasiRequest $request)
    {
        //
        $data=$request->validated();

        $pengguna = Pengguna::where('id',$data['id_pengguna'])->first();
        $emailPengguna=$pengguna['email_google'];

        $petugas = Petugas::where('id',$data['id_petugas'])->first();
        $emailPetugas=$petugas['email_bps'];
        //dd($emailPetugas);

        $data['waktu_pengajuan']=Carbon::parse($data['tanggal_konsultasi']. ' ' .$data['waktu_konsultasi']);
        $data['notif_flag']=0;
        $data['status']='Diajukan';

        if($data['link_meeting']<>""){
            $data['status']='Disetujui';
            
            $user1= User::where('email',$emailPengguna)->first();
            $user2= User::where('email',$emailPetugas)->first();
            $details1 = [
                    'subject'=>'Pendaftaran dan Persetujuan Reservasi Konsultasi',
                    'penerima'=>$pengguna['nama_pengguna'],
                    'message' => 'Konsultasi dengan topik '.$data['topik_diskusi'].'yang akan dilaksanakan pada '.
                    $data['tanggal_konsultasi'].' jam '. $data['waktu_konsultasi'].' Telah Siap Pada link berikut',
                    'action' => url($data['link_meeting']),
                    'action_caption' => 'Link Meeting'
            ];

            $details2 = [
                'subject'=>'Pendaftaran dan Persetujuan Reservasi Konsultasi',
                'penerima'=>$pengguna['nama_petugas'],
                'message' => 'Konsultasi dengan topik '.$data['topik_diskusi'].'yang akan dilaksanakan pada '.
                $data['tanggal_konsultasi'].' jam '. $data['waktu_konsultasi'].' Telah Siap Pada link berikut',
                'action' => url($data['link_meeting']),
                'action_caption' => 'Link Meeting'
            ];
            $user1->notify(new NotificationPST($details1));
            $user2->notify(new NotificationPST($details2));
        }
        else{
            $data['status']='Diajukan';

            $user1= User::where('email',$emailPengguna)->first();
            $details1 = [
                    'subject'=>'Pendaftaran Konsultasi',
                    'penerima'=>$pengguna['nama_pengguna'],
                    'message' => 'Konsultasi dengan topik '.$data['topik_diskusi'].'yang akan dilaksanakan pada '.
                                $data['tanggal_konsultasi'].' jam '. $data['waktu_konsultasi'].'  Telah Didaftarkan Oleh Petugas Tunggu Link Meeting-nya',
                    'action' => null,
                    'action_caption' => ''
            ];
            $user1->notify(new NotificationPST($details1));
        };

        Konsultasi::create($data);
        return redirect(url('konsultasi'))->with('success','Reservasi Konsultasi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return view('back.konsultasi.show',[
            'konsultasi'=>Konsultasi::find($id)
            //'kabupatens'=>Kabupaten::get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Konsultasi $konsultasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Konsultasi $konsultasi)
    {
        //
    }
    public function updateStatus(Request $request)
    {
        //
        $konsultasi = Konsultasi::find($request->id);
        $message="";
        //dd($konsultasi);
        $pengguna = Pengguna::where('id',$konsultasi['id_pengguna'])->first();
       
        $emailPengguna=$pengguna['email_google'];

        //Jika request status Disetujui maka sekaligus update 
        if($request->status=="Disetujui"){
            
            $konsultasi->link_meeting = $request->link;
            $konsultasi->id_petugas = $request->id_petugas;
            $konsultasi->waktu_konsultasi = $request->waktu_konsultasi;
            $konsultasi->tanggal_konsultasi = $request->tanggal_konsultasi;

            $message='Pengajuan Konsultasi Telah Disetujui, Konsumen Telah diiformasikan Hal ini melalui email !!';
           
            //Notifikasi kepada user
            $user1= User::where('email',$emailPengguna)->first();
            $details1 = [
                    'subject'=>'Pendaftaran Konsultasi',
                    'penerima'=>$pengguna['nama_pengguna'],
                    'message' => 'Konsultasi dengan topik '.$konsultasi['topik_diskusi'].
                        ' yang dilaksanakan pada '.$konsultasi['tanggal_konsultasi'].' jam '.$konsultasi['waktu_konsultasi'].
                        ' telah Disetujui Oleh Petugas Pada link berikut',
                    'action' => url($request->link),
                    'action_caption' => 'Link Meeting'
            ];
            $user1->notify(new NotificationPST($details1));

        }else{
            $message='Pengajuan Konsultasi Dibatalkan, Konsumen Telah diiformasikan Hal ini melalui email !!';

            $user1= User::where('email',$emailPengguna)->first();
            $details1 = [
                    'subject'=>'Pendaftaran Konsultasi',
                    'penerima'=>$pengguna['nama_pengguna'],
                    'message' => 'Konsultasi dengan topik '.$konsultasi['topik_diskusi'].' Telah Dibatalkan dengan Alasan '.$request->alasan,
                    'action' => null,
                    'action_caption' => ''
            ];
            $user1->notify(new NotificationPST($details1));
            //$konsultasi->alasan_pembatalan = $request->status;
        }
        $konsultasi->status = $request->status;
        
        $konsultasi->save();

        return response()->json([
            'message'=>$message
        ]);
    }

    public function setujuiKonsultasi(Request $request)
    {
        //
        $konsultasi = Konsultasi::find($request->id);
        $message="";
        //dd($konsultasi);
        $pengguna = Pengguna::where('id',$konsultasi['id_pengguna'])->first();
        $emailPengguna=$pengguna['email_google'];

        $petugas = Petugas::where('id',$konsultasi['id_petugas'])->first();
        $emailPetugas=$petugas['email_bps'];

        //Jika request status Disetujui maka sekaligus update 
        $konsultasi->link_meeting = $request->link;
        $konsultasi->id_petugas = $request->id_petugas;
        $konsultasi->waktu_konsultasi = $request->waktu_konsultasi;
        $konsultasi->tanggal_konsultasi = $request->tanggal_konsultasi;
        $konsultasi->status = 'Disetujui';
        $konsultasi->waktu_persetujuan=Carbon::now();

        //Notifikasi kepada user
        $user1= User::where('email',$emailPengguna)->first();
        $details1 = [
                'subject'=>'Persetujuan Konsultasi',
                'penerima'=>$pengguna['nama_pengguna'],
                'message' => 'Permintaan Konsultasi Anda <b>Telah Disetujui</b>, Detail Konsultasi sebagai berikut : <br>'. 
                        '&emsp;Topik Diskusi : '.$konsultasi['topik_diskusi'].'<br>'. 
                        '&emsp;Tanggal &emsp;&nbsp;: '. $request->tanggal_konsultasi.'<br>'.
                        '&emsp;Waktu   &emsp;&emsp;: '. $request->waktu_konsultasi.'<br>'.
                        '&emsp;Link Meeting : '. $request->link.'<br>'.
                        '<b>Petugas akan membatalkan sesi konsultasi jika anda terlambat</b> maksimal 15 menit setelah meeting dibuka',
                        
                'action' => url($request->link),
                'action_caption' => 'Link Meeting'
        ];
        $user1->notify(new NotificationPST($details1));

        //Notif by WA to User
        if($pengguna['nmr_telp']!=null){
            $this->createWANotif($pengguna['nmr_telp'],
            'Hallo *'.$pengguna['nama_pengguna'].'*'."\r\n".
            'Permintaan konsultasi anda :'."\r\n".
            ' Topik Diskusi : '.$konsultasi['topik_diskusi']."\r\n".
            ' Tanggal Konsultasi : '.$konsultasi['tanggal_konsultasi']."\r\n".
            ' Waktu : '.$konsultasi['waktu_konsultasi']."\r\n".
            'Telah Disetujui Oleh Petugas Pada link '.$request->link."\r\n".
            '*Petugas akan membatalkan sesi konsultasi jika anda terlambat* maksimal 15 menit setelah meeting dibuka');
        }
        
         if($petugas['no_hp']!=null){
            $this->createWANotif($petugas['no_hp'],
                'Hallo *'.$petugas['nama_petugas'].'*'."\r\n".
                'Permintaan konsultasi telah anda setujui, detail konsultasi :'."\r\n".
                ' Topik Diskusi : '.$konsultasi['topik_diskusi']."\r\n".
                ' Tanggal Konsultasi : '.$konsultasi['tanggal_konsultasi']."\r\n".
                ' Waktu  : '.$konsultasi['waktu_konsultasi']."\r\n".
                ' Link Meeting : '.$request->link."\r\n".
                'Jangan lupa untuk memulai meeting sesuai jadwal..');
        }

        
        if($emailPetugas!=session('keycloak_user')['email']){
            $user2= User::where('email',$emailPetugas)->first();
            $details2 = [
                'subject'=>'Persetujuan Konsultasi',
                'penerima'=>$petugas['nama_petugas'],
                'message' => 'Konsultasi yang anda tangani <b>Telah Disetujui Admin</b>, Detail Konsultasi sebagai berikut :<br>'. 
                    '&emsp;Topik Diskusi : '.$konsultasi['topik_diskusi'].'<br>'. 
                    '&emsp;Tanggal &emsp;&nbsp;: '. $request->tanggal_konsultasi.'<br>'.
                    '&emsp;Waktu   &emsp;&emsp;: '. $request->waktu_konsultasi.'<br>'.
                    '&emsp;Link Meeting : '. $request->link.'<br>',
                'action_caption' => 'Link Meeting'
            ];
            $user2->notify(new NotificationPST($details2));

            //Notif by WA to User
            if($petugas['no_hp']!=null){
                $this->createWANotif($petugas['no_hp'],
                    'Hallo *'.$petugas['nama_petugas'].'*'."\r\n".
                    'Konsultasi yang anda tangani *telah disetujui oleh admin*'."\r\n".
                    ' Topik Diskusi : '.$konsultasi['topik_diskusi']."\r\n".
                    ' Tanggal Konsultasi : '.$konsultasi['tanggal_konsultasi']."\r\n".
                    ' Waktu  : '.$konsultasi['waktu_konsultasi']."\r\n".
                    ' Link Meeting : '.$request->link."\r\n".
                    'Jangan lupa untuk membuka meeting sesuai jadwal tersebut..');

            }
        }

        $konsultasi->save();

        return response()->json([
            'message'=>'Pengajuan Konsultasi Telah Disetujui, Konsumen Telah diiformasikan Hal ini melalui email !!'
        ]);
    }

    public function batalKonsultasi(Request $request){
        $konsultasi = Konsultasi::find($request->id);
        $message="";
        //dd($konsultasi);
        $pengguna = Pengguna::where('id',$konsultasi['id_pengguna'])->first();
       
        $emailPengguna=$pengguna['email_google'];

        $user1= User::where('email',$emailPengguna)->first();
        $details1 = [
                'subject'=>'Pembatalan Konsultasi',
                'penerima'=>$pengguna['nama_pengguna'],
                'message' => 'Reservasi Konsultasi Anda <b>Dibatalkan</b> oleh petugas, detail sebagai berikut :'.
                    '&emsp;Topik Diskusi : '.$konsultasi['topik_diskusi'].'<br>'. 
                    '&emsp;Tanggal &emsp;&nbsp;: '. $konsultasi['tanggal_konsultasi'].'<br>'.
                    '&emsp;Waktu   &emsp;&emsp;: '. $konsultasi['waktu_konsultasi'].'<br>',
                    '&emsp;Alasan Pembatalan : '. $request->alasan.'<br>',
                'action' => null,
                'action_caption' => ''
        ];
        $user1->notify(new NotificationPST($details1));
        
        $konsultasi->status = 'Dibatalkan';
        $konsultasi->id_petugas_batal=session('keycloak_user')['id_petugas'];
        $konsultasi->alasan_pembatalan=$request->alasan;
        $konsultasi->waktu_pembatalan=Carbon::now();
        $konsultasi->save();

        //notif WA
        if($pengguna['nmr_telp']!=null){
            $this->createWANotif($pengguna['nmr_telp'],
                'Hallo *'.$pengguna['nama_pengguna'].'*'."\r\n".
                'Permintaan Konsultasi Anda *Telah Dibatalkan Oleh Petugas*  :'."\r\n".
                ' Topik Diskusi : '.$konsultasi['topik_diskusi']."\r\n".
                ' Tanggal Konsultasi : '.$konsultasi['tanggal_konsultasi']."\r\n".
                ' Waktu  : '.$konsultasi['waktu_konsultasi']."\r\n".
                ' Alasan Pembatalan : '.$request->alasan);
    
            return response()->json([
                'message'=>$message
            ]);
        }

    }

    public function selesaiKonsultasi(Request $request)
    {
         //
         $konsultasi = Konsultasi::find($request->id);
         $konsultasi->status = "Selesai";
         $konsultasi->link_bukti = $request->linkDokumentasi;
         $message="";
         //dd($konsultasi);
         $pengguna = Pengguna::where('id',$konsultasi['id_pengguna'])->first();
        
         $emailPengguna=$pengguna['email_google'];

         $user1= User::where('email',$emailPengguna)->first();
         $details1 = [
                 'subject'=>'Selesai Konsultasi & Pemberian Feedback',
                 'penerima'=>$pengguna['nama_pengguna'],
                 'message' => '<p>Konsultasi telah selesai mohon untuk memberikan <b>Feedback dan Penilaian</b> kepada petugas, pada detail konsultasi berikut : </p>'. 
                        '&emsp;Topik Diskusi : '.$konsultasi['topik_diskusi'].'<br>'. 
                        '&emsp;Tanggal &emsp;&nbsp;: '. $konsultasi['tanggal_konsultasi'].'<br>'.
                        '&emsp;Waktu   &emsp;&emsp;: '. $konsultasi['waktu_konsultasi'].'<br>'.
                    'Pemberian <i>feedback</i> pada <b>Menu Riwayat Konsultasi</b>',
                 'action' => null,
                 'action_caption' => ''
         ];
         $user1->notify(new NotificationPST($details1));
        
         if($pengguna['nmr_telp']!=null){
             $this->createWANotif($pengguna['nmr_telp'],
                'Hallo *'.$pengguna['nama_pengguna'].'* '."\r\n".
                'Konsultasi Berikut  Telah Selesai :'."\r\n".
                ' Topik Diskusi : '.$konsultasi['topik_diskusi']."\r\n".
                ' Tanggal Konsultasi : '.$konsultasi['tanggal_konsultasi']."\r\n".
                ' Waktu  : '.$konsultasi['waktu_konsultasi']."\r\n". 
                'Mohon untuk *Memberikan Feedback* pada menu riwayat konsultasi');
         }
         
         $konsultasi->save();

        return response()->json([
            'message'=>'Status Konsultasi Telah Selesai, Konsumen Telah diiformasikan Untuk Mengirimkan Feedback.'
        ]);
 
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Konsultasi $konsultasi)
    {
        //
    }

    public function getKonsultasiById(Request $request){
        $konsultasi=Konsultasi::where('id',$request->id)->with('pengguna','petugas')->first();
        return response()->json([
            'konsultasi'=>$konsultasi
        ]);
    }

    
    public function createWANotif($wa_number,$message){
        Whatsapp::create([
            'wa_number'=>$wa_number,
            'message'=>$message,
            'status'=>0
        ]);
    }
}