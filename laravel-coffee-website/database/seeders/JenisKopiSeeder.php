<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\JenisKopi;

class JenisKopiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisKopi::create([
            'kopi_id' => 1,
            'id_rawjeniskopi' => 1,
            'nama_jenis' => 'Robusta',
            'ready' => 2
        ]);

        JenisKopi::create([
            'kopi_id' => 1,
            'id_rawjeniskopi' => 2,
            'nama_jenis' => 'Arabica',
            'ready' => 2
        ]);

        $faker = Faker::create();
        // Asumsikan Anda memiliki 6 kopi_id yang berbeda (1 hingga 6)
        for ($kopiId = 2; $kopiId <= 6; $kopiId++) {
            JenisKopi::create([
                'kopi_id' => $kopiId,
                'id_rawjeniskopi' => 1,
                'nama_jenis' => 'Robusta',
                // 'ready' => rand(1, 2)
            ]);

            JenisKopi::create([
                'kopi_id' => $kopiId,
                'id_rawjeniskopi' => 2,
                'nama_jenis' => 'Arabica',
                // 'ready' => rand(1, 2)
            ]);
        }
    }
}
