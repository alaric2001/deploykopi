import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig(({ mode }) => {
  // Dev: base '/' so localhost:5173/ works and HMR WebSocket connects correctly.
  // Build: use DEPLOY_BASE (set by CI for GitHub Pages) or fallback to repo name.
  const base = process.env.DEPLOY_BASE || (mode === 'development' ? '/' : '/laravel-coffee-website/');

  return {
    base,
    publicDir: 'public',
    build: {
      outDir: 'dist',
      emptyOutDir: true,
      rollupOptions: {
        input: {
          main: resolve(__dirname, 'index.html'),
          detail: resolve(__dirname, 'detail.html'),
          cart: resolve(__dirname, 'cart.html'),
          checkout: resolve(__dirname, 'checkout.html'),
          history: resolve(__dirname, 'history.html'),
          historyDetail: resolve(__dirname, 'history-detail.html'),
          profile: resolve(__dirname, 'profile.html'),
          alamat: resolve(__dirname, 'alamat.html'),
          login: resolve(__dirname, 'login.html'),
          notFound: resolve(__dirname, '404.html'),
          adminDashboard: resolve(__dirname, 'admin/dashboard.html'),
          adminMenu: resolve(__dirname, 'admin/menu-kopi.html'),
          adminJenis: resolve(__dirname, 'admin/jenis-kopi.html'),
          adminRawJenis: resolve(__dirname, 'admin/raw-jenis-kopi.html'),
          adminIngredient: resolve(__dirname, 'admin/ingredient.html'),
          adminRawIngredient: resolve(__dirname, 'admin/raw-ingredient.html'),
          adminOrder: resolve(__dirname, 'admin/order.html'),
          adminOrderDetail: resolve(__dirname, 'admin/order-detail.html'),
          adminPayment: resolve(__dirname, 'admin/payment-method.html'),
          adminUsers: resolve(__dirname, 'admin/users.html')
        }
      }
    },
    server: {
      port: 5174,
      open: true
    }
  };
});
