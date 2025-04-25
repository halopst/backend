<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Monev extends Model
{
    use HasFactory;

    protected $table = 'konsultasis'; // Sesuaikan dengan nama tabel di database
    protected $fillable = ['tanggal_konsultasi', 'status', 'id_satker']; // Sesuaikan dengan kolom yang ada di tabel



    public static function getMonevDataKonsultasi($tahun, $idSatker = null)
    {
              
        if ($idSatker){
            $query = self::selectRaw("
                MONTH(tanggal_konsultasi) as bulan,
                id_satker,
                COUNT(*) as total_konsultasi,
                SUM(CASE WHEN status = 'Diajukan' THEN 1 ELSE 0 END) as diajukan,
                SUM(CASE WHEN status = 'Disetujui' THEN 1 ELSE 0 END) as disetujui,
                SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as selesai,
                SUM(CASE WHEN status = 'Dibatalkan' THEN 1 ELSE 0 END) as dibatalkan
            ");
        } else {
            $query = self::selectRaw("
                MONTH(tanggal_konsultasi) as bulan,
                COUNT(*) as total_konsultasi,
                SUM(CASE WHEN status = 'Diajukan' THEN 1 ELSE 0 END) as diajukan,
                SUM(CASE WHEN status = 'Disetujui' THEN 1 ELSE 0 END) as disetujui,
                SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as selesai,
                SUM(CASE WHEN status = 'Dibatalkan' THEN 1 ELSE 0 END) as dibatalkan
            ");
        }
        
        $query->whereYear('tanggal_konsultasi', $tahun);

        if ($idSatker) {
            $query->where('id_satker', $idSatker);
            $query->groupBy('bulan','id_satker')
                  ->orderBy('bulan', 'ASC');
        } else {
            $query->groupBy('bulan')
                  ->orderBy('bulan', 'ASC');
        }

        return $query->get();

        
    }


    // untuk grafik kedua
    public static function getMonevDataBySatker($tahun, $bulan)
    {
        // return self::selectRaw("
        //     s.nama_satker,
        //     COUNT(*) as total_konsultasi,
        //     SUM(CASE WHEN k.status = 'Diajukan' THEN 1 ELSE 0 END) as diajukan,
        //     SUM(CASE WHEN k.status = 'Disetujui' THEN 1 ELSE 0 END) as disetujui,
        //     SUM(CASE WHEN k.status = 'Selesai' THEN 1 ELSE 0 END) as selesai,
        //     SUM(CASE WHEN k.status = 'Dibatalkan' THEN 1 ELSE 0 END) as dibatalkan
        // ")
        // ->from('konsultasis as k')
        // ->join('satkers as s', 'k.id_satker', '=', 's.id_satker')
        // ->whereYear('tanggal_konsultasi', $tahun)
        // ->groupBy('s.nama_satker')
        // ->orderBy('total_konsultasi', 'DESC')
        // ->get();

        return \DB::table('satkers as s')
        ->leftJoin('konsultasis as k', function ($join) use ($tahun, $bulan) {
            $join->on('k.id_satker', '=', 's.id_satker')
                ->whereYear('k.tanggal_konsultasi', '=', $tahun);

            if ($bulan) {
                $join->whereMonth('k.tanggal_konsultasi', '=', $bulan);
            }
        })
        ->selectRaw("
            s.nama_satker,
            COUNT(k.id) as total_konsultasi,
            SUM(CASE WHEN k.status = 'Diajukan' THEN 1 ELSE 0 END) as diajukan,
            SUM(CASE WHEN k.status = 'Disetujui' THEN 1 ELSE 0 END) as disetujui,
            SUM(CASE WHEN k.status = 'Selesai' THEN 1 ELSE 0 END) as selesai,
            SUM(CASE WHEN k.status = 'Dibatalkan' THEN 1 ELSE 0 END) as dibatalkan
        ")
        ->groupBy('s.nama_satker')
        ->orderBy('total_konsultasi', 'DESC')
        ->get();
    }

    public static function getTahunDistinct()
    {
        return self::selectRaw('YEAR(tanggal_konsultasi) as tahun')
                   ->distinct()
                   ->orderBy('tahun', 'ASC')
                   ->pluck('tahun');
    }

    // Untuk Tabel ketiga

    public static function getKonsultasiByPetugas($idSatker = null)
    {
        return DB::table('petugas')
        ->leftJoin('konsultasis', 'petugas.id', '=', 'konsultasis.id_petugas')
        ->leftJoin('satkers', 'petugas.id_satker', '=', 'satkers.id_satker')
        ->select(
            'petugas.id as id_petugas',
            'petugas.nama_petugas',
            'satkers.nama_satker',
            DB::raw('COUNT(konsultasis.id) as total_konsultasi'),
            DB::raw('SUM(CASE WHEN konsultasis.status = "Selesai" THEN 1 ELSE 0 END) / NULLIF(COUNT(konsultasis.id), 0) * 100 as success_rate'),
            DB::raw('AVG(konsultasis.rating) as rata_rata_rating')
        )
        ->when($idSatker, function ($query) use ($idSatker) {
            return $query->where('satkers.id_satker', $idSatker);
        })
        ->groupBy('petugas.id', 'petugas.nama_petugas', 'satkers.nama_satker')
        ->orderByDesc('total_konsultasi')
        ->get();
    }

    public static function getDetailKonsultasiByPetugas($id)
    {
        return self::where('id_petugas', $id)
            ->select('id', 'topik_diskusi', 'tanggal_konsultasi', 'status','rating',)
            ->orderByDesc('tanggal_konsultasi')
            ->get();
    }
}

