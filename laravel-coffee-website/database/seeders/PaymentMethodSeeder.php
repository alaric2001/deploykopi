<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::create([
            'jenis' => 'E-Wallet',
            'nama' => 'Gopay',
            'atas_nama' => 'Farhan H',
            'nomor' => '081384487598',
        ]);
    
        PaymentMethod::create([
            'jenis' => 'Qris',
            'nama' => 'Qris',
            'atas_nama' => 'Farhan',
            'foto' => 'qris-try.png',
        ]);
    }
}
