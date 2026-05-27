# 📦 SmartStock Pro - Sistem Manajemen Inventaris

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

SmartStock Pro adalah Sistem Manajemen Inventaris berbasis web yang dirancang khusus untuk memenuhi kebutuhan pencatatan, pemantauan, dan sirkulasi barang secara *real-time* di berbagai cabang gudang. Proyek ini dikembangkan sebagai pemenuhan Studi Kasus Ujian Sertifikasi Skema Web Developer.

## ✨ Fitur Utama

- **🔐 Autentikasi & Keamanan:** Login multi-level (Admin, Manajer, Staf), *password hashing* (Bcrypt), proteksi CSRF, dan Audit Log transaksi.
- **🗄️ Manajemen Data (CRUD):** Pengelolaan master data Produk (dengan *upload* gambar), Kategori, Gudang, dan Supplier.
- **🔄 Transaksi Inventaris:** Pencatatan Barang Masuk (Stock In) dan Barang Keluar (Stock Out) dengan kalkulasi stok akhir (`stock_after`) secara otomatis.
- **📊 Dashboard & Pelaporan:** Ringkasan performa inventaris, peringatan stok menipis, dan fitur cetak laporan dalam format PDF.

## 🛠️ Tech Stack

- **Backend:** PHP 8.x, Laravel Framework
- **Frontend:** HTML5, Blade Templating, Tailwind CSS
- **Database:** MySQL / MariaDB (Direkomendasikan menggunakan Laragon/HeidiSQL)
- **Library Tambahan:** SweetAlert2 (Notifikasi UI), DomPDF (Export Laporan)

## 🚀 Panduan Instalasi (Cara Menjalankan Proyek)

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di *local environment* Anda:

### Prasyarat
Pastikan Anda sudah menginstal:
- [Composer](https://getcomposer.org/)
- [Node.js & NPM](https://nodejs.org/)
- Web Server & Database (Disarankan menggunakan **Laragon** atau XAMPP)

### Langkah-langkah:

1. **Clone repositori ini:**
```bash
   git clone [https://github.com/](https://github.com/)[username-github-kamu]/smartstock-pro.git
   cd smartstock-pro
   ```

2. **Instal dependensi PHP & Node.js:**
```bash
   composer install
   npm install
   npm run build
   ```

3. **Siapkan *Environment Variables*:**
   Salin file konfigurasi bawaan dan sesuaikan dengan database Anda.
```bash
   cp .env.example .env
   ```
   Buka file `.env` dan atur koneksi *database* Anda (sesuaikan nama database yang sudah Anda buat di HeidiSQL/phpMyAdmin):
```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=smartstock_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key:**
```bash
   php artisan key:generate
   ```

5. **Migrasi Database & Seeding (Penting untuk data awal):**
   Perintah ini akan membuat semua struktur tabel dan mengisi data *dummy* produk, supplier, dan akun pengguna.
```bash
   php artisan migrate:fresh --seed
   ```

6. **Tautkan Storage (Untuk galeri produk):**
```bash
   php artisan storage:link
   ```

7. **Jalankan Server Lokal:**
```bash
   php artisan serve
   ```
   Akses aplikasi di browser melalui URL: `http://localhost:8000`

## 🔑 Kredensial Login Default

Setelah proses migrasi dan *seeding* selesai, Anda bisa masuk menggunakan akun uji coba berikut:

- **Admin Gudang**
  - Email: `admin@smartstock.com`
  - Password: `password`

## 📝 Lisensi & Author

Proyek ini dikembangkan oleh **Fadia Syakira Mustaniroh** untuk keperluan Seleksi BNSP SSMI untuk Sertifikasi LSP TIK Global.
