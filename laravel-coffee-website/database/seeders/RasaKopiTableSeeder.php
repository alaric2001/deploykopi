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

        // Tambahkan data kopi
        RasaKopi::create([ 
            'kopi_id' => 1,
            'nama_rasa' => 'Gula Aren',            
            // 'stock' => 7,
        ]);

        RasaKopi::create([ 
            'kopi_id' => 2,
            'nama_rasa' => 'Cocopandan',            
            // 'stock' => 13,
        ]);

        RasaKopi::create([ 
            'kopi_id' => 3,
            'nama_rasa' => 'Caramel',            
            // 'stock' => 5,
        ]);

        RasaKopi::create([ 
            'kopi_id' => 4,
            'nama_rasa' => 'Vanilla',            
            // 'stock' => 10,
        ]);


        $faker = Faker::create();
        for ($i = 0; $i < 11; $i++) {
            RasaKopi::create([ 
                'kopi_id' => rand(1, 4),
                'nama_rasa' => $faker->randomElement(['Vanila', 'Cocopandan', 'Caramel', 'Gula Aren']), 
            ]);
        }
    }
}
