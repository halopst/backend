<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//import model
use App\Models\Keahlian;

//import resource PetugasResource
use App\Http\Resources\KeahlianResource;

class KeahlianController extends Controller
{
     /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all keahlian
        $keahlian = Keahlian::where('tampilkan',1)
                ->get();
        
        //return collection of keahlian as a resource
        return new KeahlianResource(true, 'List Data Keahlian', $keahlian);
    }
}
