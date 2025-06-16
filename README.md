# Bank Sampah Application

## Ringkasan Proyek

Aplikasi RecyclePay.id ini mengelola berbagai modul utama yang meliputi Jenis Sampah, Manajemen Pengguna, Jadwal Penjemputan, Transaksi, dan Manajemen Saldo termasuk Riwayat Penarikan Saldo. Aplikasi ini dibangun menggunakan Laravel Framework dengan fitur role-based access control dan integrasi DataTables untuk tampilan data yang interaktif.

---

## Struktur Database dan Migrasi

- **Tabel Transaksi**  
  Menyimpan data transaksi sampah dengan atribut seperti user_id, jenis_sampah_id, berat, nilai_saldo, status_verifikasi, dan catatan verifikasi.

- **Tabel Saldo**  
  Menyimpan saldo setiap pengguna dengan kolom user_id dan jumlah_saldo.

- **Tabel Riwayat Penarikan Saldo**  
  Mencatat riwayat penarikan saldo dengan informasi saldo sebelum dan sesudah penarikan, jumlah penarikan, dan tanggal penarikan.

- **Tabel Penjemputan**  
  Menyimpan jadwal penjemputan sampah dengan atribut jadwal, status, lokasi koordinat, dan alamat.

- **Penambahan Role pada Tabel Users**  
  Menambahkan kolom role untuk mengatur hak akses pengguna (super_admin, kepala_dinas, end_user).

---

## Model

Model utama yang digunakan:

- `Transaksi`  
- `Saldo`  
- `RiwayatPenarikanSaldo`  
- `Penjemputan`  
- `Jenis_sampah`  
- `User`

Relasi antar model sudah diatur untuk mendukung operasi CRUD dan fitur aplikasi.

---

## DataTables

Digunakan untuk menampilkan data secara interaktif pada halaman admin:

- **UserManagementDataTable**: Manajemen pengguna dengan aksi edit dan hapus.
- **PenjemputanDataTable**: Jadwal penjemputan dengan opsi edit status.
- **JenisSampahDataTable**: Data jenis sampah dengan thumbnail foto.
- **TransaksiDataTable**: Data transaksi sampah.
- **SaldoDataTable**: Data saldo pengguna dengan fitur penarikan saldo.

---

## Controller

Controller mengatur logika bisnis dan fitur utama:

- `UserManagementController`  
- `PenjemputanController`  
- `JenisSampahController`  
- `TransaksiController`  
- `SaldoController`  

Fitur tambahan seperti cetak PDF, autocomplete user, dan pengelolaan riwayat penarikan saldo juga diatur di sini.

---

## Blade Views dan Modals

- Halaman manajemen dan form input untuk setiap modul.
- Modal edit dengan validasi dan interaksi AJAX.
- Sidebar navigasi dengan menu utama sesuai modul.

---

## Middleware dan Keamanan

- `SuperAdminMiddleware`  
- `EndUserMiddleware`  
- `AccessPenjemputanMiddleware`  

Middleware ini mengatur akses berdasarkan role pengguna untuk menjaga keamanan dan pembatasan fitur.

---

## Routing

- Route resource dan route khusus dengan middleware yang sesuai.
- Route untuk cetak PDF, autocomplete, dan API endpoint lainnya.
- Grup route dengan prefix `admin` dan middleware `auth` serta role-based middleware.

---

## Riwayat Penarikan Saldo

- Fitur pencatatan riwayat penarikan saldo lengkap dengan tampilan dan cetak PDF.
- Proses penarikan saldo dilakukan melalui halaman manajemen saldo dengan modal khusus.

---

## Pengujian

- Anda sudah melakukan pengujian pada modul-modul utama termasuk middleware dan routing.
- Pengujian mencakup validasi akses, fungsi CRUD, dan fitur khusus seperti cetak PDF dan autocomplete.

---

## Dependensi dan Persyaratan

### Persyaratan Sistem
- PHP versi 8.2.12
- Composer versi 2.7.7
- Node.js versi 18.18.0
- npm versi 9.8.1
- Database MySQL versi 10.1.38 (dijalankan pada server XAMPP dengan Apache 2.4.38)
- Web server Apache 2.4.38 pada XAMPP digunakan untuk backend Laravel
- Vite digunakan sebagai build tool dan development server untuk asset frontend (CSS, JS)

### Dependensi PHP (dari composer.json)
- laravel/framework versi ^10.10
- barryvdh/laravel-dompdf versi ^3.1 (untuk generate PDF)
- consoletvs/charts versi ^6.6 (untuk grafik)
- guzzlehttp/guzzle versi ^7.2 (HTTP client)
- laravel/sanctum versi ^3.2 (autentikasi API)
- laravel/tinker versi ^2.8 (REPL Laravel)
- maatwebsite/excel versi ^3.1 (export/import Excel)
- yajra/laravel-datatables versi 10.0 (DataTables server-side)
- yajra/laravel-datatables-buttons versi ^10.0 (tombol export DataTables)

### Dependensi Dev (untuk pengembangan dan testing)
- fakerphp/faker versi ^1.9.1 (data dummy)
- laravel/breeze versi ^1.24 (scaffolding auth)
- laravel/pint versi ^1.0 (code style)
- laravel/sail versi ^1.18 (Docker environment)
- mockery/mockery versi ^1.4.4 (mocking untuk testing)
- nunomaduro/collision versi ^7.0 (error handling)
- phpunit/phpunit versi ^10.1 (unit testing)
- spatie/laravel-ignition versi ^2.0 (debugging)

### Dependensi Frontend (dari package.json)
- alpinejs versi ^3.4.2 (JavaScript framework ringan)
- axios versi ^1.1.2 (HTTP client)
- laravel-vite-plugin versi ^0.8.0 (integrasi Vite dengan Laravel)
- postcss versi ^8.4.6 (CSS processing)
- tailwindcss versi ^3.1.0 (utility-first CSS framework)
- vite versi ^4.0.0 (build tool)
- @tailwindcss/forms versi ^0.5.2 (plugin Tailwind untuk form)

---