<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($kopi_id = 1; $kopi_id <= 6; $kopi_id++) {
            Ingredient::create([
                'kopi_id' => $kopi_id,
                'rawingredient_id'=> 4,
                'nama_bahan' => 'Kopi',
                'available' => 1,
            ]);
        
        }
        
        $nama_bahanOLD = ['Caramel', 'Gula Aren', 'Hazelnut', 'Pandan', 'Vanilla','Matcha', 'Thai Tea', 'Red Velvet', 'Dark Choco'];
        $nama_bahan = [6,7,8,9,10];
        for ($kopi_id = 1; $kopi_id <= 5; $kopi_id++) {
            if ($kopi_id == 6) {
                continue; // Skip kopi_id 6
            }
            // Ambil bahan pertama dari array
            $bahan = array_shift($nama_bahan);
            $bahanOLD = array_shift($nama_bahanOLD);
            
            // Buat entri di tabel Ingredient
            Ingredient::create([
                'kopi_id' => $kopi_id,
                'nama_bahan' => $bahanOLD,
                'rawingredient_id'=> $bahan,
                'available' => 1,
            ]);
        }

        $nama_bahanOLD = ['Gula', 'Krimer', 'Susu'];
        $nama_bahan = [1, 3, 2];
        for ($kopi_id = 1; $kopi_id <= 10; $kopi_id++) {
            if ($kopi_id == 6) {
                continue; // Skip kopi_id 6
            }
            foreach ($nama_bahan as $bahan) {
                Ingredient::create([
                    'kopi_id' => $kopi_id,
                    'nama_bahan' => '',
                    'rawingredient_id'=> $bahan,
                    'available' => 1,
                ]);
            }
        }

        Ingredient::create([
            'kopi_id' => 6,
            'rawingredient_id'=> 5,
            'nama_bahan' => 'Air Mineral',
            'available' => 2
        ]);

        
        // for ($kopi_id = 1; $kopi_id <= 10; $kopi_id++) {
        //     if ($kopi_id == 6) {
        //         continue; // Skip kopi_id 6
        //     }
        //         Ingredient::create([
        //             'kopi_id' => $kopi_id,
        //             'nama_bahan' => 'Krimer',
        //             'available' => 1,
        //         ]);
            
        // }

        // for ($kopi_id = 1; $kopi_id <= 10; $kopi_id++) {
        //     if ($kopi_id == 6) {
        //         continue; // Skip kopi_id 6
        //     }
        //         Ingredient::create([
        //             'kopi_id' => $kopi_id,
        //             'nama_bahan' => 'Susu',
        //             'available' => 1,
        //         ]);
            
        // }

        
        // Ingredient::create([
        //     'kopi_id' => 1,
        //     'nama_bahan' => 'Susu',
        //     'available' => 2
        // ]);
        // Ingredient::create([
        //     'kopi_id' => 1,
        //     'nama_bahan' => 'Caramel',
        //     'available' => 2
        // ]);
        // Ingredient::create([
        //     'kopi_id' => 1,
        //     'nama_bahan' => 'Krimer',
        //     'available' => 2
        // ]);

        // Ingredient::create([
        //     'kopi_id' => 2,
        //     'nama_bahan' => 'Gula',
        //     'available' => 1
        // ]);
        // Ingredient::create([
        //     'kopi_id' => 2,
        //     'nama_bahan' => 'Susu',
        //     'available' => 1
        // ]);
        // Ingredient::create([
        //     'kopi_id' => 2,
        //     'nama_bahan' => 'Gula Aren',
        //     'available' => 1
        // ]);
        // Ingredient::create([
        //     'kopi_id' => 2,
        //     'nama_bahan' => 'Krimer',
        //     'available' => 1
        // ]);

        // Ingredient::create([
        //     'kopi_id' => 3,
        //     'nama_bahan' => 'Gula',
        //     'available' => 1
        // ]);
        // Ingredient::create([
        //     'kopi_id' => 3,
        //     'nama_bahan' => 'Susu',
        //     'available' => 1
        // ]);
        // Ingredient::create([
        //     'kopi_id' => 3,
        //     'nama_bahan' => 'Hazelnut',
        //     'available' => 1
        // ]);
        // Ingredient::create([
        //     'kopi_id' => 3,
        //     'nama_bahan' => 'Krimer',
        //     'available' => 1
        // ]);
    }
}
