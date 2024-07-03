<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kopi;

class KopiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data tabel sebelum menambahkan data
        // Kopi::truncate();

        // Tambahkan data kopi
        Kopi::create([
            'jenis_kopi' => 'Arabika',
            'foto' => 'Arabica.jpg',
            'harga' => 15000,
            'stok' => 45,
            'deskripsi' => 'Biji kopi arabika memiliki ciri-ciri ukuran biji yang lebih kecil dibandingkan biji kopi jenis robusta, selain itu, kandungannya kafeinnya lebih rendah, rasa dan aromanya juga lebih nikmat.'
        ]);

        Kopi::create([
            'jenis_kopi' => 'Robusta',
            'foto' => 'Robusta.jpg',
            'harga' => 12000,
            'stok' => 30,
            'deskripsi' => 'Biji kopi robusta berbentuk agak bulat, melengkung, dan lebih tebal jika dibandingkan kopi arabika. Kopi robusta memiliki warna yang kuat dan lebih kental ketika dibuat kopi.'
        ]);

        Kopi::create([
            'jenis_kopi' => 'Liberika atau Exelsa',
            'foto' => 'logo1.png',
            'harga' => 17000,
            'stok' => 25,
            'deskripsi' => 'Biji kopi liberika berbentuk seperti biji buah kurma, agak lonjong dan berukuran lebih besar. Kopi ini memiliki karakteristik rasa yang sedikit asam dan mirip seperti buah.'
        ]);

        Kopi::create([
            'jenis_kopi' => 'Matcha Latte',
            'foto' => 'MatchaLatte.jpg',
            'harga' => 12000,
            'stok' => 30,
            'deskripsi' => 'Minuman yang terbuat dari campuran bubuk matcha (teh hijau bubuk) dengan susu dan air panas. Matcha latte memiliki rasa yang unik dan menyegarkan, dengan kombinasi rasa ringan dan sedikit pahit dari matcha yang diselaraskan dengan manisnya susu.'
        ]);

        Kopi::create([
            'jenis_kopi' => 'Thai Tea',
            'foto' => 'ThaiTea.jpg',
            'harga' => 17000,
            'stok' => 25,
            'deskripsi' => 'Minuman teh yang berasal dari Thailand dan populer di seluruh dunia. Minuman ini dikenal karena warnanya yang unik, yaitu oranye cerah, dan rasanya yang manis dengan sedikit rasa teh yang kuat.'
        ]);

        Kopi::create([
            'jenis_kopi' => 'Red Velvet',
            'foto' => 'RedVelvet.png',
            'harga' => 15000,
            'stok' => 45,
            'deskripsi' => 'Terinspirasi dari kue Red Velvet. Minuman ini biasanya terdiri dari campuran berbagai bahan, termasuk susu, sirup vanila, pewarna merah (untuk memberikan warna merah yang khas).'
        ]);
    }
}
