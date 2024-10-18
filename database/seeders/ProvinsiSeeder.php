<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinsis=[
            [ 'id_prov' =>'11', 'nama_prov'=>'Aceh'],
[ 'id_prov' =>'12', 'nama_prov'=>'Sumatera Utara'],
[ 'id_prov' =>'13', 'nama_prov'=>'Sumatera Barat'],
[ 'id_prov' =>'14', 'nama_prov'=>'Riau'],
[ 'id_prov' =>'15', 'nama_prov'=>'Jambi'],
[ 'id_prov' =>'16', 'nama_prov'=>'Sumatera Selatan'],
[ 'id_prov' =>'17', 'nama_prov'=>'Bengkulu'],
[ 'id_prov' =>'18', 'nama_prov'=>'Lampung'],
[ 'id_prov' =>'19', 'nama_prov'=>'Kep. Bangka Belitung'],
[ 'id_prov' =>'21', 'nama_prov'=>'Kep. Riau'],
[ 'id_prov' =>'31', 'nama_prov'=>'Dki Jakarta'],
[ 'id_prov' =>'32', 'nama_prov'=>'Jawa Barat'],
[ 'id_prov' =>'33', 'nama_prov'=>'Jawa Tengah'],
[ 'id_prov' =>'34', 'nama_prov'=>'Di Yogyakarta'],
[ 'id_prov' =>'35', 'nama_prov'=>'Jawa Timur'],
[ 'id_prov' =>'36', 'nama_prov'=>'Banten'],
[ 'id_prov' =>'51', 'nama_prov'=>'Bali'],
[ 'id_prov' =>'52', 'nama_prov'=>'Nusa Tenggara Barat'],
[ 'id_prov' =>'53', 'nama_prov'=>'Nusa Tenggara Timur'],
[ 'id_prov' =>'61', 'nama_prov'=>'Kalimantan Barat'],
[ 'id_prov' =>'62', 'nama_prov'=>'Kalimantan Tengah'],
[ 'id_prov' =>'63', 'nama_prov'=>'Kalimantan Selatan'],
[ 'id_prov' =>'64', 'nama_prov'=>'Kalimantan Timur'],
[ 'id_prov' =>'65', 'nama_prov'=>'Kalimantan Utara'],
[ 'id_prov' =>'71', 'nama_prov'=>'Sulawesi Utara'],
[ 'id_prov' =>'72', 'nama_prov'=>'Sulawesi Tengah'],
[ 'id_prov' =>'73', 'nama_prov'=>'Sulawesi Selatan'],
[ 'id_prov' =>'74', 'nama_prov'=>'Sulawesi Tenggara'],
[ 'id_prov' =>'75', 'nama_prov'=>'Gorontalo'],
[ 'id_prov' =>'76', 'nama_prov'=>'Sulawesi Barat'],
[ 'id_prov' =>'81', 'nama_prov'=>'Maluku'],
[ 'id_prov' =>'82', 'nama_prov'=>'Maluku Utara'],
[ 'id_prov' =>'91', 'nama_prov'=>'Papua Barat'],
[ 'id_prov' =>'94', 'nama_prov'=>'Papua']

        ];
        
    for($i=0; $i<count($provinsis);$i++){
            DB::table('provinsis')->insert(
                [   'id_prov' => $provinsis[$i]['id_prov'],
                    'nama_prov' => $provinsis[$i]['nama_prov']
                ]
            );
        }
    }
}