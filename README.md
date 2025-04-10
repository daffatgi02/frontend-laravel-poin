Tentu! Ini dia versi siap-copy untuk file `README.md` GitHub-mu:

```markdown
# Laravel Store Point Management System

Aplikasi ini adalah sistem manajemen toko berbasis Laravel yang dilengkapi fitur poin reward. Pemilik toko dapat mendaftar, memverifikasi toko mereka, menjual produk, dan memperoleh poin yang bisa ditukarkan.

## 🚀 Fitur Utama

### Admin
- Dashboard Admin
- Manajemen Toko (lihat, verifikasi, ubah status)
- Manajemen Produk (tambah, edit, hapus)
- Verifikasi Penjualan Toko

### Toko
- Dashboard Toko
- Registrasi dan Verifikasi Toko
- Melihat Produk Tersedia
- Mencatat Penjualan & Mendapatkan Poin
- Riwayat Penjualan

## ⚙️ Persyaratan Sistem

- PHP >= 8.0  
- Composer  
- MySQL / MariaDB  
- Node.js & NPM  
- Git  

## 🛠️ Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/yourusername/store-point-management.git
   cd store-point-management
   ```

2. **Install Dependensi PHP**
   ```bash
   composer install
   ```

3. **Install Dependensi JavaScript**
   ```bash
   npm install
   npm run dev
   ```

4. **Konfigurasi Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Konfigurasi Database**  
   Edit file `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=store_point_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Migrasi & Seeder Database**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

   Akun admin default:
   ```
   Email: daffatgi02@gmail.com
   Password: daffa123
   ```

7. **Buat Symlink Storage**
   ```bash
   php artisan storage:link
   ```

8. **Jalankan Server**
   ```bash
   php artisan serve
   ```

   Akses: [http://127.0.0.1:8000](http://127.0.0.1:8000)

## 🧭 Alur Kerja

1. Pengguna mendaftar sebagai akun toko
2. Mendaftarkan toko dan menunggu verifikasi admin
3. Admin memverifikasi toko
4. Admin menambahkan produk
5. Toko mencatat penjualan (dengan bukti foto)
6. Admin memverifikasi penjualan dan mengurangi stok
7. Toko menerima poin sesuai reward

## 📱 Dukungan PWA

Aplikasi ini mendukung **Progressive Web App (PWA)**:  
- Dapat diinstal di perangkat mobile / desktop  
- Dapat digunakan secara offline  

## 🧰 Teknologi yang Digunakan

- Laravel 9.x  
- Bootstrap 5  
- Font Awesome  
- AOS Animation  
- Swiper JS  
- Service Worker (PWA)

## 🐞 Troubleshooting

**Gambar tidak muncul setelah upload:**  
Pastikan sudah menjalankan:
```bash
php artisan storage:link
```

**Tidak bisa login dengan akun default:**  
Jalankan seeder:
```bash
php artisan db:seed
```

**Error saat migrasi:**  
Pastikan database sudah dibuat dan `.env` sudah dikonfigurasi dengan benar.

