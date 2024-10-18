<?php

namespace App\Http\Controllers\api;

use App\Models\Aida;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAidaRequest;
use App\Http\Requests\UpdateAidaRequest;

//import resource PenggunaResource
use App\Http\Resources\AidaResource;

//import facade Validator
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        //get all 
        $aida = Aida::with('pengguna:id,nama_pengguna,email_google,family_name,given_name,foto')->get();

        //return collection as a resource
        return new AidaResource(true, 'List Data Aida', $aida);
   
    }

    public function getAidaByPengguna($idPengguna){
        $aida=Aida::with('pengguna:id,nama_pengguna,email_google,family_name,given_name,foto')
                    ->where('id_pengguna',$idPengguna)
                    ->where('status',1) 
                    ->get();
          
        return new AidaResource(true, 'List Aida  By Pengguna', $aida);
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
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'resume'=>'required',
            'conversation'=>'required',
            'id_pengguna'=>'required'
        ]);

         // check if validation fails
         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $aida = Aida::create([
            'resume'=>$request->resume,
            'conversation'=>$request->conversation,
            'id_pengguna'=>$request->id_pengguna,
            'status'=>1
        ]);

        return new AidaResource(true, 'Percakapan Berhasil Ditambahkan..!', $aida);
    
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //find konsultasi by ID
        $aida = Aida::with('pengguna:id,nama_pengguna,,email_google,family_name,given_name,foto')->find($id);

        //return single konsultasi as a resource
        return new AidaResource(true, 'Detail Aida !', $aida);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aida $aida)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$idAida)
    {
        //
        
    }

    public function updateConversation(Request $request,$idAida)
    {
        //
        $aida = Aida::with('pengguna:id,nama_pengguna,email_google')
                    ->find($idAida);
        
        $validator = Validator::make($request->all(), [
            'conversation'     => 'required',
        ]);

        $aida->update([
            'conversation'     => $request->conversation
        ]);

        return new AidaResource(true, 'Data Aida telah diupdate', $aida);
    }

    public function deleteConversation($idAida)
    {
        //
        $aida = Aida::with('pengguna:id,nama_pengguna,email_google,email_google,family_name,given_name,foto')
                    ->find($idAida);
        
        $aida->update([
            'status'     => 2
        ]);

        $aidaReturn=Aida::with('pengguna:id,nama_pengguna')
            ->where('id_pengguna',$aida->pengguna->id)->get();
        
        return new AidaResource(true, 'Data Aida telah dihapus', $aidaReturn);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aida $aida)
    {
        //
    }
}
