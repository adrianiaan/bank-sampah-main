# Panduan Menjalankan Proyek Bank Sampah

Berikut adalah langkah-langkah untuk menjalankan proyek Bank Sampah berbasis Laravel ini di komputer Anda.

## Persyaratan
- PHP >= 8.0
- Composer
- Node.js dan npm
- Database MySQL atau MariaDB
- Web server (misal: Apache, Nginx) atau gunakan built-in server Laravel

## Langkah Instalasi

1. **Clone atau salin proyek ke komputer Anda**

2. **Install dependensi PHP dengan Composer**
```bash
composer install
```

3. **Install dependensi frontend dengan npm**
```bash
npm install
```

4. **Salin file environment**
```bash
cp .env.example .env
```

5. **Konfigurasi file `.env`**
- Sesuaikan pengaturan database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) sesuai dengan database Anda.
- Sesuaikan `APP_URL` jika perlu.

6. **Generate application key**
```bash
php artisan key:generate
```

7. **Jalankan migrasi dan seeding database**
```bash
php artisan migrate:fresh --seed
```

8. **Build asset frontend**
```bash
npm run dev
```

9. **Jalankan server Laravel**
```bash
php artisan serve
```

Server akan berjalan di `http://localhost:8000` secara default.

## Login Admin

Gunakan akun admin default berikut untuk login:

- Email: admin@banksampah.com
- Password: password

## Catatan

- Pastikan database sudah dibuat dan dapat diakses oleh aplikasi.
- Jika ada perubahan pada asset frontend, jalankan kembali `npm run dev`.
- Untuk produksi, gunakan `npm run build` untuk build asset.

---

Semoga panduan ini membantu Anda menjalankan proyek Bank Sampah dengan lancar.
