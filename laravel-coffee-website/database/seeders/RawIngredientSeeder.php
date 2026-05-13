<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\RawIngredient;

class RawIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RawIngredient::create([
            'nama' => 'Gula',
            'stok' => 40,
        ]);
        RawIngredient::create([
            'nama' => 'Susu',
            'stok' => 17,
        ]);
        RawIngredient::create([
            'nama' => 'Krimer',
            'stok' => 25,
        ]);
        RawIngredient::create([
            'nama' => 'Kopi',
            'stok' => 50,
        ]);
        RawIngredient::create([
            'nama' => 'Air Mineral',
            'stok' => 30,
        ]);
        RawIngredient::create([
            'nama' => 'Rasa Caramel', 
            'stok' => 44,
        ]);
        RawIngredient::create([
            'nama' => 'Rasa Gula Aren', 
            'stok' => 11,
        ]);
        RawIngredient::create([
            'nama' => 'Rasa Hazelnut',
            'stok' => 19,
        ]);
        RawIngredient::create([
            'nama' =>  'Rasa Pandan', 
            'stok' => 37,
        ]);
        RawIngredient::create([
            'nama' => 'Rasa Vanilla',
            'stok' => 22,
        ]);
    }
}
