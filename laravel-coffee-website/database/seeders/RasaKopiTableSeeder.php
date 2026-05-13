<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\RasaKopi;

class RasaKopiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data tabel sebelum menambahkan data
        // RasaKopi::truncate();
        $faker = Faker::create();
        // Asumsikan Anda memiliki 6 kopi_id yang berbeda (1 hingga 6)
        for ($kopiId = 1; $kopiId <= 5; $kopiId++) {
            RasaKopi::create([
                'kopi_id' => $kopiId,
                'nama_rasa' => 'Robusta',
            ]);

            RasaKopi::create([
                'kopi_id' => $kopiId,
                'nama_rasa' => 'Arabica',
            ]);
        }

        // Tambahkan data kopi
        // RasaKopi::create([ 
        //     'kopi_id' => 1,
        //     'nama_rasa' => 'Robusta',            
        //     // 'stock' => 7,
        // ]);

        // RasaKopi::create([ 
        //     'kopi_id' => 2,
        //     'nama_rasa' => 'Arabica',            
        //     // 'stock' => 13,
        // ]);

        // for ($i = 0; $i < 7; $i++) {
        //     RasaKopi::create([ 
        //         'kopi_id' => rand(1, 6),
        //         'nama_rasa' => $faker->randomElement(['Robusta', 'Arabica']), 
        //     ]);
        // }
    }
}
