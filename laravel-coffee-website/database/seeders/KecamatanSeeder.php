<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatan = [
            'Bantar Gebang',
            'Bekasi Barat',
            'Bekasi Selatan',
            'Bekasi Timur',
            'Bekasi Utara',
            'Jatiasih',
            'Jatisampurna',
            'Medan Satria',
            'Mustika Jaya',
            'Pondok Gede',
            'Pondok Melati',
            'Rawalumbu'
        ];

        foreach ($kecamatan as $nama_kec) {
            DB::table('tbl_kec')->insert([
                'nama_kec' => $nama_kec,
                // 'created_at' => now(),
                // 'updated_at' => now()
            ]);
        }
    }
}
