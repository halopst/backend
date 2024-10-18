<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('satkers')->delete();
        //
        $satkers=[
            [ 'id_satker' =>'3500', 'nama_satker'=>'BPS Provinsi Jawa Timur'],
            [ 'id_satker' =>'3501', 'nama_satker'=>'BPS Kabupaten Pacitan'],
            [ 'id_satker' =>'3502', 'nama_satker'=>'BPS Kabupaten Ponorogo'],
            [ 'id_satker' =>'3503', 'nama_satker'=>'BPS Kabupaten Trenggalek'],
            [ 'id_satker' =>'3504', 'nama_satker'=>'BPS Kabupaten Tulungagung'],
            [ 'id_satker' =>'3505', 'nama_satker'=>'BPS Kabupaten Blitar'],
            [ 'id_satker' =>'3506', 'nama_satker'=>'BPS Kabupaten Kediri'],
            [ 'id_satker' =>'3507', 'nama_satker'=>'BPS Kabupaten Malang'],
            [ 'id_satker' =>'3508', 'nama_satker'=>'BPS Kabupaten Lumajang'],
            [ 'id_satker' =>'3509', 'nama_satker'=>'BPS Kabupaten Jember'],
            [ 'id_satker' =>'3510', 'nama_satker'=>'BPS Kabupaten Banyuwangi'],
            [ 'id_satker' =>'3511', 'nama_satker'=>'BPS Kabupaten Bondowoso'],
            [ 'id_satker' =>'3512', 'nama_satker'=>'BPS Kabupaten Situbondo'],
            [ 'id_satker' =>'3513', 'nama_satker'=>'BPS Kabupaten Probolinggo'],
            [ 'id_satker' =>'3514', 'nama_satker'=>'BPS Kabupaten Pasuruan'],
            [ 'id_satker' =>'3515', 'nama_satker'=>'BPS Kabupaten Sidoarjo'],
            [ 'id_satker' =>'3516', 'nama_satker'=>'BPS Kabupaten Mojokerto'],
            [ 'id_satker' =>'3517', 'nama_satker'=>'BPS Kabupaten Jombang'],
            [ 'id_satker' =>'3518', 'nama_satker'=>'BPS Kabupaten Nganjuk'],
            [ 'id_satker' =>'3519', 'nama_satker'=>'BPS Kabupaten Madiun'],
            [ 'id_satker' =>'3520', 'nama_satker'=>'BPS Kabupaten Magetan'],
            [ 'id_satker' =>'3521', 'nama_satker'=>'BPS Kabupaten Ngawi'],
            [ 'id_satker' =>'3522', 'nama_satker'=>'BPS Kabupaten Bojonegoro'],
            [ 'id_satker' =>'3523', 'nama_satker'=>'BPS Kabupaten Tuban'],
            [ 'id_satker' =>'3524', 'nama_satker'=>'BPS Kabupaten Lamongan'],
            [ 'id_satker' =>'3525', 'nama_satker'=>'BPS Kabupaten Gresik'],
            [ 'id_satker' =>'3526', 'nama_satker'=>'BPS Kabupaten Bangkalan'],
            [ 'id_satker' =>'3527', 'nama_satker'=>'BPS Kabupaten Sampang'],
            [ 'id_satker' =>'3528', 'nama_satker'=>'BPS Kabupaten Pamekasan'],
            [ 'id_satker' =>'3529', 'nama_satker'=>'BPS Kabupaten Sumenep'],
            [ 'id_satker' =>'3571', 'nama_satker'=>'BPS Kota Kediri'],
            [ 'id_satker' =>'3572', 'nama_satker'=>'BPS Kota Blitar'],
            [ 'id_satker' =>'3573', 'nama_satker'=>'BPS Kota Malang'],
            [ 'id_satker' =>'3574', 'nama_satker'=>'BPS Kota Probolinggo'],
            [ 'id_satker' =>'3575', 'nama_satker'=>'BPS Kota Pasuruan'],
            [ 'id_satker' =>'3576', 'nama_satker'=>'BPS Kota Mojokerto'],
            [ 'id_satker' =>'3577', 'nama_satker'=>'BPS Kota Madiun'],
            [ 'id_satker' =>'3578', 'nama_satker'=>'BPS Kota Surabaya'],
            [ 'id_satker' =>'3579', 'nama_satker'=>'BPS Kota Batu']
        ];

        for($i=0; $i<count($satkers);$i++){
            DB::table('satkers')->insert(
                [   'id_satker' => $satkers[$i]['id_satker'],
                    'nama_satker' => $satkers[$i]['nama_satker']
                ]
            );
        }
    }
}
