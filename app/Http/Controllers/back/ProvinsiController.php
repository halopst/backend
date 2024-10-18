<?php

namespace App\Http\Controllers\back;

use App\Models\Provinsi;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProvinsiRequest;
use App\Http\Requests\UpdateProvinsiRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if(request()->ajax()){
            $provinsi=Provinsi::get();
            
            return DataTables::of($provinsi)
                ->addIndexColumn()
                ->addColumn('aksi', function($provinsi){
                    return
                        '<div class="text-center">
                            <a type="button" class="btn btn-sm btn-primary" href="petugas/'.$provinsi->id_prov.'"
                                >
                                Detail
                            </a>
                            <a type="button" class="btn btn-sm btn-warning" href="petugas/'.$provinsi->id_prov.'/edit">
                                Edit
                            </a>
                            <a type="button" class="btn btn-sm btn-danger" href="#" onclick="deletePetugas(this)" 
                                data-id="'.$provinsi->id_prov.'">
                             Hapus
                            </a>
                        </div>';
                    })
                ->rawColumns(['aksi']) 
                ->make();   
        }
        return view('back.provinsi.index');
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
    public function store(StoreProvinsiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Provinsi $provinsi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provinsi $provinsi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProvinsiRequest $request, Provinsi $provinsi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provinsi $provinsi)
    {
        //
    }
}
