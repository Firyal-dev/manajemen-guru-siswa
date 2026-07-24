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
php artisan migrate:fresh --seed
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
API_ACCESS_TOKEN=<your-secret-token>
```

Nilai token ini bebas, namun **harus sama persis** dengan nilai `API_SISWA_TOKEN` yang dimasukkan pada file `.env` aplikasi `management-nilai` agar permintaan sinkronisasi data tidak ditolak.

## 📷 Manajemen File & Foto Profil

Aplikasi ini bertindak sebagai **Pusat Penyimpanan Media (Master)** untuk aplikasi di ekosistemnya. File fisik seperti foto profil Guru dan Siswa diunggah dan disimpan sepenuhnya secara lokal di aplikasi ini (`storage/app/public`).

File tersebut disajikan dan dapat diakses secara publik berkat perintah `php artisan storage:link`. Aplikasi lain (seperti `management-nilai`) tidak akan menyimpan foto-foto tersebut ulang, melainkan hanya akan menumpang (*hotlinking*) menampilkan foto-foto ini dengan mengarahkan *tag image*-nya ke URL aplikasi ini.

Pastikan aplikasi ini selalu berjalan (secara default di port 8001: `php artisan serve --port=8001`) agar foto-foto tersebut tidak *broken* di aplikasi klien.