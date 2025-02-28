<?php

namespace App\Http\Controllers\back;

use App\Models\Monev;
use App\Models\Satker;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMonevRequest;
use App\Http\Requests\UpdateMonevRequest;
use DataTables;

class MonevController extends Controller
{
    /**
     * Display the konsultasi view.
     */
    public function monkonsultasi()
    {
        // Logic for displaying konsultasi view
        return view('back.monev.konsultasi');
    }

    /**
     * Display the petugas view.
     */
    public function monpetugas()
    {
        // Logic for displaying petugas view
        return view('back.monev.petugas');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Mengambil data konsultasi berdasarkan filter Tahun, Bulan, Satker, dan status
     */

     public function getDataKonsultasi(Request $request)
     {
         $tahun = $request->query('tahun', date('Y'));
         $idSatker = $request->query('id_satker', null);
 
         $data = Monev::getMonevDataKonsultasi($tahun, $idSatker);
 
         return response()->json($data);
     }

     public function getDataSatker(Request $request)
     {
        $data = Satker::all();
        return response()->json($data);
     }

     public function getTahun()
    {
        $tahunList = Monev::getTahunDistinct(); // Panggil method dari Model
        return response()->json($tahunList);
    }

    public function getDataBySatker(Request $request)
    {
        $tahun = $request->input('tahun');
    
        $data = Monev::getMonevDataBySatker($tahun);
    
        return response()->json($data);
    }
    

    /*
    * Fungsi Mengambil data petugas konsultasi
    */
    public function getKonsultasiPetugas(Request $request)
    {
        
        if ($request->ajax()) {
            $data = Monev::getKonsultasiByPetugas();
            return DataTables::of($data)
                ->addIndexColumn() // Menambahkan DT_RowIndex secara otomatis
                ->make(true);

            
        }
    }    

    public function getDetailKonsultasi($id)
    {
        $data = Monev::getDetailKonsultasiByPetugas($id);

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    
}
