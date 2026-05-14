// Helper resolver untuk asset path. Saat dev/preview Vite, BASE_URL otomatis benar.
export const base = import.meta.env.BASE_URL || '/';

export const asset = (path) => {
  const clean = path.replace(/^\/+/, '');
  return base + clean;
};

export const formatRupiah = (n) => {
  if (n === null || n === undefined || isNaN(n)) return 'Rp. 0';
  return 'Rp. ' + Number(n).toLocaleString('id-ID');
};

export const formatTanggal = (iso) => {
  if (!iso) return '-';
  const d = new Date(iso);
  return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
};

export const hargaFinal = (kopi) => {
  if (!kopi) return 0;
  if (kopi.diskon > 0 && kopi.harga_diskon) return kopi.harga_diskon;
  if (kopi.diskon > 0) return Math.round(kopi.harga * (1 - kopi.diskon / 100));
  return kopi.harga;
};

export const isOutOfStock = (kopi) => {
  if (!kopi) return true;
  if (kopi.stok < 1) return true;
  if (kopi.ingredients?.some((i) => i.available === 2)) return true;
  if (kopi.jenis?.length > 0 && kopi.jenis.every((j) => j.ready === 2)) return true;
  return false;
};

export const qs = (key) => new URLSearchParams(window.location.search).get(key);
