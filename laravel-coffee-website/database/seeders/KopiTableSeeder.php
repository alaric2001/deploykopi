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
            'jenis_kopi' => 'Caramel',
            'foto' => 'kopi_caramel.jpg',
            'harga' => 15000,
            'diskon' => 0,
            'stok' => 45,
            'deskripsi' => 'Terbuat dari campuran espresso segar dan sirup karamel, minuman ini menawarkan perpaduan sempurna antara pahitnya kopi dan manisnya karamel.'
        ]);

        Kopi::create([
            'jenis_kopi' => 'Gula Aren',
            'foto' => 'kopi_gula-aren.jpg',
            'harga' => 12000,
            'diskon' => 50,
            'harga_diskon' => 6000,
            'stok' => 30,
            'deskripsi' => 'Gula aren memberikan sentuhan manis yang lembut dan karamel, berbeda dengan gula putih biasa, menambah dimensi rasa yang unik pada kopi.'
        ]);

        Kopi::create([
            'jenis_kopi' => 'Hazelnut',
            'foto' => 'kopi_hazelnut.jpg',
            'harga' => 17000,
            'diskon' => 10,
            'harga_diskon' => 15300,
            'stok' => 25,
            'deskripsi' => 'Minuman kopi yang memanjakan dengan aroma kacang hazelnut yang kaya dan rasa yang lembut.'
        ]);

        Kopi::create([
            'jenis_kopi' => 'Pandan',
            'foto' => 'kopi_pandan.jpg',
            'harga' => 12000,
            'diskon' => 0,
            'stok' => 0,
            'deskripsi' => 'Minuman kopi unik yang menggabungkan kelezatan kopi dengan aroma dan rasa khas daun pandan.'
        ]);

        Kopi::create([
            'jenis_kopi' => 'Vanilla',
            'foto' => 'kopi_vanilla.jpg',
            'harga' => 17000,
            'diskon' => 0,
            'stok' => 25,
            'deskripsi' => 'Terbuat dari campuran espresso berkualitas dan sirup vanila, minuman ini menawarkan keseimbangan sempurna antara kekuatan kopi dan kelembutan rasa vanila yang lembut dan aromatik.'
        ]);

        Kopi::create([
            'jenis_kopi' => 'Americano',
            'foto' => 'kopi_americano.jpg',
            'harga' => 15000,
            'diskon' => 0,
            'stok' => 45,
            'deskripsi' => 'minuman kopi yang terdiri dari espresso yang ditambahkan dengan air panas, menciptakan minuman yang lebih ringan dan lebih encer dibandingkan dengan espresso murni'
        ]);

        Kopi::create([
            'jenis_kopi' => 'Matcha Latte',
            'foto' => 'MatchaLatte.jpg',
            'harga' => 12000,
            'diskon' => 0,
            'stok' => 30,
            'deskripsi' => 'Minuman yang terbuat dari campuran bubuk matcha (teh hijau bubuk) dengan susu dan air panas. Matcha latte memiliki rasa yang unik dan menyegarkan, dengan kombinasi rasa ringan dan sedikit pahit dari matcha yang diselaraskan dengan manisnya susu.'
        ]);

        Kopi::create([
            'jenis_kopi' => 'Thai Tea',
            'foto' => 'ThaiTea.jpg',
            'harga' => 17000,
            'diskon' => 0,
            'stok' => 25,
            'deskripsi' => 'Minuman teh yang berasal dari Thailand dan populer di seluruh dunia. Minuman ini dikenal karena warnanya yang unik, yaitu oranye cerah, dan rasanya yang manis dengan sedikit rasa teh yang kuat.'
        ]);

        Kopi::create([
            'jenis_kopi' => 'Red Velvet',
            'foto' => 'RedVelvet.png',
            'harga' => 15000,
            'diskon' => 0,
            'stok' => 45,
            'deskripsi' => 'Terinspirasi dari kue Red Velvet. Minuman ini biasanya terdiri dari campuran berbagai bahan, termasuk susu, sirup vanila, pewarna merah (untuk memberikan warna merah yang khas).'
        ]);

        Kopi::create([
            'jenis_kopi' => 'Dark Choco',
            'foto' => 'dark_choco.jpg',
            'harga' => 13000,
            'diskon' => null,
            'stok' => 45,
            'deskripsi' => 'Dark choco, atau cokelat hitam, adalah jenis cokelat yang mengandung persentase kakao yang tinggi, biasanya antara 50-90%, dan sedikit atau tanpa tambahan susu.'
        ]);

    }
}
