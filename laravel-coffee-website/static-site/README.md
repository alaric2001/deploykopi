# DeployKopi - Static Frontend

Versi static (HTML + Tailwind + AlpineJS + JSON) dari aplikasi DeployKopi.
Siap deploy ke **GitHub Pages**, **Vercel**, atau static host manapun.

## Quick Start

```bash
cd static-site
npm install
npm run dev       # buka http://localhost:5173/index.html
npm run build     # output ke dist/
npm run preview   # preview build
```

## Struktur

```
static-site/
├── index.html              # Katalog kopi (entry)
├── detail.html             # Detail kopi  (?id=...)
├── cart.html                # Keranjang (LocalStorage)
├── checkout.html            # Checkout (simulasi, simpan ke history LS)
├── history.html             # Riwayat transaksi
├── history-detail.html
├── profile.html
├── alamat.html
├── login.html               # Pilih peran (mock auth: user/admin/pemilik)
├── 404.html
├── admin/
│   ├── dashboard.html       # Chart (Chart.js dynamic import)
│   ├── menu-kopi.html
│   ├── jenis-kopi.html
│   ├── raw-jenis-kopi.html
│   ├── ingredient.html
│   ├── raw-ingredient.html
│   ├── order.html
│   ├── order-detail.html
│   ├── payment-method.html
│   └── users.html           # Pemilik only
├── data/                    # JSON statis (eks seeder)
├── public/                  # Aset publik (di-copy ke dist as-is)
│   ├── images/              # Foto kopi (eks public/images Laravel)
│   ├── manifest.json        # PWA
│   ├── sw.js                # Service worker
│   └── .nojekyll
├── src/
│   ├── css/main.css         # Tailwind entry + komponen
│   └── js/
│       ├── main.js          # Entry Vite (Alpine init, SW register)
│       ├── store.js         # Alpine stores: data, auth, cart, history
│       ├── layout.js        # Render nav/sidebar via JS
│       └── util.js          # Helpers: asset(), formatRupiah(), dll
├── tailwind.config.js
├── postcss.config.js
├── vite.config.js           # MPA, base = /<nama-repo>/ via env
└── package.json
```

## Catatan Fitur Mock

| Fitur               | Implementasi static                                           |
|---------------------|---------------------------------------------------------------|
| Login/Register      | Tombol "Pilih Peran" di `login.html`, disimpan di LocalStorage |
| Cart                | Alpine store + LocalStorage (`deploykopi.cart`)                |
| Checkout            | Simulasi (tidak ada server/Midtrans); transaksi disimpan di `deploykopi.history` |
| Bukti pembayaran    | Disimpan sebagai base64 di LocalStorage                        |
| Admin CRUD          | Read-only — tombol tambah/edit menampilkan alert               |
| Dashboard analytics | Chart.js dari data demo + history LocalStorage                 |
| PWA                 | `manifest.json` + `sw.js` (cache-first dengan offline fallback)|

## Deploy ke GitHub Pages

Workflow `.github/workflows/deploy.yml` sudah disiapkan di root repo.
Cara aktifkan:

1. Buka **Settings → Pages → Source: GitHub Actions**
2. Push ke branch `main` atau `dev-porto`
3. Site live di `https://<user>.github.io/<nama-repo>/`

Kalau nama repo ≠ `laravel-coffee-website`, edit `DEPLOY_BASE` di workflow
atau set langsung di `vite.config.js`.

## Deploy ke Vercel

`vercel --prod` dari folder `static-site/`. Vite build otomatis terdeteksi.
Set Base ke `/` (root) di `vite.config.js` saat deploy ke Vercel.
