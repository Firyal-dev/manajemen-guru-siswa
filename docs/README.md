# Dokumentasi Proyek Manajemen Guru & Siswa

## 1. Ringkasan Proyek

Aplikasi ini merupakan sistem manajemen data sekolah berbasis Laravel untuk mengelola:

- data guru
- data siswa
- data jurusan
- data kelas
- data rombel
- data tahun ajaran
- relasi wali kelas dan daftar siswa per rombel

Tujuan utama aplikasi ini adalah menyimpan data akademik dan struktur kelas secara rapi, serta memudahkan pengelolaan rombel per jurusan dan per tingkat.

## 2. Fitur Utama

### Manajemen Guru
- menambah guru
- mengedit guru
- menghapus guru
- upload foto guru
- pencarian guru

### Manajemen Jurusan
- tambah jurusan
- menampilkan daftar jurusan beserta kelas dan rombel
- struktur kelas ditampilkan per tingkat dan per jurusan

### Manajemen Kelas dan Rombel 
- menambah kelas dan rombel sekaligus
- validasi agar tidak ada duplikasi rombel untuk kombinasi jurusan + tingkat kelas + nomor rombel
- wajib menambahkan minimal 1 rombel saat menyimpan kelas
- tombol hapus rombel dengan konfirmasi modal

### Tahun Ajaran
- mengatur tahun ajaran aktif
- digunakan untuk relasi data rombel

## 3. Teknologi yang Digunakan

- PHP 8.3
- Laravel 13
- Breeze untuk autentikasi
- Tailwind CSS
- Alpine.js
- Vite
- PHPUnit untuk testing

## 4. Persyaratan Lingkungan

Sebelum menjalankan project, pastikan perangkat sudah terpasang:

- PHP 8.3+
- Composer
- Node.js dan npm
- database MySQL / SQLite / driver database yang didukung Laravel

## 5. Setup Local

1. Clone repository.
2. Install dependency PHP and Vite:

   ```bash
   composer install
   npm install
   ```

3. Copy file environment:

   ```bash
   cp .env.example .env
   ```

4. Generate key aplikasi:

   ```bash
   php artisan key:generate
   ```

5. Konfigurasi database di file `.env`.
6. Jalankan migrasi:

   ```bash
   php artisan migrate
   ```

6. Jalankan storage link:

   ```bash
   php artisan storage:link
   ```

7. Install dependency frontend:

   ```bash
   npm install
   ```

8. Build asset frontend:

   ```bash
   npm run build
   ```

9. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

## 6. Struktur Folder Utama

- `app/Http/Controllers` → controller untuk fitur guru, jurusan, kelas, rombel
- `app/Http/Requests` → validasi form request
- `app/Models` → model utama seperti `Guru`, `Jurusan`, `Kelas`, `Rombel`, `TahunAjaran`
- `resources/views` → view Blade untuk layout, form, page daftar, modal, dan komponen reusable
- `routes/web.php` → routing aplikasi
- `database/migrations` → skema database
- `tests/Feature` → test fitur

## 8. Testing

Untuk menjalankan test yang sudah dibuat:

```bash
php artisan test
```