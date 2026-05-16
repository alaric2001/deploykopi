import Alpine from 'alpinejs';
import { registerStores } from './store.js';
import { mountNavUser, mountSidebarAdmin, mountDocButton } from './layout.js';
import { asset, formatRupiah, formatTanggal, hargaFinal, isOutOfStock, qs } from './util.js';
import '../css/main.css';

// Helper global yang bisa dipakai dari atribut x-* Alpine
window.asset = asset;
window.formatRupiah = formatRupiah;
window.formatTanggal = formatTanggal;
window.hargaFinal = hargaFinal;
window.isOutOfStock = isOutOfStock;
window.qs = qs;

// Layout helpers
window.mountNavUser = mountNavUser;
window.mountSidebarAdmin = mountSidebarAdmin;

mountDocButton(); // inject sebelum Alpine.start() agar Alpine scan sekaligus

registerStores(Alpine);

window.Alpine = Alpine;
Alpine.start();

// alpine:initialized sudah dipanggil synchronous di dalam Alpine.start(),
// jadi langsung load di sini — jangan pakai addEventListener.
Alpine.store('data').load();

// Register service worker (PWA)
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    const swPath = (import.meta.env.BASE_URL || '/') + 'sw.js';
    navigator.serviceWorker.register(swPath).catch((err) => {
      console.warn('SW gagal didaftarkan:', err);
    });
  });
}
