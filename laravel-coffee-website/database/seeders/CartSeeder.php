<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cart;
use Faker\Factory as Faker;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 30; $i++) {
            Cart::create([
                'id_user' => rand(1, 4), // Sesuaikan dengan jumlah data users yang ada
                'kopi_id' => $faker->numberBetween(1, 5), // Sesuaikan dengan jumlah data kopi yang ada
                'transaksi_id' => rand(1, 30), // Sesuaikan dengan jumlah data transaksi yang ada
                'jenis_kopi_id' => rand(1, 2),
                'quantity' => $faker->numberBetween(1, 5),
                'jumlah' => $faker->numberBetween(10000, 20000),
                'created_at' => $faker->dateTimeThisMonth(),
            ]);
        }
    }
}
