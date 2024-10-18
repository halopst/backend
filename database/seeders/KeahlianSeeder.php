<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class KeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $keahlian=[
                [  'nama_keahlian'=>'Data Sosial'],
                [  'nama_keahlian'=>'Data Pertanian'],
                [  'nama_keahlian'=>'Data Ekonomi'],
                [  'nama_keahlian'=>'Pelayanan Umum'],
                [  'nama_keahlian'=>'Rekomendasi Statistik'],
                [  'nama_keahlian'=>'Pembelian Data Mikro'],
                [  'nama_keahlian'=>'Pemodelan Statistik'],
                [  'nama_keahlian'=>'Data Spasial']
        ];

        for($i=0; $i<count($keahlian);$i++){
            DB::table('keahlians')->insert(
                [  
                    'nama_keahlian' => $keahlian[$i]['nama_keahlian']
                ]
            );
        }
    }
}
