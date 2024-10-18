<?php

namespace App\Http\Controllers\back;

use App\Models\Keahlian;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKeahlianRequest;
use App\Http\Requests\UpdateKeahlianRequest;
use Illuminate\Support\Facades\Storage;

class KeahlianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('back.keahlian.index', [
            'keahlian'=>Keahlian::orderBy('id','ASC')->get()
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
    public function store(StoreKeahlianRequest $request)
    {
        //
        $data=$request->validated();

        $file=$request->file('icon');
        $filename=uniqid().'.'.$file->getClientOriginalExtension();
        $file->storeAs('public/back/keahlian/',$filename);

        $data['icon']=$filename;

        Keahlian::create($data);
        // echo json_encode($data);
        return redirect(url('keahlian'))->with('success','Data Keahlian Berhasil Ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return view('back.keahlian.show', [
            'keahlian'=>Keahlian::find($id)
        ]);;
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $keahlian=Keahlian::find($id);
        //$keahlian=$petugas->keahlian;
        //$keahlianUser=[];
        return view('back.keahlian.update', [
            'keahlian'=>$keahlian,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKeahlianRequest $request, string $id)
    {
        //dd('dsadsa');
        //
        $data=$request->validated();

        if ($request->hasFile('icon')) {
            # code...
            $file=$request->file('icon');

            $filename=uniqid().'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/back/keahlian/',$filename);

            //hapus foto
            Storage::delete('public/back/keahlian/'.$request->old_icon);

            $data['icon']=$filename;

        } else {
            $data['icon']=$request->old_icon;
        }

        Keahlian::find($id)->update($data);

        return redirect(url('keahlian'))->with('success','Data '.$request->nama_keahlian.' berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        //
        $data=Keahlian::find($id);
        Storage::delete('public/back/keahlian/'.$data->icon);
        $data->delete();

        return response()->json([
            'message'=>'Data Keahlian Berhasil Dihapus'
        ]);
    }
}
