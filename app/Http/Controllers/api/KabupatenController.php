<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//import model Kabupaten
use App\Models\Kabupaten;

//import resource PetugasResource
use App\Http\Resources\KabupatenResource;

class KabupatenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         //get all posts
         $kabupaten = Kabupaten::get();
         

         //return collection of posts as a resource
         return new KabupatenResource(true, 'List Data Kabupaten', $kabupaten);
    
    }

    public function getKabByProv($idProv){
        $kabupaten = Kabupaten::where('id_prov',$idProv)->get();
        return new KabupatenResource(true, 'List Data Kabupaetn By Provinsi', $kabupaten);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
