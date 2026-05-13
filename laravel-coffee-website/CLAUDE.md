# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Tentang Proyek

**DeployKopi** adalah aplikasi e-commerce kedai kopi berbasis Laravel 10. Aplikasi ini mendukung tiga peran pengguna (user, admin, pemilik), manajemen produk kopi beserta variannya, keranjang belanja, checkout dengan integrasi Midtrans, dan dashboard analitik untuk pemilik.

## Perintah Pengembangan

### Setup Awal

```bash
composer install
php artisan key:generate
php artisan migrate:fresh --seed
```

### Menjalankan Aplikasi (dua terminal terpisah)

```bash
php artisan serve
npm run dev
```

### Build Frontend untuk Produksi

```bash
npm run build
```

### Linting & Formatting

```bash
./vendor/bin/pint          # Format kode PHP (Laravel Pint)
./vendor/bin/pint --test   # Cek format tanpa mengubah file
```

### Testing

```bash
php artisan test                            # Jalankan semua test
php artisan test --filter NamaTestClass     # Jalankan satu test class
php artisan test --filter nama_metode_test  # Jalankan satu metode test
./vendor/bin/phpunit tests/Feature/         # Jalankan Feature tests saja
```

### Perintah Artisan yang Sering Dipakai

```bash
php artisan migrate:fresh --seed   # Reset database dan isi ulang data
php artisan db:seed --class=NamaSeeder  # Jalankan seeder tertentu
php artisan storage:link           # Buat symlink untuk penyimpanan file
php artisan config:clear && php artisan cache:clear  # Bersihkan cache
```

## Konfigurasi Environment

Database menggunakan **port 7000** (bukan 3306 standar):

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=7000
DB_DATABASE=laravel-coffee-website
```

Payment gateway Midtrans membutuhkan konfigurasi di `.env`:

```
MIDTRANS_MERCHANT_ID=
MIDTRANS_CLIENT_KEY=
MIDTRANS_SERVER_KEY=
```

## Arsitektur & Struktur

### Sistem Peran (Role)

Tiga peran dikelola via field `role` pada tabel `users`, divalidasi oleh middleware:

| Peran     | Middleware          | Akses                                    |
|-----------|---------------------|------------------------------------------|
| `user`    | `UserMiddleware`    | Katalog, keranjang, checkout, riwayat    |
| `admin`   | `Admin`             | Manajemen produk, order, bahan baku      |
| `pemilik` | `PemilikMiddleware` | Semua akses admin + dashboard analitik + manajemen user |

`GatewayController@door` mengarahkan pengguna ke halaman yang sesuai berdasarkan perannya setelah login.

### Alur Pembelian

1. Pengguna memilih produk kopi dan variannya (`tbl_kopi` + `tbl_jenis_kopi`)
2. Item ditambahkan ke keranjang (`tbl_cart`) — cart bersifat sementara, terhubung ke `transaksi_id`
3. Pengguna memilih alamat pengiriman dari `tbl_alamat` (berbasis kecamatan/kelurahan)
4. Order dibuat di `tbl_transaksi`, cart dikonversi menjadi item order
5. Checkout diproses melalui Midtrans (`TransaksiController`, `config/midtrans.php`)

### Relasi Model Utama

```
Kopi ──< JenisKopi (varian/ukuran)
Kopi ──< Ingredient >── RawIngredient (bahan baku)
JenisKopi >── RawJenisKopi (stok bahan varian)
Transaksi ──< Cart >── Kopi, JenisKopi
Transaksi >── Alamat
User ──< Alamat
User ──< Transaksi (via Cart)
```

### Konvensi Penamaan Database

- Tabel produk menggunakan prefix `tbl_` (contoh: `tbl_kopi`, `tbl_transaksi`, `tbl_cart`)
- Tabel bawaan Laravel tidak menggunakan prefix (`users`, `password_reset_tokens`)
- Kolom ID relasi menggunakan format campuran: `id_user`, `kopi_id`, `id_alamat`

### Model

Semua model menggunakan `protected $guarded = []` (mass assignment terbuka). Tidak ada soft delete — semua penghapusan bersifat permanen.

### Upload File

Foto produk kopi (`tbl_kopi.foto`) dan foto profil pengguna disimpan via `Storage::disk('public')`. Jalankan `php artisan storage:link` setelah setup awal.

### PWA

Aplikasi mendukung PWA via package `ladumor/laravel-pwa`. File service worker dan manifest ada di `public/sw.js` dan `public/manifest.json`.

## Stack Frontend

- **TailwindCSS** — styling utama
- **AlpineJS** — interaktivitas komponen (dropdown, toggle)
- **Vite** — bundler, dikonfigurasi di `vite.config.js`
- CSS kustom tambahan ada di `public/css/` (bukan di `resources/`)

## Kode yang Sudah Tidak Dipakai (Deprecated)

`RasaKopi` (model, controller, migration, seeder, views) adalah fitur lama yang sudah tidak digunakan secara aktif. Hindari menambahkan logika baru yang bergantung padanya.
