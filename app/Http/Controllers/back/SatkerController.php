<?php

namespace App\Http\Controllers\back;
use App\Http\Controllers\Controller;
use App\Models\Satker;
use Illuminate\Http\Request;

class SatkerController extends Controller
{

   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('back.satker.index', [
            'satker'=>Satker::orderBy('id_satker','ASC')->get()
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
    public function store(Request $request)
    {
        //
        $data=$request-> validate([
            'id_satker'=>'required|unique:satkers|digits:4',
            'nama_satker'=>'required|min:3|max:255|regex:/^([a-zA-Z]+\s)*[a-zA-Z]+$/'
        ]);

        Satker::create($data);
        return back()->with('success', 'Data Satuan Kerja Berhasil Dibuat');
        //dd('ok');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_satker)
    {
        //
        $data=$request-> validate([
            'id_satker'=>'required|digits:4',
            'nama_satker'=>'required|min:3|max:255|regex:/^([a-zA-Z]+\s)*[a-zA-Z]+$/'
        ]);

        Satker::find($id_satker)->update($data);
        return back()->with('success', 'Data Satuan Kerja Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Satker::find($id)->delete();
        return back()->with('success', 'Satuan Kerja Berhasil Diupdate');
    }
}
