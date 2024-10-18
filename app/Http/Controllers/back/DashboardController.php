<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Petugas;
use App\Models\Pengguna;
use App\Models\Konsultasi;
use App\Models\Satker;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index(){
        // return view('back.dashboard.index', compact('notifications', 'userEmail'));
        $today = Carbon::today();

        // Mengambil data yang tanggal_konsultasi-nya adalah hari ini
        $jumlahKonsultasiHariIni = Konsultasi::
            whereDate('tanggal_konsultasi', $today)
            ->where('id_petugas', session('keycloak_user')['id_petugas'])
            ->get()->count();

        $jumlahKonsultasiBySatker = Satker::leftJoin('petugas', 'satkers.id_satker', '=', 'petugas.id_satker')
            ->leftJoin('konsultasis', 'petugas.id', '=', 'konsultasis.id_petugas')
            ->select('satkers.nama_satker', DB::raw('COUNT(konsultasis.id) as jumlah_konsultasi'))
            ->groupBy('satkers.nama_satker','satkers.id_satker')
            ->orderBy('satkers.id_satker')
            ->get();
        
        $jumlahKonsultasiBySatkerSelesai = Satker::leftJoin('petugas', 'satkers.id_satker', '=', 'petugas.id_satker')
            ->leftJoin('konsultasis', function($join) {
                $join->on('petugas.id', '=', 'konsultasis.id_petugas')
                     ->where('konsultasis.status', 'Selesai')
                     ->where('petugas.id_satker', '3500');
            })
            ->select('satkers.id_satker', 'satkers.nama_satker', DB::raw('COUNT(konsultasis.id) as jumlah_konsultasi'))
            ->groupBy('satkers.id_satker', 'satkers.nama_satker')
            ->orderBy('satkers.id_satker')
            ->get();
        
        //dd($jumlahKonsultasiBySatkerSelesai);
        $jumlahKonsultasiPerBulan = Konsultasi::join('petugas', 'konsultasis.id_petugas', '=', 'petugas.id')
            ->select(DB::raw('YEAR(tanggal_konsultasi) as year, MONTH(tanggal_konsultasi) as month, COUNT(*) as jumlah_konsultasi'))
            ->where('petugas.id_satker', session('keycloak_user')['id_satker'])
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        //dd($jumlahKonsultasiPerBulan);

        //menghitung bulan ini dan bulan depan
        $currentMonth = Carbon::now()->month;
        $previousMonth = Carbon::now()->subMonth()->month;
        $currentYear = Carbon::now()->year;

        // Jumlah konsultasi bulan ini
        $jumlahKonsultasiBulanIni = Konsultasi::whereHas('petugas', function($query) {
            $query->where('id_satker', session('keycloak_user')['id_satker']);
        })->whereMonth('tanggal_konsultasi', $currentMonth)
          ->whereYear('tanggal_konsultasi', $currentYear)
          ->count();

        // Jumlah konsultasi bulan sebelumnya
        $jumlahKonsultasiBulanLalu = Konsultasi::whereHas('petugas', function($query) {
            $query->where('id_satker', session('keycloak_user')['id_satker']);
        })->whereMonth('tanggal_konsultasi', $previousMonth)
          ->whereYear('tanggal_konsultasi', $currentYear)
          ->count();
        $growthArray=[];
        if($jumlahKonsultasiBulanLalu != 0){
            $growthArray=[round((($jumlahKonsultasiBulanIni-$jumlahKonsultasiBulanLalu)/$jumlahKonsultasiBulanLalu),2)];
        }else{
            $growthArray=[0];
        }
        array_push($growthArray,$this->getBulan($currentMonth).' - '.$currentYear);
        array_push($growthArray,$jumlahKonsultasiBulanIni);
        //dd($growthArray);

        $bulanKonsultasiArray=[];
        foreach ($jumlahKonsultasiPerBulan as $konsultasi){
            //echo $this->getBulan($konsultasi->month);
            array_push($bulanKonsultasiArray,$konsultasi->year.' - '.$this->getBulan($konsultasi->month));
        }
       

        // Convert the result to an array of consultation counts
        $jumlahKonsultasiArray = $jumlahKonsultasiBySatker->pluck('jumlah_konsultasi')->toArray();
        $jumlahKonsultasiSelesaiArray = $jumlahKonsultasiBySatkerSelesai->pluck('jumlah_konsultasi')->toArray();
        $jumlahKonsultasiPerBulanArray = $jumlahKonsultasiPerBulan->pluck('jumlah_konsultasi',)->toArray();

        $jumlahPetugas=0;
        $jumlahPengguna=0;
        $jumlahKonsultasi=0;
        if(session('keycloak_user')['id_satker']=='3500'){
            $jumlahPetugas=Petugas::get()->count();
            $jumlahPengguna = Pengguna::get()->count();
            $jumlahKonsultasi=Konsultasi::get()->count();
            $jumlahSelesaiKonsultasi=Konsultasi::where('status','Selesai')->get()->count();
        }else{
            $jumlahPetugas=Petugas::where('id_satker',session('keycloak_user')['id_satker'])->get()->count();
            $jumlahPengguna = Pengguna::whereHas('konsultasi', function($query) {
                $query->whereHas('petugas', function($query) {
                    $query->where('id_satker', session('keycloak_user')['id_satker']);
                });
            })->get()->count();
            $jumlahKonsultasi = Konsultasi::join('petugas', 'konsultasis.id_petugas', '=', 'petugas.id')
                    ->where('petugas.id_satker', session('keycloak_user')['id_satker'])
                    ->count();
            $jumlahSelesaiKonsultasi = Konsultasi::join('petugas', 'konsultasis.id_petugas', '=', 'petugas.id')
                    ->where('konsultasis.status','Selesai')
                    ->where('petugas.id_satker', session('keycloak_user')['id_satker'])
                    ->count();
        }
        //dd($jumlahKonsultasiPerBulanArray);
        return view('back.dashboard.index',[
            'jumlahPetugas'=>$jumlahPetugas,
            'jumlahPengguna'=> $jumlahPengguna,
            'jumlahkonsultasi'=>$jumlahKonsultasi,
            'jumlahKonsultasiHariIni'=>$jumlahKonsultasiHariIni,
            'jumlahSelesaiKonsultasi'=>$jumlahSelesaiKonsultasi,
            'jumlahKonsultasiKabkot'=>$jumlahKonsultasiArray,
            'jumlahKonsultasiBySatkerSelesai'=>$jumlahKonsultasiSelesaiArray,
            'jumlahKonsultasiPerBulan'=>$jumlahKonsultasiPerBulanArray,
            'bulanKonsultasi'=>$bulanKonsultasiArray,
            'growth'=>$growthArray
        ]);

        
    }

    function getBulan($bln){
        switch ($bln){
         case 1:
          return "Januari";
          break;
         case 2:
          return "Februari";
          break;
         case 3:
          return "Maret";
          break;
         case 4:
          return "April";
          break;
         case 5:
          return "Mei";
          break;
         case 6:
          return "Juni";
          break;
         case 7:
          return "Juli";
          break;
         case 8:
          return "Agustus";
          break;
         case 9:
          return "September";
          break;
         case 10:
          return "Oktober";
          break;
         case 11:
          return "November";
          break;
         case 12:
          return "Desember";
          break;
        }
       }
}
