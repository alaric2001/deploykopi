# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Tentang Proyek

**DeployKopi** adalah aplikasi e-commerce kedai kopi dengan **dua codebase paralel**:

| | Laravel App | Static Site |
|---|---|---|
| Lokasi | root repo | `static-site/` |
| Runtime | PHP + MySQL | Browser only |
| Deploy | Server | GitHub Pages |
| Auth | Session + Middleware | Mock via LocalStorage |
| Data | MySQL via Eloquent | JSON statis di `public/data/` |

---

## Static Site (`static-site/`)

### Perintah

```bash
cd static-site
npm install
npm run dev      # http://localhost:5174/
npm run build    # output ke dist/
npm run preview  # preview hasil build
```

### Deploy ke GitHub Pages

Push ke branch `main` atau `dev-porto` — GitHub Actions (`.github/workflows/deploy.yml`) otomatis build dan deploy. Pastikan **Settings → Pages → Source: GitHub Actions** sudah diaktifkan di repo.

URL hasil deploy: `https://alaric2001.github.io/laravel-coffee-website/`

Env var `DEPLOY_BASE` di workflow mengontrol base path. Saat dev lokal, base otomatis `/`; saat build CI, base menjadi `/<nama-repo>/`.

### Arsitektur Static Site

**Entry point:** `src/js/main.js` — import Alpine, register semua store, expose helper ke `window`, panggil `Alpine.start()`, lalu langsung `Alpine.store('data').load()`.

> **Penting:** `alpine:initialized` di-dispatch **synchronous** di dalam `Alpine.start()`. Jangan pakai `addEventListener('alpine:initialized', ...)` — event sudah selesai saat listener dipasang. Selalu panggil `Alpine.store('data').load()` langsung setelah `Alpine.start()`.

**Alpine Stores (`src/js/store.js`):**

| Store | Isi | Persistensi |
|---|---|---|
| `data` | kopi, users, alamat, paymentMethods, transaksiDemo, rawJenisKopi, rawIngredients | — (fetch JSON tiap page load) |
| `auth` | user mock yang sedang login | LocalStorage `deploykopi.auth` |
| `cart` | item keranjang | LocalStorage `deploykopi.cart` |
| `history` | transaksi setelah checkout | LocalStorage `deploykopi.history` |

`data.load()` fetch 8 JSON dari `public/data/` secara paralel via `Promise.all`. Error ditangkap oleh try/catch — `loaded` tetap jadi `true` di `finally` agar halaman tidak stuck.

**Layout injection (`src/js/layout.js`):**
Navbar dan sidebar tidak di-include via HTML — di-render oleh `mountNavUser()` dan `mountSidebarAdmin()` yang di-inject ke `#nav-mount` / `#sidebar-mount`. Fungsi ini dipanggil dari `x-init` di setiap halaman. Keduanya di-expose sebagai `window.mountNavUser` / `window.mountSidebarAdmin`.

**Helper global (`src/js/util.js`):**
- `asset(path)` — prefix path dengan `import.meta.env.BASE_URL` (penting untuk GitHub Pages)
- `formatRupiah(n)` — format angka ke string Rupiah
- `hargaFinal(kopi)` — hitung harga setelah diskon
- `isOutOfStock(kopi)` — cek stok, ingredient, dan jenis kopi
- `qs(key)` — ambil query string dari URL

Semua helper di-expose ke `window` agar bisa dipanggil dari atribut `x-*` Alpine.

**Data JSON (`public/data/`):**
Data didenormalisasi untuk konsumsi langsung client-side. `kopi.json` sudah menyertakan array `jenis` dan `ingredients` per item — tidak perlu join. File JSON ini adalah pengganti seeder Laravel.

**Bukti pembayaran:**
Saat upload di `checkout.html`, gambar di-resize ke maks 600px dan di-compress ke JPEG 70% via Canvas API sebelum disimpan ke LocalStorage. Ini mencegah `QuotaExceededError` (limit LS ~5MB).

**Auth mock (`login.html`):**
`loginAndRedirect(role)` bersifat `async` — menunggu `data.load()` selesai sebelum memanggil `loginAs(role)`. Jika data belum loaded saat tombol diklik, login akan menunggu sebentar, bukan gagal diam-diam.

**Admin dashboard (`admin/dashboard.html`):**
Chart.js di-load via CDN (`cdn.jsdelivr.net`), bukan di-bundle Vite. `renderChart()` dipanggil setelah `$store.data.loaded`. Data chart (stok, penjualan per kopi, order per hari) dihitung dari `allOrders = [...transaksiDemo, ...history.items]`.

---

## Laravel App (root)

### Perintah

```bash
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve        # terminal 1
npm run dev              # terminal 2
./vendor/bin/pint        # format PHP
php artisan test
```

### Konfigurasi Environment

Database pakai **port 7000** (bukan 3306):
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=7000
DB_DATABASE=laravel-coffee-website
```

Midtrans:
```
MIDTRANS_MERCHANT_ID=
MIDTRANS_CLIENT_KEY=
MIDTRANS_SERVER_KEY=
```

### Sistem Peran

| Peran | Middleware | Akses |
|---|---|---|
| `user` | `UserMiddleware` | Katalog, keranjang, checkout, riwayat |
| `admin` | `Admin` | Manajemen produk, order, bahan baku |
| `pemilik` | `PemilikMiddleware` | Semua admin + dashboard analitik + manajemen user |

`GatewayController@door` mengarahkan pengguna ke halaman yang sesuai berdasarkan role setelah login.

### Alur Pembelian

1. Pilih kopi + varian (`tbl_kopi` + `tbl_jenis_kopi`)
2. Tambah ke cart (`tbl_cart`) — cart terhubung ke `transaksi_id`
3. Pilih alamat dari `tbl_alamat`
4. Order dibuat di `tbl_transaksi`, cart dikonversi ke item order
5. Checkout via Midtrans (`TransaksiController`, `config/midtrans.php`)

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

### Konvensi Database

- Tabel produk pakai prefix `tbl_` (`tbl_kopi`, `tbl_transaksi`, `tbl_cart`)
- Tabel Laravel standar tanpa prefix (`users`, `password_reset_tokens`)
- Kolom FK format campuran: `id_user`, `kopi_id`, `id_alamat`
- Semua model pakai `protected $guarded = []`. Tidak ada soft delete.

### Upload File

Foto (`tbl_kopi.foto`, foto profil, bukti bayar) disimpan ke `public/images/` via `public_path('images')` — bukan `Storage::disk('public')`. `php artisan storage:link` tidak diperlukan untuk fitur foto.

### Deprecated

`RasaKopi` (model, controller, migration, seeder, views) sudah tidak aktif dipakai. Jangan tambahkan logika baru yang bergantung padanya.
