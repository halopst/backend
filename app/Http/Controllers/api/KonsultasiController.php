<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;

//import model 
use App\Models\Konsultasi;
use App\Models\Pengguna;
use App\Models\Petugas;
use App\Models\User;
use App\Models\Whatsapp;

//import facade Validator
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

//import notification
use App\Notifications\NotificationPST;
use Illuminate\Support\Str;

//import resource KonsultasiResource
use App\Http\Resources\KonsultasiResource;

use Carbon\Carbon;

class KonsultasiController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //get all konsultasi
         $konsultasi=Konsultasi::with('pengguna','petugas')->latest()->get();
            
         //return collection of konsultasi as a resource
         return new KonsultasiResource(true, 'List Data Konsultasi', $konsultasi);
    
    }

    public function getKonsultasiByPengguna($idPengguna){
        $konsultasi=Konsultasi::with('pengguna:id,nama_pengguna','petugas:id,nama_petugas')->where('id_pengguna',$idPengguna)->get();
          
        return new KonsultasiResource(true, 'List Data Konsultasi By Pengguna', $konsultasi);
    }

    public function getReservasiByPengguna($idPengguna){
        $konsultasi=Konsultasi::with('pengguna:id,nama_pengguna','petugas:id,nama_petugas')
                        ->where('id_pengguna',$idPengguna)
                        ->whereIn('status',['Diajukan', 'Disetujui'])
                        ->get();
        // dd($konsultasi);
        return new KonsultasiResource(true, 'List Reservasi By Pengguna', $konsultasi);
    }

    public function getHistoriByPengguna($idPengguna){
        $konsultasi=Konsultasi::with('pengguna:id,nama_pengguna','petugas:id,nama_petugas')
                        ->where('id_pengguna',$idPengguna)
                        ->whereIn('status',['Dibatalkan', 'Selesai'])
                        ->get();
          
        return new KonsultasiResource(true, 'List Data Histori Konsultasi By Pengguna', $konsultasi);
    }

    public function show($id)
    {
        $email = Auth::user()->email;
        //find konsultasi by ID
        $konsultasi = Konsultasi::with('pengguna:id,nama_pengguna,email_google', 'petugas:id,nama_petugas')
            ->where('uuid', $id)
            ->first();
        
        if($email==$konsultasi->pengguna->email_google){
            return new KonsultasiResource(true, 'Detail Data Konsultasi!', $konsultasi);
        }else{
            return response()->json(404);
        }
        //return single konsultasi as a resource
        
    }


    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
      //return response()->json('tambahkan');
         $validator = Validator::make($request->all(), [
            'tanggal_konsultasi'=>'required',
            'waktu_konsultasi'=>'required',
            'topik_diskusi'=>'required',
            'id_pengguna'=>'required',
            'id_petugas'=>'required'
        ]);

        // check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //handler daftar konsultasi
        $pengguna = Pengguna::where('id',$request->id_pengguna)->first();
        $emailPengguna=$pengguna['email_google'];

        $petugas = Petugas::where('id',$request->id_petugas)->first();
        $emailPetugas=$petugas['email_bps'];
                
        $konsultasi = Konsultasi::create([
            'tanggal_konsultasi'=>$request->tanggal_konsultasi,
            'waktu_konsultasi'=>$request->waktu_konsultasi,
            'topik_diskusi'=>$request->topik_diskusi,
            'id_pengguna'=>$request->id_pengguna,
            'id_petugas'=>$request->id_petugas,
            'status'=>'Diajukan',
            'waktu_diajukan'=>Carbon::parse($request->tanggal_konsultasi. ' ' .$request->waktu_konsultasi),
            'notif_flag'=>0,
            'id_satker'=>$petugas->id_satker
        ]);

        //handler daftar konsultasi
        $pengguna = Pengguna::where('id',$request->id_pengguna)->first();
        $emailPengguna=$pengguna['email_google'];

        $petugas = Petugas::where('id',$request->id_petugas)->first();
        $emailPetugas=$petugas['email_bps'];

        $user1= User::where('email',$emailPengguna)->first();
        $details1 = [
                'subject'=>'Reservasi Konsultasi',
                'penerima'=>$pengguna['nama_pengguna'],
                'message' => '<p>Reservasi Konsultasi Anda telah didaftarkan dengan detail :</p>'.
                '&emsp;Topik Diskusi : '.$request->topik_diskusi.'<br>'. 
                    '&emsp;Tanggal &emsp;&nbsp;: '. $request->tanggal_konsultasi.'<br>'.
                    '&emsp;Waktu   &emsp;&emsp;: '. $request->waktu_konsultasi.' <br>  
                    <p><b>Mohon menunggu link meeting-nya pada email dan menu reservasi pada akun anda</b></p>',
                'action' => null,
                'action_caption' => ''
            ];
        $user1->notify(new NotificationPST($details1));

        $user2= User::where('email',$emailPetugas)->first();
        $details2 = [
                'subject'=>'Reservasi Konsultasi',
                'penerima'=>$petugas['nama_petugas'],
                'message' => '<p>Ada Permintaan Konsultasi Kepada Anda Pada Aplikasi HaloPST, sebagai berikut : '.'</p>'.
                    '&emsp;Nama Konsumen : '.$pengguna['nama_pengguna'].'<br>'.
                    '&emsp;Nomor Konsumen : '.$pengguna['nmr_telp'].'<br>'.
                    '&emsp;Topik Diskusi : '.$request->topik_diskusi.'<br>'. 
                    '&emsp;Tanggal &emsp;&nbsp;: '. $request->tanggal_konsultasi.'<br>'.
                    '<p>&emsp;Waktu   &emsp;&emsp;: '. $request->waktu_konsultasi.' </p>
                    <p><b>Mohon segera Dilakukan Persetujuan</b></p>',
                'action' => url('konsultasi'),
                'action_caption' => 'Proses Konsultasi'
        ];
        
        $user2->notify(new NotificationPST($details2));

         //notif WA untuk pengguna
        if($pengguna['nmr_telp']!=null){
            $this->createWANotif($pengguna['nmr_telp'],
            'Hallo *'.$pengguna['nama_pengguna'].'*'."\r\n".
            'Permintaan konsultasi anda *Telah terdaftar* :'."\r\n".
            ' Topik Diskusi : '.$request->topik_diskusi."\r\n".
            ' Tanggal Konsultasi : '.$request->tanggal_konsultasi."\r\n".
            ' Waktu : '.$request->waktu_konsultasi."\r\n".
            'Tunggu link meeting-nya pada email dan menu reservasi pada akun anda');
        }
        

        //notif WA untuk petugas
        $this->createWANotif($petugas['no_hp'],
                'Hallo *'.$petugas['nama_petugas'].'*'."\r\n".
                'Ada Permintaan Konsultasi : '."\r\n".
                ' Nama Konsumen : '.$pengguna['nama_pengguna']."\r\n".
                ' Nomor Konsumen : '.$pengguna['nmr_telp']."\r\n".
                ' Topik diskusi : '.$request->topik_diskusi."\r\n".
                ' Tanggal : '.$request->tanggal_konsultasi."\r\n".
                ' Waktu :  '. $request->waktu_konsultasi."\r\n".
                'Mohon Untuk Segera Diproses dan Disetujui');

        return new KonsultasiResource(true, 'Reservasi Konsultasi Berhasil Ditambahkan..!', $konsultasi);
    }

    public function createWANotif($wa_number,$message){
        Whatsapp::create([
            'wa_number'=>$wa_number,
            'message'=>$message,
            'status'=>0
        ]);
    }

    public function batalKonsultasi(Request $request,$idKonsultasi){
        $konsultasi = Konsultasi::with('pengguna:id,nama_pengguna,email_google','petugas:id,nama_petugas,email_bps,no_hp')
                    ->where('uuid',$idKonsultasi)
                    ->first();

        $email = Auth::user()->email;
        //find konsultasi by ID
        if($email!=$konsultasi->pengguna->email_google){
            return response()->json(404);
        }
        //return response()->json($konsultasi);

        // define validation rules
        $validator = Validator::make($request->all(), [
            'alasan_pembatalan'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $user1= User::where('email', $konsultasi->petugas->email_bps)->first();
        $details1 = [
            'subject'=>'Pembatalan Konsultasi',
            'penerima'=>$konsultasi->petugas->nama_petugas,
            'message' => 'Konsultasi <b>Telah Dibatalkan</b> oleh pengguna Data, detail konsultasi sebagai berikut : <br>'.
                '&emsp;Topik Diskusi : '.$konsultasi->topik_diskusi.'<br>'. 
                '&emsp;Tanggal &emsp;&nbsp;: '. $konsultasi->tanggal_konsultasi.'<br>'.
                '&emsp;Waktu   &emsp;&emsp;: '. $konsultasi->waktu_konsultasi.'<br>'.
                '&emsp;Alasan Pembatalan : '.$request->alasan_pembatalan.' <br>' ,
            'action' => null,
            'action_caption' => ''
        ];
        $user1->notify(new NotificationPST($details1));
        //dd($user1);

        $konsultasi->update([
            'alasan_pembatalan' =>$request->alasan_pembatalan,
            'status'     => 'Dibatalkan',
            'waktu_pembatalan'=>Carbon::now()
        ]);

        $this->createWANotif($konsultasi->petugas->no_hp,
            'Hallo *'.$konsultasi->petugas->nama_petugas.'*'."\r\n".
            'Konsultasi dengan topik '.$konsultasi->topik_diskusi.' yang akan dilaksanakan pada '.
            $konsultasi->tanggal_konsultasi.' jam '. $konsultasi->waktu_konsultasi.' telah dibatalkan oleh pengguna dengan alasan '.
            $request->alasan_pembatalan);

        return new KonsultasiResource(true, 'Konsultasi Berhasil Dibatalkan', $konsultasi);
    }


    public function feedbackKonsultasi(Request $request,$idKonsultasi){
        $konsultasi = Konsultasi::with('pengguna:id,nama_pengguna,email_google','petugas:id,nama_petugas,email_bps,no_hp')->find($idKonsultasi);
        
        // define validation rules
        $validator = Validator::make($request->all(), [
            'rating'     => 'required|numeric|min:1|max:10',
            'kritik_saran'     => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $konsultasi->update([
            'rating'        => $request->rating,
            'kritik_saran'  => $request->kritik_saran,
            'status'        => 'Selesai'
        ]);

        $user1= User::where('email', $konsultasi->petugas->email_bps)->first();
        $details1 = [
            'subject'=>'Feedback Konsultasi dari Pengguna',
            'penerima'=>$konsultasi->petugas->nama_petugas,
            'message' => 'Anda mendapatkan <i>feedback</i> dari konsumen pada sesi konsultasi berikut :<br>'.
                '&emsp;Topik Diskusi : '.$konsultasi->topik_diskusi.'<br>'. 
                '&emsp;Tanggal &emsp;&nbsp;: '. $konsultasi->tanggal_konsultasi.'<br>'.
                '&emsp;Waktu   &emsp;&emsp;: '. $konsultasi->waktu_konsultasi.'<br>',
            'action' => url('konsultasi/'.$konsultasi->id),
            'action_caption' => 'Lihat Feedback'
        ];
        $user1->notify(new NotificationPST($details1));

        $this->createWANotif($konsultasi->petugas->no_hp,
            'Hallo *'.$konsultasi->petugas->nama_petugas.'*'."\r\n".
            'Anda Mendapatkan Feedback Konsultasi dengan topik '.$konsultasi->topik_diskusi.' dilaksanakan pada '.
            $konsultasi->tanggal_konsultasi.' jam '. $konsultasi->waktu_konsultasi);

        return new KonsultasiResource(true, 'Pemberian Feedback Berhasil', $konsultasi);
    }

    public function getKonsultasiNotif(){
        date_default_timezone_set('Asia/Jakarta');
    // echo date("Y-m-d H:i:s");
        $now = Carbon::now();
        // echo ($now);
        $thirtyMinutesLater = $now->copy()->addMinutes(30);

        $konsultasi = Konsultasi::with('petugas')
            ->where('status', 'diajukan')
            ->where(function($query) use ($now, $thirtyMinutesLater) {
                $query->where('tanggal_konsultasi', '=', $now->toDateString())
                  ->whereBetween('waktu_konsultasi', [$now->toTimeString(), $thirtyMinutesLater->toTimeString()]);
                //   ->orWhere('tanggal_konsultasi', '>', $now->toDateString());
            })
        ->get();
        // dd($konsultasi);
        return new KonsultasiResource(true, 'Daftar konsultasi', $konsultasi);

    }

    public function getKonsultasiReminder(){
        date_default_timezone_set('Asia/Jakarta');
    // echo date("Y-m-d H:i:s");
        $now = Carbon::now();
        // echo ($now);
        $thirtyMinutesLater = $now->copy()->addMinutes(30);

        $konsultasi = Konsultasi::with('petugas')
            ->where('status', 'disetujui')
            ->where(function($query) use ($now, $thirtyMinutesLater) {
                $query->where('tanggal_konsultasi', '=', $now->toDateString())
                  ->whereBetween('waktu_konsultasi', [$now->toTimeString(), $thirtyMinutesLater->toTimeString()]);
                //   ->orWhere('tanggal_konsultasi', '>', $now->toDateString());
            })
        ->get();
        // dd($konsultasi);
        return new KonsultasiResource(true, 'Daftar konsultasi', $konsultasi);

    }

    public function setNotifKonsultasi($id_konsultasi, $kd_notif){
        $konsultasi = Konsultasi::where('id',$id_konsultasi)->first();
        $konsultasi->update([
            'notif_flag' => $kd_notif
        ]);
        return new KonsultasiResource(true, 'Daftar message', $konsultasi);
    
    } 

    public function isiuuid(){
        $konsultasis = Konsultasi::where('uuid','')->get();
        //dd($konsultasis);
        foreach ($konsultasis as $konsultasi) {
            $konsultasi->uuid = Str::uuid()->toString(); // Generate UUID baru
            $konsultasi->save(); // Simpan perubahan
        }
    } 

}
