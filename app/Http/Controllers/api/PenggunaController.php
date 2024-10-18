<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

//import model Pengguna
use App\Models\Pengguna;

//import resource PenggunaResource
use App\Http\Resources\PenggunaResource;

//import facade Validator
use Illuminate\Support\Facades\Validator;

class PenggunaController extends Controller
{
    //

    public function index()
    {
        //get all 
        $pengguna = Pengguna::with('Provinsi:id_prov,nama_prov','Kabupaten:id_kab,nama_kab')->get();

        //return collection as a resource
        return new PenggunaResource(true, 'List Data Pengguna', $pengguna);
    }

    public function show($id)
    {
        //find post by ID
        $petugas = Pengguna::find($id);

        //return single post as a resource
        return new PenggunaResource(true, 'Detail Data Pengguna!', $petugas);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //echo $request->email_pengguna;
        $pengguna = Pengguna::where('email_google', $request->email_google)->first();

         //return response()->json('tambahkan');
         $validator = Validator::make($request->all(), [
            'nama_pengguna'=>'required',
            'email_google'=>'required',
            'family_name'=>'required',
            'given_name'=>'required',
            'foto'=>'required'
        ]);

        // check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        //jika pengguna status=terdaftar
        if($pengguna){  
            //return response()->json($pengguna->id);
            Storage::delete('public/back/user/'.$pengguna->foto);
            
            $filename=uniqid().'.png';
            
            Storage::disk('userfoto')->put($filename, file_get_contents($request->foto));

            $pengguna= Pengguna::where('email_google', $request->email_google)
                ->update([  
                            'status' => 'terdaftar',
                            'nama_pengguna'=>$request->nama_pengguna,
                            'email_google'=>$request->email_google,
                            'family_name'=>$request->family_name,
                            'given_name'=>$request->given_name,
                            'foto'=>$filename
                        ]);
            $penggunaSave = Pengguna::where('email_google', $request->email_google)->first();
            return new PenggunaResource(true, 'Data Pengguna Berhasil Diupdate!', $penggunaSave);
    
        //jika pengguna sudah terdaftar
        }else{
           
            $filename=uniqid().'.png';
            
            Storage::disk('userfoto')->put($filename, file_get_contents($request->foto));

            $pengguna = Pengguna::create([
                    'nama_pengguna'=>$request->nama_pengguna,
                    'email_google'=>$request->email_google,
                    'family_name'=>$request->family_name,
                    'given_name'=>$request->given_name,
                    'foto'=>$filename,
                    'status'=>'baru',
                ]);
            $penggunaSave = Pengguna::where('email_google', $request->email_google)->first();
            return new PenggunaResource(true, 'Data Pengguna Berhasil Ditambahkan!', $penggunaSave);
        }  
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'pekerjaan'=>'required',
            'jenis_kelamin'=>'required',
            'tanggal_lahir'=>'required',
            'id_prov'=>'required',
            'id_kab'=>'required',
            'nmr_telp'=> 'required',
            'pendidikan'=> 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find konsiltasi by ID
        $pengguna = Pengguna::find($id);

        //update post without image
        $pengguna->update([
                'pekerjaan'=>$request->pekerjaan,
                'jenis_kelamin'=>$request->jenis_kelamin,
                'tanggal_lahir'=>$request->tanggal_lahir,
                'id_prov'=>$request->id_prov,
                'id_kab'=>$request->id_kab,
                'nmr_telp'=> $request->nmr_telp,
                'pendidikan'=> $request->pendidikan,
                'status'=>'terupdate'
            ]);
        

        //return response
        return new PenggunaResource(true, 'Data Pengguna Berhasil Diubah!', $pengguna);
    }
}
