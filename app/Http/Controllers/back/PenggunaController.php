<?php

namespace App\Http\Controllers\back;

use App\Models\Pengguna;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Http\Requests\StorePenggunaRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $idSatker= session('keycloak_user')['id_satker'];

        if($idSatker=='3500'){
            $pengguna=Pengguna::get();
        }else{
            $pengguna = Pengguna::whereHas('konsultasi', function($query) {
                $query->whereHas('petugas', function($query) {
                    $query->where('id_satker', session('keycloak_user')['id_satker']);
                });
            })->get();
        }
        
       
        
            // dd($pengguna);

        if(request()->ajax()){
            // $pengguna=Pengguna::whereHas('konsultasi')
            //     ->latest()
            //     ->get();
            // $pengguna=Pengguna::get();
            //$pengguna=Pengguna::with('Provinsi')->latest()->get();
            return DataTables::of($pengguna)
                ->addIndexColumn()
                ->addColumn('aksi', function($pengguna){
                    return
                        '<div class="text-center">
                            <a type="button" class="btn btn-sm btn-primary" href="pengguna/'.$pengguna->id.'"
                                >
                                Detail
                            </a>
                        </div>';
                    })
                ->rawColumns(['aksi'])    
                ->make();
        }

        return view('back.pengguna.index',[
            'provinsis'=>Provinsi::get()
            //'kabupatens'=>Kabupaten::get()
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
    public function store(StorePenggunaRequest $request)
    {
       //
        $data=$request->validated();
        
        // //foto validation
        $file=$request->file('foto');
        $filename=uniqid().'.'.$file->getClientOriginalExtension();
        $file->storeAs('public/back/user/',$filename);

        // $dataUser['email']=$data['email_google'].'@gmail.com';
        // $dataUser['name']=$data['email_google'];
        // $dataUser['google_id']='117014170219577938176';

        $data['foto']=$filename;
        $data['status']='baru';
        $data['tanggal_lahir']=date('Y-m-d', strtotime($data['tanggal_lahir']));
        $data['email_google']=$data['email_google'].'@gmail.com';

        

        Pengguna::create($data);
        // echo json_encode($data);
        return redirect(url('pengguna'))->with('success','Data Pengguna Pelayanan berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return view('back.pengguna.show', [
            'pengguna'=>Pengguna::find($id)
        ]);;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengguna $pengguna)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengguna $pengguna)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data=Pengguna::find($id);
        Storage::delete('public/back/user/'.$data->foto);
        $data->delete();

        return response()->json([
            'message'=>'Data Petugas Berhasil Dihapus'
        ]);
    }  
}
