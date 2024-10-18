<?php

namespace App\Http\Controllers\back;

use App\Models\Petugas;
use App\Models\User;
use App\Models\Satker;
use App\Models\Keahlian;
use App\Models\Whatsapp;
use App\Http\Controllers\Controller;
use App\Http\Requests\PetugasRequest;
use App\Http\Requests\UpdatePetugasRequest;

use App\Notifications\NotificationPST;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if(request()->ajax()){
            $petugas=null;
            $idSatker= substr(session('keycloak_user')['kd_organisasi'],0,4);
            //$petugas=Petugas::with('Satker')->orderBy('id','ASC')->get();
            
            if($idSatker=='3500'){
                $petugas=Petugas::with('Satker')->orderBy('id_satker', 'ASC')->get();
            }else{
                $petugas=Petugas::with('Satker')->where('id_satker',$idSatker)->get();
            }

            return DataTables::of($petugas)
            ->addIndexColumn()
            ->addColumn('id_satker', function($petugas){
                    return $petugas->Satker->nama_satker;
                })
            ->addColumn('status', function($petugas){
                if ($petugas->status =='Admin') {
                    return '<span class="badge bg-danger"> Admin </span>';
                } else {
                    return '<span class="badge bg-success">Operator </span>';
                }
            })
            ->addColumn('aksi', function($petugas){
                return
                    '<div class="text-center">
                        <a type="button" class="btn btn-sm btn-primary" href="petugas/'.$petugas->id.'"
                            >
                            Detail
                        </a>
                        <a type="button" class="btn btn-sm btn-warning" href="petugas/'.$petugas->id.'/edit">
                            Edit
                        </a>
                        <a type="button" class="btn btn-sm btn-danger" href="#" onclick="deletePetugas(this)" 
                            data-id="'.$petugas->id.'">
                         Hapus
                        </a>
                    </div>';
                })
            ->rawColumns(['id_satker','status','aksi'])    
            ->make();
        }
        // return view('back.petugas.index', [
        //     'petugas'=>Petugas::with('Satker')->orderBy('id','ASC')->get()
        // ]);
        return view('back.petugas.index',[
            'satkers'=>Satker::get(),
            'keahlian'=>Keahlian::get()
        ]);
    }

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
    public function store(PetugasRequest $request)
    {
        $data=$request->validated();

        $dataUser['name']=$data['email_bps'];
        $dataUser['email']=$data['email_bps'].'@bps.go.id';

        if ($request->hasFile('foto')) {
            $file=$request->file('foto');
            $filename=uniqid().'.'.$file->getClientOriginalExtension();
            $data['foto']=$filename;
            $file->storeAs('public/back/petugas/',$filename);
        }else{
            if($data['jenis_kelamin']==1){
                $data['foto']='halo_pst_male.png';
            }else{
                $data['foto']='halo_pst_female.png';
            }
           
        }
        
        $data['email_bps']=$data['email_bps'].'@bps.go.id';
        $data['email_google']=$data['email_google'].'@gmail.com';

        User::create($dataUser);
        Petugas::create($data);

        $petugasInsert=Petugas::where('email_bps',$data['email_bps'])->first();
        $petugasInsert->keahlian()->sync($data['keahlian']);


        $user1= User::where('email', $data['email_bps'])->first();
        $details1 = [
            'subject'=>'Pendaftaran Petugas HaloPST',
            'penerima'=>$petugasInsert->nama_petugas,
            'message' => 'Anda didaftarkan sebagai <b>'.$petugasInsert->status.'</b> 
                pelayanan pada aplikasi HaloPST BPS Provinsi Jawa Timur',
            'action' => url(''),
            'action_caption' => 'HaloPST'
        ];
        $user1->notify(new NotificationPST($details1));

        $this->createWANotif($petugasInsert->no_hp,
                'Hallo *'.$petugasInsert->nama_petugas.'*'."\r\n".
                'Anda didaftarkan sebagai *'.$petugasInsert->status.'* 
                pelayanan pada aplikasi HaloPST BPS Provinsi Jawa Timur');

        return redirect(url('petugas'))
            ->with('success','Data Petugas Pelayanan berhasil ditambahkan');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('back.petugas.show', [
            'petugas'=>Petugas::with('Satker','keahlian')->find($id)
        ]);;
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $petugas=Petugas::with('keahlian')->find($id);
        $keahlian=$petugas->keahlian;
        $keahlianUser=[];

        foreach($keahlian as $ahli){
            array_push($keahlianUser,$ahli->id);
        }
        // dd($keahlianUser);
        //
        return view('back.petugas.update', [
            'petugas'=>$petugas,
            'satkers'=>Satker::get(),
            'keahlian'=>Keahlian::get(),
            'keahlianUser'=>$keahlianUser
        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetugasRequest $request, string $id)
    {
        $data=$request->validated();
        if ($request->hasFile('foto')) {
            # code...
            $file=$request->file('foto');

            $filename=uniqid().'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/back/petugas/',$filename);

            //hapus foto
            Storage::delete('public/back/petugas/'.$request->old_foto);

            $data['foto']=$filename;

        } 
        // else {
        //     $data['foto']=$request->old_foto;
        // }
        
        
        $data['email_bps']=$data['email_bps'].'@bps.go.id';
        $data['email_google']=$data['email_google'].'@gmail.com';

        Petugas::find($id)->update($data);

        $petugasInsert=Petugas::find($id);
        $petugasInsert->keahlian()->sync($data['keahlian']);

        return redirect(url('petugas'))->with('success','Data '.$request->nama_petugas.' berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data=Petugas::find($id);
        //dd($data['email_bps']);
        // $dataUser=User::where('email',$data['email_bps'])->first();

        Storage::delete('public/back/'.$data->foto);
        $data->delete();
        User::where('email', $data['email_bps'])->delete();

        return response()->json([
            'message'=>'Data Petugas Berhasil Dihapus'
        ]);
    }
    
    public function checkExistOrNo($email_bps){
        $return=false;
        $petugas=Petugas::where('email_bps', $email_bps)->first();
       
        if($petugas==null){
            $return=false;
        }else{
            $return=true;
        }
        return response()->json([
            'output'=>$return
        ]);
    } 

    public function getPetugas(){
        $idSatker=substr(session('keycloak_user')['kd_organisasi'],0,4);
        $petugas=Petugas::with('Satker')->where('id_satker',$idSatker)->get();

        return response()->json([
            'petugas'=>$petugas
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
