<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(KecamatanSeeder::class);
        $this->call(KelurahanSeeder::class);
        $this->call(AlamatSeeder::class);
        
        $this->call(KopiTableSeeder::class);
        // $this->call(RasaKopiTableSeeder::class);
        $this->call(RawIngredientSeeder::class);
        $this->call(RawJenisKopiSeeder::class);
        $this->call(JenisKopiSeeder::class);
        $this->call(TransaksiSeeder::class);
        $this->call(CartSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(IngredientSeeder::class);
        
        
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
