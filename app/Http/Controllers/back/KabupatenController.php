<?php

namespace App\Http\Controllers\back;

use App\Models\Kabupaten;
use App\Models\Provinsi;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKabupatenRequest;
use App\Http\Requests\UpdateKabupatenRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KabupatenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if(request()->ajax()){
            $kabupaten=Kabupaten::with('Provinsi')->get();
            return DataTables::of($kabupaten)
                ->addIndexColumn()
                ->addColumn('aksi', function($kabupaten){
                    return
                        '<div class="text-center">
                            <a type="button" class="btn btn-sm btn-primary" href="petugas/'.$kabupaten->id_kab.'"
                                >
                                Detail
                            </a>
                            <a type="button" class="btn btn-sm btn-warning" href="petugas/'.$kabupaten->id_kab.'/edit">
                                Edit
                            </a>
                            <a type="button" class="btn btn-sm btn-danger" href="#" onclick="deletePetugas(this)" 
                                data-id="'.$kabupaten->id_kab.'">
                             Hapus
                            </a>
                        </div>';
                    })
                ->rawColumns(['aksi']) 
                ->make(); 
        }
        return view('back.kabupaten.index');
    }

    public function getKab(Request $request){
        //echo 'dsadjsa';
        $data['kabupatens']=Kabupaten::where('id_prov',$request->id_prov)->get();
        return response()->json($data);
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
    public function store(StoreKabupatenRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Kabupaten $kabupaten)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kabupaten $kabupaten)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKabupatenRequest $request, Kabupaten $kabupaten)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kabupaten $kabupaten)
    {
        //
    }
}
