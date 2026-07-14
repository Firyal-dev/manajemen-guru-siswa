# Manajemen Guru & Siswa

Aplikasi manajemen data sekolah berbasis Laravel untuk mengelola guru, jurusan, kelas, rombel, tahun ajaran, dan relasi wali kelas secara terstruktur.

## Fitur Utama

- Manajemen data guru
- Manajemen jurusan
- Manajemen kelas dan rombel
- Validasi duplikasi rombel per jurusan dan tingkat kelas
- Wajib input minimal satu rombel saat menambah kelas
- Konfirmasi hapus rombel melalui modal
- Auth login dan dashboard berbasis Laravel Breeze

## Stack Teknologi

- PHP 8.3
- Laravel 13
- Tailwind CSS
- Alpine.js
- Vite
- PHPUnit

## Persyaratan Sistem

- PHP 8.3+
- Composer
- Node.js dan npm
- Database yang didukung Laravel

## Setup Local

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm install
npm run build
php artisan serve
```

Setelah server berjalan, buka:

```text
http://127.0.0.1:8000
```

## Struktur Proyek

- `app/Http/Controllers` → controller utama
- `app/Http/Requests` → validasi request
- `app/Models` → model data
- `resources/views` → Blade UI dan komponen reusable
- `routes/web.php` → routing aplikasi
- `tests/Feature` → test fitur

## Dokumentasi Lengkap

Dokumentasi pengembangan dan penjelasan modul proyek bisa dilihat di:

- [docs/README.md](docs/README.md)

## Testing

```bash
php artisan test
```

##  Catatan Penting: Menjalankan Multi-Aplikasi di Localhost

Jika Anda menjalankan aplikasi ini secara bersamaan dengan aplikasi `management-nilai` di `localhost` (contoh: port 8000 dan 8001), pastikan nilai `APP_NAME` di file `.env` berbeda untuk masing-masing aplikasi (misal: `APP_NAME=ManagementNilai` dan `APP_NAME=ManajemenGuruSiswa`). 

Hal ini sangat penting untuk menghindari konflik _session cookie_ di browser yang dapat menyebabkan *redirect loop* (bug terlempar terus-menerus ke halaman login) saat menggunakan aplikasi karena cookie otentikasi dari kedua aplikasi saling menimpa.

## Konfigurasi API (Penyedia Data)

Aplikasi ini bertindak sebagai **Penyedia Master Data** (Tahun Ajaran, dsb) untuk aplikasi `management-nilai`. Agar komunikasi antar aplikasi bisa berjalan dengan aman dan diizinkan, aplikasi ini membutuhkan konfigurasi token akses.

Pastikan variabel berikut ada di file `.env` Anda:
```env
API_ACCESS_TOKEN=PBWTikgXDzYx1q3ZQ94cmtqSOwRiyz9PE76NjxKw7AIi3j5Xp7g4n1hNa5CNIvfs
```

Nilai token ini bebas, namun **harus sama persis** dengan nilai `API_SISWA_TOKEN` yang dimasukkan pada file `.env` aplikasi `management-nilai` agar permintaan sinkronisasi data tidak ditolak.