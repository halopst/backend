<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//import model Kabupaten
use App\Models\Provinsi;

//import resource PetugasResource
use App\Http\Resources\ProvinsiResource;

class ProvinsiController extends Controller
{
    //
    public function index()
    {
        //get all posts
        $provinsi = Provinsi::get();

        //return collection of posts as a resource
        return new ProvinsiResource(true, 'List Data Provinsi', $provinsi);
    }
}
