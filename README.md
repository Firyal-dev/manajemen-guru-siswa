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