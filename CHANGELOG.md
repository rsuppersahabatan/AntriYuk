# Changelog

Semua perubahan penting pada proyek AntriYuk akan didokumentasikan di file ini.

Format berdasarkan [Keep a Changelog](https://keepachangelog.com/id-ID/1.1.0/),
dan proyek ini mengikuti [Semantic Versioning](https://semver.org/lang/id/).

---

## [1.1.0] - 2025-01-31

### Ditingkatkan

- **Halaman Utama (Landing Page)** — Desain ulang lengkap dengan hero section, statistik real-time, langkah-langkah penggunaan, preview lokasi, dan CTA
- **Halaman Daftar Lokasi** — Breadcrumb navigasi, tombol filter status, kartu lokasi dengan hover effects dan informasi lebih lengkap
- **Halaman Detail Tiket** — Desain tiket fisik dengan punch holes, indikator status kontekstual, kartu posisi & estimasi waktu
- **Halaman Ambil Tiket** — Layout kartu dengan header biru, grid informasi antrian (posisi, estimasi, counter aktif)
- **Halaman Cek Tiket** — Header gelap, input lebih besar, tombol CTA yang menonjol
- **Dashboard Operator** — Sticky top bar, statistik 4 kolom, panel tiket dan antrian yang ditingkatkan
- **Dashboard Admin** — Header profesional, statistik 4 kolom, hover effects pada kartu, tabel yang ditingkatkan
- **Semua halaman** — Konsistensi desain, flat design tanpa gradien, tipografi yang lebih baik

---

## [1.0.0] - 2025-01-31

### Ditambahkan

#### Sistem Inti

- **Manajemen Lokasi** — CRUD lengkap untuk lokasi layanan dengan kode unik, deskripsi, alamat, jam operasional
- **Manajemen Counter** — Counter per lokasi dengan status aktif/nonaktif dan assignment operator
- **Sistem Tiket** — Pengambilan tiket dengan nomor format `{KODE}-{###}` (contoh: CS-001)
- **Siklus Hidup Tiket** — Status: waiting → calling → serving → completed/skipped/cancelled
- **Estimasi Waktu Tunggu** — Kalkulasi otomatis berdasarkan counter aktif dan rata-rata waktu layanan

#### Real-time & Broadcasting

- **Laravel Reverb** — WebSocket server terintegrasi untuk update real-time
- **Event Broadcasting** — TicketCreated, TicketCalled, TicketStatusChanged, QueueUpdated
- **Public Channels** — Channel `location.{id}` dan `ticket.{id}` untuk broadcast
- **Display Board** — Halaman khusus TV/kiosk dengan auto-refresh dan WebSocket listener

#### Autentikasi & Otorisasi

- **Multi-Role System** — Tiga role: Admin, Operator, Viewer
- **Login & Register** — Sistem autentikasi lengkap dengan validasi
- **Middleware** — EnsureUserIsAdmin dan EnsureUserIsOperator untuk proteksi route

#### Panel Operator

- **Dashboard Operator** — Statistik antrian, panel tiket aktif, daftar antrian
- **Assign Counter** — Operator memilih counter untuk bertugas
- **Panggil Tiket** — Memanggil tiket berikutnya secara otomatis
- **Mulai Layani** — Ubah status tiket ke "sedang dilayani"
- **Selesaikan Tiket** — Tandai layanan selesai
- **Lewati Tiket** — Lewati pelanggan yang tidak merespons
- **Panggil Ulang** — Panggil ulang tiket yang sedang dipanggil

#### Panel Admin

- **Dashboard Admin** — Ringkasan statistik seluruh sistem
- **CRUD Lokasi** — Buat, lihat, edit, hapus lokasi layanan
- **Kelola Counter** — Tambah dan toggle status counter per lokasi
- **Kelola User** — Lihat semua pengguna, ubah role dan assignment lokasi

#### Halaman Publik

- **Halaman Utama** — Landing page dengan informasi sistem
- **Daftar Lokasi** — Browse semua lokasi aktif dengan informasi antrian
- **Detail Lokasi** — Lihat antrian aktif, counter, dan tiket yang sedang dilayani
- **Ambil Tiket** — Form pengambilan tiket dengan nama dan nomor telepon
- **Status Tiket** — Halaman detail tiket dengan posisi antrian dan estimasi waktu
- **Cek Tiket** — Cari tiket berdasarkan nomor tiket

#### Testing

- **30 Test Cases** — Pest PHP test suite lengkap
- **LocationTest** (8 tests) — Daftar, detail, display, pengambilan tiket
- **OperatorTest** (6 tests) — Panggil, layani, selesaikan, lewati tiket
- **AdminTest** (7 tests) — CRUD lokasi, counter, user
- **AuthTest** (8 tests) — Login, register, logout, middleware guard

#### Database & Seeder

- **Migrasi** — Tabel locations, counters, tickets, modifikasi users
- **Factory** — Factory untuk semua model dengan states (admin, operator, waiting, calling, dll.)
- **Seeder** — Data contoh: 1 admin, 3 lokasi, 9 counter, 3 operator

---

## Template Rilis Mendatang

### [Unreleased]

<!-- Tambahkan perubahan yang belum dirilis di sini -->

[1.1.0]: https://github.com/your-username/antriyuk/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/your-username/antriyuk/releases/tag/v1.0.0
