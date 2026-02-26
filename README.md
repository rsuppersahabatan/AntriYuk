# 🎫 AntriYuk — Sistem Manajemen Antrian

<p align="center">
  <strong>Sistem antrian real-time berbasis web dengan WebSocket untuk layanan publik dan bisnis.</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS 4">
  <img src="https://img.shields.io/badge/Reverb-WebSocket-4F46E5?style=for-the-badge" alt="Laravel Reverb">
  <img src="https://img.shields.io/badge/Pest-Testing-F472B6?style=for-the-badge" alt="Pest PHP">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="MIT License">
</p>

---

## 📖 Tentang

**AntriYuk** adalah sistem manajemen antrian modern yang dibangun dengan Laravel 12 dan Laravel Reverb untuk update real-time melalui WebSocket. Sistem ini memungkinkan lokasi layanan (seperti bank, rumah sakit, kantor pemerintahan) untuk mengelola antrian secara efisien dengan estimasi waktu tunggu, notifikasi langsung, dan tampilan display untuk ruang tunggu.

### ✨ Fitur Utama

- 🎫 **Sistem Tiket Antrian** — Ambil nomor antrian dengan format unik per lokasi (contoh: CS-001)
- ⚡ **Real-time Updates** — Update langsung via WebSocket (Laravel Reverb) tanpa refresh halaman
- ⏱️ **Estimasi Waktu Tunggu** — Kalkulasi otomatis berdasarkan jumlah counter aktif dan rata-rata waktu layanan
- 📺 **Display Board** — Tampilan khusus untuk TV/kiosk di ruang tunggu dengan auto-refresh
- 👨‍💼 **Panel Operator** — Dashboard operator untuk memanggil, melayani, dan mengelola tiket
- 🛡️ **Panel Admin** — Kelola lokasi, counter, dan pengguna dari satu dashboard
- 🔐 **Multi-Role** — Sistem role-based access: Admin, Operator, dan Viewer
- 🔍 **Cek Status Tiket** — Pelanggan bisa cek status tiket kapan saja

### 🔄 Siklus Hidup Tiket

```
Menunggu → Dipanggil → Dilayani → Selesai
    ↓          ↓
 Dibatalkan  Dilewati
```

| Status      | Keterangan                             |
| ----------- | -------------------------------------- |
| `waiting`   | Pelanggan mengambil tiket dan menunggu |
| `calling`   | Operator memanggil nomor antrian       |
| `serving`   | Pelanggan sedang dilayani di counter   |
| `completed` | Layanan selesai                        |
| `skipped`   | Pelanggan tidak merespons panggilan    |
| `cancelled` | Tiket dibatalkan                       |

---

## 🛠️ Tech Stack

| Teknologi                                    | Versi | Kegunaan                         |
| -------------------------------------------- | ----- | -------------------------------- |
| [Laravel](https://laravel.com)               | 12    | Backend framework                |
| [PHP](https://php.net)                       | 8.2+  | Server-side language             |
| [Laravel Reverb](https://reverb.laravel.com) | 1.7   | WebSocket server untuk real-time |
| [Tailwind CSS](https://tailwindcss.com)      | 4     | Utility-first CSS framework      |
| [Alpine.js](https://alpinejs.dev)            | 3     | Reactive frontend (via CDN)      |
| [Vite](https://vitejs.dev)                   | 7     | Asset bundler                    |
| [Pest PHP](https://pestphp.com)              | 4     | Testing framework                |
| SQLite / MySQL                               | —     | Database                         |

---

## 🚀 Instalasi

### Prasyarat

- PHP 8.2 atau lebih baru
- Composer
- Node.js 18+ & npm
- SQLite (default) atau MySQL/MariaDB

### Setup Cepat

```bash
# 1. Clone repository
git clone https://github.com/your-username/antriyuk.git
cd antriyuk

# 2. Setup otomatis (install deps, .env, migrate, build assets)
composer setup

# 3. Seed database dengan data contoh
php artisan db:seed

# 4. Jalankan development server
composer dev
```

Buka browser di `http://localhost:8000`

### Setup Manual

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Salin file environment
cp .env.example .env

# Generate application key
php artisan key:generate

# Buat database SQLite
touch database/database.sqlite

# Jalankan migrasi
php artisan migrate

# Seed data contoh
php artisan db:seed

# Build assets
npm run build
```

### Menjalankan Development Server

```bash
# Terminal 1: Laravel server + Vite (concurrent)
composer dev

# Terminal 2: WebSocket server (untuk fitur real-time)
php artisan reverb:start
```

---

## 🧪 Testing

AntriYuk menggunakan [Pest PHP](https://pestphp.com) untuk testing dengan 30 test cases.

```bash
# Jalankan semua test
composer test

# Atau langsung
php artisan test

# Dengan output verbose
php artisan test --verbose
```

### Test Suites

| Suite        | Jumlah Test | Cakupan                                   |
| ------------ | ----------- | ----------------------------------------- |
| LocationTest | 8           | CRUD lokasi, daftar, detail, display      |
| OperatorTest | 6           | Panggil, layani, selesaikan, lewati tiket |
| AdminTest    | 7           | Kelola lokasi, counter, user              |
| AuthTest     | 8           | Login, register, logout, middleware       |

---

## 👥 Akun Demo

Setelah menjalankan `php artisan db:seed`, tersedia akun-akun berikut:

| Role                 | Email                        | Password   |
| -------------------- | ---------------------------- | ---------- |
| Admin                | `admin@antriyuk.test`        | `password` |
| Operator CS          | `operator-cs@antriyuk.test`  | `password` |
| Operator Pembayaran  | `operator-pay@antriyuk.test` | `password` |
| Operator Pendaftaran | `operator-reg@antriyuk.test` | `password` |

### Lokasi Contoh

| Lokasi           | Kode | Counter   |
| ---------------- | ---- | --------- |
| Customer Service | CS   | 3 counter |
| Pembayaran       | PAY  | 3 counter |
| Pendaftaran      | REG  | 3 counter |

---

## 📁 Struktur Proyek

```
antriyuk/
├── app/
│   ├── Events/              # Event broadcasting (TicketCreated, QueueUpdated, dll.)
│   ├── Http/
│   │   ├── Controllers/     # LocationController, OperatorController, AdminController, dll.
│   │   └── Middleware/       # EnsureUserIsAdmin, EnsureUserIsOperator
│   └── Models/              # Location, Counter, Ticket, User
├── database/
│   ├── factories/           # Factory untuk semua model
│   ├── migrations/          # Skema database
│   └── seeders/             # Data seeder
├── resources/
│   ├── css/app.css          # Tailwind CSS v4
│   ├── js/                  # JavaScript & Echo client
│   └── views/               # Blade templates (Indonesian UI)
├── routes/
│   └── web.php              # Semua route aplikasi
└── tests/
    └── Feature/             # Pest PHP test suites
```

---

## 🗺️ Route Groups

| Group    | Prefix                | Middleware         | Deskripsi                                 |
| -------- | --------------------- | ------------------ | ----------------------------------------- |
| Public   | `/`                   | —                  | Halaman utama, daftar lokasi, ambil tiket |
| Auth     | `/login`, `/register` | `guest`            | Autentikasi pengguna                      |
| Operator | `/operator`           | `auth`, `operator` | Dashboard dan manajemen antrian           |
| Admin    | `/admin`              | `auth`, `admin`    | Manajemen sistem penuh                    |

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan fork repository ini dan buat Pull Request.

1. Fork repository
2. Buat branch fitur (`git checkout -b fitur/fitur-baru`)
3. Commit perubahan (`git commit -m 'Tambah fitur baru'`)
4. Push ke branch (`git push origin fitur/fitur-baru`)
5. Buat Pull Request

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

<p align="center">Dibuat dengan ❤️ menggunakan Laravel 12</p>
