import { asset } from './util.js';

const LS_KEYS = {
  auth: 'deploykopi.auth',
  cart: 'deploykopi.cart',
  history: 'deploykopi.history'
};

const DATA_FILES = {
  kopi: 'data/kopi.json',
  rawJenisKopi: 'data/raw_jenis_kopi.json',
  rawIngredients: 'data/raw_ingredients.json',
  alamat: 'data/alamat.json',
  kecamatan: 'data/kecamatan.json',
  paymentMethods: 'data/payment_methods.json',
  users: 'data/users.json',
  transaksiDemo: 'data/transaksi_demo.json'
};

const loadJSON = async (path) => {
  const res = await fetch(asset(path));
  if (!res.ok) throw new Error(`Gagal memuat ${path}`);
  return res.json();
};

const readLS = (key, fallback) => {
  try {
    const raw = localStorage.getItem(key);
    return raw ? JSON.parse(raw) : fallback;
  } catch {
    return fallback;
  }
};

const writeLS = (key, value) => {
  localStorage.setItem(key, JSON.stringify(value));
};

export function registerStores(Alpine) {
  // ===== DATA STORE =====
  Alpine.store('data', {
    loaded: false,
    kopi: [],
    rawJenisKopi: [],
    rawIngredients: [],
    alamat: [],
    kecamatan: [],
    paymentMethods: [],
    users: [],
    transaksiDemo: [],

    async load() {
      if (this.loaded) return;
      try {
        const [kopi, rjk, ri, alamat, kec, pm, users, td] = await Promise.all([
          loadJSON(DATA_FILES.kopi),
          loadJSON(DATA_FILES.rawJenisKopi),
          loadJSON(DATA_FILES.rawIngredients),
          loadJSON(DATA_FILES.alamat),
          loadJSON(DATA_FILES.kecamatan),
          loadJSON(DATA_FILES.paymentMethods),
          loadJSON(DATA_FILES.users),
          loadJSON(DATA_FILES.transaksiDemo)
        ]);
        this.kopi = kopi;
        this.rawJenisKopi = rjk;
        this.rawIngredients = ri;
        this.alamat = alamat;
        this.kecamatan = kec;
        this.paymentMethods = pm;
        this.users = users;
        this.transaksiDemo = td;
      } catch (err) {
        console.error('Gagal memuat data:', err);
      } finally {
        this.loaded = true;
      }
    },

    kopiById(id) {
      return this.kopi.find((k) => k.id === Number(id));
    },

    alamatById(id) {
      return this.alamat.find((a) => a.id === Number(id));
    },

    uniquePaymentJenis() {
      const seen = new Set();
      return this.paymentMethods.filter((p) => {
        if (seen.has(p.jenis)) return false;
        seen.add(p.jenis);
        return true;
      });
    }
  });

  // ===== AUTH STORE (mock, LocalStorage) =====
  Alpine.store('auth', {
    user: readLS(LS_KEYS.auth, null),

    get isLoggedIn() {
      return !!this.user;
    },
    get isAdmin() {
      return this.user?.role === 'admin' || this.user?.role === 'pemilik';
    },
    get isPemilik() {
      return this.user?.role === 'pemilik';
    },
    get isUser() {
      return this.user?.role === 'user';
    },

    loginAs(role) {
      const users = Alpine.store('data').users;
      const target = users.find((u) => u.role === role) || users.find((u) => u.role === 'user');
      if (!target) return;
      this.user = { ...target };
      writeLS(LS_KEYS.auth, this.user);
    },

    loginUser(user) {
      this.user = { ...user };
      writeLS(LS_KEYS.auth, this.user);
    },

    updateProfile(patch) {
      if (!this.user) return;
      this.user = { ...this.user, ...patch };
      writeLS(LS_KEYS.auth, this.user);
    },

    logout() {
      this.user = null;
      localStorage.removeItem(LS_KEYS.auth);
    }
  });

  // ===== CART STORE =====
  Alpine.store('cart', {
    items: readLS(LS_KEYS.cart, []),

    get count() {
      return this.items.reduce((s, i) => s + i.quantity, 0);
    },

    get total() {
      return this.items.reduce((s, i) => s + i.subtotal, 0);
    },

    add({ kopi, jenisId = null, jenisNama = null, quantity = 1 }) {
      const harga = kopi.diskon > 0 && kopi.harga_diskon ? kopi.harga_diskon : kopi.harga;
      const existing = this.items.find(
        (i) => i.kopi_id === kopi.id && i.jenis_id === jenisId
      );
      if (existing) {
        existing.quantity += quantity;
        existing.subtotal = existing.quantity * existing.harga;
      } else {
        this.items.push({
          id: Date.now() + Math.random(),
          kopi_id: kopi.id,
          kopi_nama: kopi.jenis_kopi,
          foto: kopi.foto,
          jenis_id: jenisId,
          jenis_nama: jenisNama,
          quantity,
          harga,
          subtotal: harga * quantity
        });
      }
      this.persist();
    },

    setQuantity(itemId, qty) {
      const item = this.items.find((i) => i.id === itemId);
      if (!item) return;
      item.quantity = Math.max(1, qty);
      item.subtotal = item.quantity * item.harga;
      this.persist();
    },

    remove(itemId) {
      this.items = this.items.filter((i) => i.id !== itemId);
      this.persist();
    },

    clear() {
      this.items = [];
      this.persist();
    },

    persist() {
      writeLS(LS_KEYS.cart, this.items);
    }
  });

  // ===== HISTORY STORE (transaksi yang sudah checkout) =====
  Alpine.store('history', {
    items: readLS(LS_KEYS.history, []),

    get sorted() {
      return [...this.items].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
    },

    add(transaksi) {
      this.items.unshift(transaksi);
      this.persist();
    },

    findById(id) {
      return this.items.find((t) => String(t.id) === String(id));
    },

    persist() {
      writeLS(LS_KEYS.history, this.items);
    },

    clear() {
      this.items = [];
      this.persist();
    }
  });
}
