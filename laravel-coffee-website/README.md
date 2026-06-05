<div align="center">

# ☕ Seteguk Kopi

**Full-stack coffee shop e-commerce — Laravel backend + static frontend deployed to GitHub Pages**

[![Deploy Static Site](https://github.com/alaric2001/deploykopi/actions/workflows/deploy.yml/badge.svg)](https://github.com/alaric2001/deploykopi/actions/workflows/deploy.yml)
[![Live Demo](https://img.shields.io/badge/Live%20Demo-GitHub%20Pages-blue?logo=github)](https://alaric2001.github.io/deploykopi/)
[![Laravel](https://img.shields.io/badge/Laravel-11-red?logo=laravel)](https://laravel.com)
[![Vite](https://img.shields.io/badge/Vite-5-646CFF?logo=vite)](https://vitejs.dev)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3-77C1D2?logo=alpine.js)](https://alpinejs.dev)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3-06B6D4?logo=tailwindcss)](https://tailwindcss.com)

[Live Demo](https://alaric2001.github.io/deploykopi/) · [Laravel App](#laravel-app) · [Static Site](#static-site)

</div>

---

## Tentang Proyek

DeployKopi adalah aplikasi e-commerce kedai kopi yang dibangun dengan **dua codebase paralel** — satu backend penuh berbasis Laravel, dan satu frontend statis yang berjalan 100% di browser tanpa server.

Proyek ini menunjukkan kemampuan membangun sistem e-commerce end-to-end: dari desain database relasional, sistem autentikasi berbasis role, alur transaksi dengan pembayaran manual (QRIS & transfer bank), hingga otomasi deployment ke GitHub Pages via CI/CD.

---

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | PHP 8, Laravel 11, Eloquent ORM |
| Frontend (static) | Alpine.js 3, Tailwind CSS 3, Vite 5 |
| Database | MySQL |
| CI/CD | GitHub Actions |
| Hosting | GitHub Pages |

---

## Fitur Utama

### Untuk Pelanggan
- Browsing menu kopi dengan filter dan detail produk
- Keranjang belanja persisten (LocalStorage)
- Checkout dengan pilihan alamat pengiriman
- Pembayaran manual via QRIS & transfer bank
- Upload bukti pembayaran (dengan kompresi gambar via Canvas API)
- Riwayat transaksi dan detail order

### Untuk Admin & Pemilik
- Dashboard analitik dengan **Chart.js** (stok, penjualan, order per hari)
- Manajemen menu kopi + varian (jenis/ukuran)
- Manajemen bahan baku & stok ingredient
- Manajemen order dan konfirmasi pembayaran
- Manajemen metode pembayaran
- Manajemen pengguna (khusus role `pemilik`)

### Sistem Role
| Role | Akses |
|---|---|
| `user` | Katalog, cart, checkout, riwayat |
| `admin` | Semua menu manajemen produk & order |
| `pemilik` | Semua admin + dashboard analitik + manajemen user |

---

## Arsitektur: Dua Codebase Paralel

```
deploykopi/
├── .github/workflows/deploy.yml   ← CI/CD otomatis ke GitHub Pages
└── laravel-coffee-website/
    ├── static-site/               ← Frontend statis (GitHub Pages)
    └── ... (Laravel app)          ← Backend penuh (PHP + MySQL)
```

Pendekatan ini memisahkan **demo portofolio** (berjalan di browser saja) dari **aplikasi produksi** (butuh server PHP + MySQL). Static site menggunakan data JSON statis dan mock auth via LocalStorage sebagai pengganti database.

---

## Static Site

> **Live:** [alaric2001.github.io/deploykopi](https://alaric2001.github.io/deploykopi/)

Frontend statis dibangun dengan Vite sebagai bundler, Alpine.js untuk reaktivitas, dan Tailwind CSS untuk styling. Tidak butuh server — berjalan sepenuhnya di browser.

### Cara Menjalankan Lokal

```bash
cd laravel-coffee-website/static-site
npm install
npm run dev      # http://localhost:5174/
```

### Halaman yang Tersedia

| Halaman | Path |
|---|---|
| Katalog menu | `/` |
| Detail produk | `/detail.html` |
| Keranjang | `/cart.html` |
| Checkout | `/checkout.html` |
| Riwayat order | `/history.html` |
| Profil & alamat | `/profile.html` |
| Login (mock) | `/login.html` |
| Admin dashboard | `/admin/dashboard.html` |
| Admin menu & stok | `/admin/menu-kopi.html` |
| Admin order | `/admin/order.html` |

### Akun Demo

| Role | Email | Password |
|---|---|---|
| User | user@demo.com | (klik tombol login) |
| Admin | admin@demo.com | (klik tombol login) |
| Pemilik | pemilik@demo.com | (klik tombol login) |

### CI/CD ke GitHub Pages

Deploy otomatis berjalan setiap push ke `main` atau `dev-porto`:

```yaml
# .github/workflows/deploy.yml (ringkasan)
on:
  push:
    branches: [main, dev-porto]
  workflow_dispatch:              # bisa trigger manual dari GitHub UI

jobs:
  build → deploy                 # dua job dengan dependency
```

**Fitur CI/CD yang diimplementasikan:**
- OIDC token authentication (tanpa menyimpan secret manual)
- npm dependency caching untuk build lebih cepat
- Dynamic base URL via environment variable (`DEPLOY_BASE`)
- Concurrency control untuk mencegah deploy tumpang tindih
- GitHub Environments dengan deployment URL otomatis

---

## Laravel App

Backend penuh dengan autentikasi session, middleware berbasis role, dan sistem pembayaran manual.

### Cara Menjalankan Lokal

```bash
composer install
php artisan key:generate

# Konfigurasi .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=7000
DB_DATABASE=laravel-coffee-website

php artisan migrate:fresh --seed
php artisan serve        # terminal 1
npm run dev              # terminal 2
```

### Relasi Database

```
Kopi ──< JenisKopi (varian/ukuran)
Kopi ──< Ingredient >── RawIngredient (bahan baku)
JenisKopi >── RawJenisKopi (stok per varian)
Transaksi ──< Cart >── Kopi, JenisKopi
Transaksi >── Alamat
User ──< Alamat
User ──< Transaksi
```

### Alur Pembelian

```
Pilih kopi → Tambah ke cart → Pilih alamat → Buat order → Pilih metode bayar (QRIS/Transfer) → Upload bukti → Konfirmasi admin
```

---

## Highlights Teknis

- **Reactive state management** dengan Alpine.js stores (tanpa Vue/React)
- **Image compression** sebelum simpan ke LocalStorage — mencegah `QuotaExceededError`
- **Parallel data fetching** via `Promise.all` untuk 8 JSON sekaligus
- **Dynamic base URL** — satu config Vite untuk lokal (`/`) dan GitHub Pages (`/deploykopi/`)
- **Multi-page app** dengan Rollup multi-entry (bukan SPA, tapi tetap di-bundle Vite)
- **Role-based access control** di Laravel via custom middleware
- **Pembayaran manual** via QRIS & transfer bank dengan konfirmasi admin

---

## Struktur Folder Static Site

```
static-site/
├── src/
│   ├── js/
│   │   ├── main.js       ← entry point, Alpine init
│   │   ├── store.js      ← Alpine stores (data, auth, cart, history)
│   │   ├── layout.js     ← navbar & sidebar injection
│   │   └── util.js       ← helper global (asset, formatRupiah, dll)
│   └── css/
├── public/
│   └── data/             ← JSON statis (pengganti database)
│       ├── kopi.json
│       ├── users.json
│       ├── transaksi_demo.json
│       └── ...
├── admin/                ← halaman admin
├── vite.config.js
└── tailwind.config.js
```

---

<div align="center">

Dibuat oleh [Alaric](https://github.com/alaric2001) · 2024

</div>
