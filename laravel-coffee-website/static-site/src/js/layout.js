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

export function mountDocButton() {
  const wrap = document.createElement('div');
  wrap.innerHTML = `
<div x-data="{
  open: false,
  docs: null,
  async init() {
    try {
      const res = await fetch(asset('data/docs.json'));
      this.docs = await res.json();
    } catch(e) { console.warn('docs.json gagal dimuat', e); }
  }
}" @keydown.escape.window="open = false">

  <!-- Floating trigger button -->
  <button
    @click="open = true"
    title="Dokumentasi Projek"
    class="fixed bottom-6 right-6 z-[9990] flex items-center gap-2 bg-secondary text-primary pl-3 pr-4 py-2.5 rounded-full shadow-xl hover:bg-secondary_hover active:scale-95 transition-all duration-200 text-sm font-semibold"
  >
    <span class="material-icons text-[18px]">menu_book</span>
    Dokumentasi Projek
  </button>

  <!-- Overlay -->
  <div
    x-show="open"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black/60 z-[9991] flex items-center justify-center p-4"
    @click.self="open = false"
  >
    <!-- Modal card -->
    <div
      x-show="open"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-95"
      class="bg-white rounded-2xl w-full max-w-[640px] max-h-[88vh] overflow-y-auto shadow-2xl flex flex-col"
    >
      <!-- Sticky header -->
      <div class="sticky top-0 bg-secondary text-primary px-6 py-4 rounded-t-2xl flex items-start justify-between z-10">
        <div>
          <div class="flex items-center gap-2">
            <img src="${asset('images/logo_icon_black.png')}" class="w-7 invert opacity-90" alt="logo">
            <h2 class="text-base font-bold tracking-tight">Seteguk Kopi — Portofolio Project</h2>
          </div>
          <p class="text-xs opacity-70 mt-1 ml-9">Full Stack E-Commerce · Laravel + Static Deploy</p>
        </div>
        <button @click="open = false" class="material-icons opacity-60 hover:opacity-100 transition ml-4 mt-0.5 text-xl">close</button>
      </div>

      <!-- Body -->
      <div class="px-6 py-5 space-y-6 text-secondary">

        <!-- CTA Links -->
        <template x-if="docs">
          <div class="flex flex-wrap gap-2">
            <a :href="docs.github_repo" target="_blank" rel="noopener"
              class="inline-flex items-center gap-1.5 bg-gray-900 text-white text-xs font-semibold px-4 py-2 rounded-full hover:bg-gray-700 transition">
              <span class="material-icons text-[14px]">code</span>
              GitHub Repository
            </a>
            <a :href="docs.live_demo" target="_blank" rel="noopener"
              class="inline-flex items-center gap-1.5 bg-primary text-secondary text-xs font-semibold px-4 py-2 rounded-full border border-secondary hover:bg-primary_hover transition">
              <span class="material-icons text-[14px]">open_in_new</span>
              Live Demo
            </a>
          </div>
        </template>

        <!-- Demo note -->
        <div class="flex gap-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 text-xs text-amber-800">
          <span class="material-icons text-amber-500 text-base mt-0.5">info</span>
          <p>
            <span class="font-bold">Catatan Demo:</span> Halaman ini adalah versi
            <span class="font-semibold">static frontend</span> tanpa server.
            Klik <strong>Pilih Peran</strong> di navbar untuk login sebagai
            <em>User</em>, <em>Admin</em>, atau <em>Pemilik</em> dan jelajahi fiturnya.
          </p>
        </div>

        <!-- Tech Stack -->
        <section>
          <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">🛠 Tech Stack</h3>
          <template x-if="docs">
            <div class="flex flex-wrap gap-1.5">
              <template x-for="t in docs.tech_stack" :key="t.name">
                <span
                  class="text-xs font-semibold px-3 py-1 rounded-full"
                  :style="\`background:\${t.bg}; color:\${t.text}\`"
                  x-text="t.name"
                ></span>
              </template>
            </div>
          </template>
        </section>

        <!-- Divider -->
        <div class="h-px bg-gray-100"></div>

        <!-- Alur Pembelian -->
        <section>
          <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">🔄 Alur Pembelian</h3>
          <template x-if="docs">
            <ol class="space-y-3">
              <template x-for="(step, i) in docs.flow" :key="i">
                <li class="flex items-start gap-3">
                  <span class="flex-shrink-0 w-6 h-6 rounded-full bg-secondary text-primary text-[11px] font-bold flex items-center justify-center mt-0.5"
                    x-text="i + 1"></span>
                  <div>
                    <p class="text-sm font-semibold leading-tight" x-text="step.title"></p>
                    <p class="text-xs text-gray-500 mt-0.5" x-text="step.desc"></p>
                  </div>
                </li>
              </template>
            </ol>
          </template>
        </section>

        <!-- Divider -->
        <div class="h-px bg-gray-100"></div>

        <!-- Multi-Role -->
        <section>
          <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">👥 Sistem Multi-Role</h3>
          <template x-if="docs">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
              <template x-for="role in docs.roles" :key="role.label">
                <div
                  class="rounded-xl p-3.5 border"
                  :style="\`background:\${role.bg}; border-color:\${role.border}\`"
                >
                  <p class="text-sm font-bold mb-2">
                    <span x-text="role.emoji"></span>
                    <span x-text="' ' + role.label"></span>
                  </p>
                  <ul class="space-y-1">
                    <template x-for="f in role.features" :key="f">
                      <li class="text-[11px] text-gray-600 flex items-start gap-1">
                        <span class="text-gray-400 mt-px">›</span>
                        <span x-text="f"></span>
                      </li>
                    </template>
                  </ul>
                </div>
              </template>
            </div>
          </template>
        </section>

      </div>

      <!-- Footer -->
      <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
        <p class="text-[11px] text-gray-400">
          Made with ❤️ by
          <template x-if="docs">
            <a :href="'https://github.com/' + docs.author" target="_blank"
              class="font-semibold text-secondary hover:underline" x-text="docs.author"></a>
          </template>
        </p>
        <button @click="open = false"
          class="text-xs text-gray-400 hover:text-secondary transition flex items-center gap-1">
          <span class="material-icons text-[14px]">close</span>
          Tutup
        </button>
      </div>
    </div>
  </div>
</div>`;
  document.body.appendChild(wrap);
}
