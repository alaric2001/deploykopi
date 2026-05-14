import { asset } from './util.js';

const navUserHTML = () => `
<nav class="fixed w-full z-[9999] bg-primary shadow top-0">
  <div class="p-2 flex justify-between items-center max-w-6xl mx-auto">
    <a href="${asset('index.html')}" class="flex items-center gap-2">
      <img class="w-10" src="${asset('images/logo_icon_black.png')}" alt="logo">
      <p class="text-lg font-semibold">Seteguk Kopi</p>
    </a>
    <div class="flex items-center gap-2" x-data>
      <template x-if="!$store.auth.isLoggedIn">
        <a href="${asset('login.html')}" class="btn-primary">Pilih Peran</a>
      </template>
      <template x-if="$store.auth.isLoggedIn">
        <div class="flex items-center gap-3">
          <a href="${asset('cart.html')}" class="relative flex items-center">
            <span class="material-icons">shopping_cart</span>
            <span
              x-show="$store.cart.count > 0"
              x-text="$store.cart.count"
              class="absolute -top-1 -right-2 flex items-center justify-center text-[10px] h-4 font-semibold text-white min-w-[16px] bg-red-500 rounded-full px-1"
            ></span>
          </a>
          <div class="dropdown">
            <button class="flex items-center gap-2">
              <img class="h-9 w-9 object-cover rounded-full" :src="asset('images/' + ($store.auth.user?.user_foto || 'paran.jpg'))" alt="">
              <p class="hidden sm:block text-sm" x-text="'Hello, ' + ($store.auth.user?.name_user || '')"></p>
            </button>
            <div class="dropdown-content text-sm">
              <a href="${asset('profile.html')}">Profile</a>
              <a href="${asset('history.html')}">Riwayat</a>
              <template x-if="$store.auth.isAdmin">
                <a href="${asset('admin/dashboard.html')}">Panel Admin</a>
              </template>
              <button @click="$store.auth.logout(); location.href = '${asset('index.html')}'">Logout</button>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
</nav>`;

const sidebarAdminHTML = () => `
<aside class="w-[220px] h-screen bg-primary fixed top-0 left-0 overflow-y-auto z-50" x-data>
  <div class="flex items-center gap-2 p-2">
    <img class="w-14 pl-2" src="${asset('images/logo_icon_black.png')}" alt="logo">
    <p class="text-xl font-bold" x-text="$store.auth.user ? $store.auth.user.role.toUpperCase() : 'GUEST'"></p>
  </div>
  <div class="h-px bg-black my-1 mx-2"></div>

  <nav class="flex flex-col gap-1">
    <template x-if="$store.auth.isPemilik">
      <a class="sidebar-link" href="${asset('admin/dashboard.html')}">Dashboard</a>
    </template>
    <a class="sidebar-link" href="${asset('admin/order.html')}">Transaksi</a>
    <a class="sidebar-link" href="${asset('admin/menu-kopi.html')}">Menu Kopi</a>
    <a class="sidebar-link" href="${asset('admin/jenis-kopi.html')}">Jenis Kopi</a>
    <a class="sidebar-link" href="${asset('admin/raw-jenis-kopi.html')}">Stok Jenis Kopi</a>
    <a class="sidebar-link" href="${asset('admin/ingredient.html')}">Ingredient</a>
    <a class="sidebar-link" href="${asset('admin/raw-ingredient.html')}">Stok Ingredient</a>
    <a class="sidebar-link" href="${asset('admin/payment-method.html')}">Payment Method</a>
    <template x-if="$store.auth.isPemilik">
      <a class="sidebar-link" href="${asset('admin/users.html')}">Users</a>
    </template>

    <a href="${asset('index.html')}" class="mx-2 mt-4 btn-secondary text-center">Lihat Toko</a>
    <button
      class="m-2 btn-primary"
      @click="$store.auth.logout(); location.href = '${asset('index.html')}'"
    >Logout</button>
  </nav>
</aside>`;

export function mountNavUser(selector = '#nav-mount') {
  const el = document.querySelector(selector);
  if (el) el.innerHTML = navUserHTML();
}

export function mountSidebarAdmin(selector = '#sidebar-mount') {
  const el = document.querySelector(selector);
  if (el) el.innerHTML = sidebarAdminHTML();
}
