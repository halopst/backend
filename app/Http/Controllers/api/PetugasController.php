<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//import model
use App\Models\Petugas;
use App\Models\Konsultasi;
use App\Models\Satker;
use App\Models\Keahlian;

//import resource PetugasResource
use App\Http\Resources\PetugasResource;

class PetugasController extends Controller
{
   /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $petugas = Petugas::with('Satker', 'keahlian:id,nama_keahlian')
                ->where('tampil',1)
                ->get(['id','nama_petugas','email_bps','id_satker','jabatan','foto','nama_panggilan', 'jenis_kelamin']);
        
        //return collection of posts as a resource
        return new PetugasResource(true, 'List Data Petugas', $petugas);
    }
    
    public function getPetugasSatker($idSatker){
        $petugas = Petugas::where('id_satker',$idSatker)
            ->where('tampil',1)
            ->with('Satker', 'keahlian:id,nama_keahlian')
            ->get(['id','nama_petugas','email_bps','id_satker','jabatan','foto','nama_panggilan', 'jenis_kelamin']);
        return new PetugasResource(true, 'List Data Petugas By Satker', $petugas);
    }

    public function getPetugasByKeahlian($idKeahlian){
     
        $keahlian = Keahlian::
            with('petugas:id,nama_petugas,email_bps,id_satker,jabatan,foto,nama_panggilan,jenis_kelamin,tampil')
            ->find($idKeahlian);
        
        if ($keahlian){
            $petugass=$keahlian->petugas;
            for ($i=0;$i<count($petugass); $i++){
                if($petugass[$i]->tampil==1){
                    $petugass[$i]->Satker;
                    $petugass[$i]->keahlian;
                }else{
                    unset($petugass[$i]);
                }
                
            }
        }
        return new PetugasResource(true, 'List Data Keahlian By idKeahlian', $petugass);
    }

    public function show($id)
    {
        //find petugas by id
        $petugas = Petugas::with('Satker', 'keahlian:id,nama_keahlian')
                ->find($id, ['id','nama_petugas','email_bps','id_satker','jabatan','foto','nama_panggilan', 'jenis_kelamin']);

        //return single post as a resource
        return new PetugasResource(true, 'Detail Data Petugas!', $petugas);
    }
}
