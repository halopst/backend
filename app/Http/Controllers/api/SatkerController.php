<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//import model Satker
use App\Models\Satker;

//import resource SatkerResource
use App\Http\Resources\SatkerResource;

class SatkerController extends Controller
{
    //
    public function index()
    {
        //get all 
        $satker = Satker::get();

        //return collection as a resource
        return new SatkerResource(true, 'List Data Satker', $satker);
    }
}
