<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        User::create([
            'name_user' => 'Banghan',
            'role' => 'pemilik',
            'password' => Hash::make('123'), // Ganti dengan password yang diinginkan
            // 'username' => 'admin banghan',
            'user_jenis_kelamin' => 'Laki-Laki',
            'user_foto' => 'pakbos1.jpg',
            // 'user_status' => 1,
            // 'alamat' => 'RT.006/RW.038, Bojong Rawalumbu, Kec. Rawalumbu, Kota Bks, Jawa Barat 17116',
            'no_hp' => '08'.$faker->numberBetween(1000000000, 9999999999),
            'email' => 'banghan@mail.com',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name_user' => 'Seeder',
            'role' => 'admin',
            'password' => Hash::make('123'), // Ganti dengan password yang diinginkan
            'user_jenis_kelamin' => 'Laki-Laki',
            'user_foto' => 'paran.jpg',
            // 'alamat' => 'Indonesia',
            'no_hp' => '08'.$faker->numberBetween(1000000000, 9999999999),
            'email' => 'seeder@mail.com',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name_user' => 'Parel F',
            'role' => 'user',
            'password' => Hash::make('123'), // Ganti dengan password yang diinginkan
            // 'username' => 'admin banghan',
            'user_jenis_kelamin' => 'Laki-Laki',
            'user_foto' => 'rel.jpg',
            // 'user_status' => 1,
            // 'alamat' => 'Serang, Kec. Serang, Kota Serang, Banten',
            'no_hp' => '08'.$faker->numberBetween(1000000000, 9999999999),
            'email' => 'rel@mail.com',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name_user' => 'Paran H',
            'role' => 'user',
            'password' => Hash::make('123'), // Ganti dengan password yang diinginkan
            // 'username' => 'admin banghan',
            'user_jenis_kelamin' => 'Laki-Laki',
            'user_foto' => 'paran.jpg',
            // 'user_status' => 1,
            // 'alamat' => 'RT.006/RW.038, Bojong Rawalumbu, Kec. Rawalumbu, Kota Bekasi, Jawa Barat 17116',
            'no_hp' => '08'.$faker->numberBetween(1000000000, 9999999999),
            'email' => 'paran@mail.com',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name_user' => 'Bede',
            'role' => 'user',
            'password' => Hash::make('123'), // Ganti dengan password yang diinginkan
            // 'username' => 'admin banghan',
            'user_jenis_kelamin' => 'Laki-Laki',
            'user_foto' => 'paran.jpg',
            // 'user_status' => 1,
            // 'alamat' => 'Jagakarsa',
            'no_hp' => '08'.$faker->numberBetween(1000000000, 9999999999),
            'email' => 'bede@mail.com',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name_user' => 'Angga',
            'role' => 'user',
            'password' => Hash::make('123'), // Ganti dengan password yang diinginkan
            // 'username' => 'admin banghan',
            'user_jenis_kelamin' => 'Laki-Laki',
            'user_foto' => 'paran.jpg',
            // 'user_status' => 1,
            // 'alamat' => 'Citayam',
            'no_hp' => '08'.$faker->numberBetween(1000000000, 9999999999),
            'email' => 'angga@mail.com',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name_user' => 'Al-Aric',
            'role' => 'user',
            'password' => Hash::make('123'), // Ganti dengan password yang diinginkan
            // 'username' => 'admin banghan',
            'user_jenis_kelamin' => 'Laki-Laki',
            'user_foto' => 'paran.jpg',
            // 'user_status' => 1,
            // 'alamat' => 'Bojong Gede',
            'no_hp' => '08'.$faker->numberBetween(1000000000, 9999999999),
            'email' => 'al@mail.com',
            'email_verified_at' => now(),
        ]);
    }
}
