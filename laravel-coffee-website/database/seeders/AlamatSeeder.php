<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alamat;
use App\Models\User;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Faker\Factory as Faker;

class AlamatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();
        Alamat::create([
            'id_user' => 1,
            'kab_kota' => 'Kota Bekasi',
            'kec' => 'Rawalumbu',
            'kel' => 'Bojong Rawalumbu',
            'harga_ongkir' => 0,
            'kodepos' => $faker->numberBetween(10000, 99999),
            'detail' => 'RT.006/RW.038, Bojong Rawalumbu, Kec. Rawalumbu, Kota Bks, Jawa Barat 17116',
        ]);

        Alamat::create([
            'id_user' => 2,
            'kab_kota' => 'Kota Bekasi',
            'kec' => 'Bekasi Barat',
            'kel' => 'Bintara Jaya',
            'harga_ongkir' => 10000,
            'kodepos' => $faker->numberBetween(10000, 99999),
            'detail' => '',
        ]);

        Alamat::create([
            'id_user' => 3,
            'kab_kota' => 'Kota Bekasi',
            'kec' => 'Bekasi Selatan',
            'harga_ongkir' => 10000,
            'kel' => 'Jakamulya',
            'kodepos' => $faker->numberBetween(10000, 99999),
            'detail' => 'Banten Cilegon',
        ]);

        Alamat::create([
            'id_user' => 4,
            'kab_kota' => 'Kota Bekasi',
            'kec' => 'Rawalumbu',
            'kel' => 'Bojong Rawalumbu',
            'harga_ongkir' => 0,
            'kodepos' => $faker->numberBetween(10000, 99999),
            'detail' => 'RT.006/RW.038, Bojong Rawalumbu, Kec. Rawalumbu, Kota Bks, Jawa Barat 17116',
        ]);

        Alamat::create([
            'id_user' => 5,
            'kab_kota' => 'Kota Bekasi',
            'kec' => 'Mustika Jaya',
            'kel' => 'Cimuning',
            'harga_ongkir' => 5000,
            'kodepos' => $faker->numberBetween(10000, 99999),
            'detail' => '',
        ]);

        Alamat::create([
            'id_user' => 6,
            'kab_kota' => 'Kota Bekasi',
            'kec' => 'Pondok Gede',
            'kel' => 'Jatimakmur',
            'harga_ongkir' => 5000,
            'kodepos' => $faker->numberBetween(10000, 99999),
            'detail' => 'Depan Indomaret',
        ]);

        Alamat::create([
            'id_user' => 7,
            'kab_kota' => 'Kota Bekasi',
            'kec' => 'Jatiasih',
            'kel' => 'Jatiluhur',
            'harga_ongkir' => 5000,
            'kodepos' => $faker->numberBetween(10000, 99999),
            'detail' => 'Pinggir Waduk',
        ]);

        Alamat::create([
            'id_user' => 4,
            'kab_kota' => 'Kota Bekasi',
            'kec' => 'Bantar Gebang',
            'kel' => 'Bantargebang',
            'harga_ongkir' => 10000,
            'kodepos' => $faker->numberBetween(10000, 99999),
            'detail' => 'Gunung Bantargebang',
        ]);
    }
}
