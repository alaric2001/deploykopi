<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Kelurahan;
use Illuminate\Support\Facades\DB;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelurahan = [
            'Bantar Gebang' => ['Bantargebang', 'Ciketing Udik', 'Cikiwul', 'Sumur Batu'],
            'Bekasi Barat' => ['Bintara', 'Bintara Jaya', 'Jakasampurna', 'Kota Baru', 'Kranji'],
            'Bekasi Selatan' => ['Jakamulya', 'Jakasetia', 'Kayuringin Jaya', 'Marga Jaya', 'Pekayon Jaya'],
            'Bekasi Timur' => ['Aren Jaya', 'Bekasi Jaya', 'Duren Jaya', 'Margahayu'],
            'Bekasi Utara' => ['Harapan Baru', 'Harapan Jaya', 'Kaliabang Tengah', 'Marga Mulya', 'Perwira', 'Teluk Pucung'],
            'Jatiasih' => ['Jatiasih', 'Jatikramat', 'Jatiluhur', 'Jatimekar', 'Jatirasa', 'Jatisari'],
            'Jatisampurna' => ['Jatikarya', 'Jatiraden', 'Jatirangga', 'Jatiranggon', 'Jatisampurna'],
            'Medan Satria' => ['Pejuang', 'Medan Satria', 'Harapan Mulya', 'Kali Baru'],
            'Mustika Jaya' => ['Cimuning', 'Mustikajaya', 'Mustikasari', 'Pedurenan'],
            'Pondok Gede' => ['Jatibening', 'Jatibening Baru', 'Jaticempaka', 'Jatimakmur', 'Jatiwaringin'],
            'Pondok Melati' => ['Jatimelati', 'Jatimurni', 'Jatirahayu', 'Jatiwarna'],
            'Rawalumbu' => ['Bojong Menteng', 'Bojong Rawalumbu', 'Pengasinan', 'Sepanjang Jaya']
        ];

        foreach ($kelurahan as $nama_kec => $kelurahan_list) {
            $kecamatan = DB::table('tbl_kec')->where('nama_kec', $nama_kec)->first();
            if ($kecamatan) {
                foreach ($kelurahan_list as $nama_kel) {
                    DB::table('tbl_kel')->insert([
                        'id_kec' => $kecamatan->id,
                        'nama_kel' => $nama_kel,
                        // 'created_at' => now(),
                        // 'updated_at' => now()
                    ]);
                }
            }
        }
    }
}
