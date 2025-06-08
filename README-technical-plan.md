# Rencana Teknis Implementasi Modul Super Admin ECOCOIN

Dokumen ini menjelaskan rencana teknis untuk implementasi modul Super Admin pada aplikasi ECOCOIN, sesuai dengan draft fungsi dan alur kerja yang telah disepakati.

---

## 1. Struktur Modul dan Fitur Utama

### 1.1. Manajemen Pengguna (Done)
- **Model:** User (dengan atribut role: super_admin, kepala_dinas, end_user)
- **Fitur:**
  - CRUD pengguna
  - Pengaturan peran dan hak akses
  - Validasi dan verifikasi akun baru
- **Endpoint API / Controller:**
  - `GET /admin/users` - Daftar pengguna
  - `POST /admin/users` - Tambah pengguna
  - `PUT /admin/users/{id}` - Update pengguna
  - `DELETE /admin/users/{id}` - Hapus pengguna

### 1.2. Manajemen Jenis Sampah (Done)
- **Model:** JenisSampah (nama, kategori, harga_per_kilo, deskripsi, foto)
- **Fitur:**
  - CRUD jenis sampah
  - Upload dan manajemen foto sampah
- **Endpoint API / Controller:**
  - `GET /admin/jenis-sampah`
  - `POST /admin/jenis-sampah`
  - `PUT /admin/jenis-sampah/{id}`
  - `DELETE /admin/jenis-sampah/{id}`

### 1.3. Penjadwalan Penjemputan
- **Model:** Penjemputan (user_id, jadwal, status)
- **Fitur:**
  - Lihat jadwal penjemputan
  - Update status penjemputan (terjadwal, selesai, batal)
  - Notifikasi ke pengguna
- **Endpoint API / Controller:**
  - `GET /admin/penjemputan`
  - `PUT /admin/penjemputan/{id}`

### 1.4. Transaksi dan Riwayat
- **Model:** Transaksi (user_id, jenis_sampah_id, jumlah, harga, status)
- **Fitur:**
  - Pantau transaksi penukaran sampah
  - Verifikasi dan update status transaksi
- **Endpoint API / Controller:**
  - `GET /admin/transaksi`
  - `PUT /admin/transaksi/{id}`

### 1.5. Manajemen Koin dan Hadiah
- **Model:** Koin (user_id, saldo), Hadiah (nama, deskripsi, harga_koin)
- **Fitur:**
  - Kelola saldo koin pengguna
  - Kelola katalog hadiah
  - Pantau penukaran hadiah
- **Endpoint API / Controller:**
  - `GET /admin/koin`
  - `GET /admin/hadiah`
  - `POST /admin/hadiah`
  - `PUT /admin/hadiah/{id}`
  - `DELETE /admin/hadiah/{id}`

### 1.6. Dashboard Super Admin
- Statistik pengguna, transaksi, penjemputan
- Grafik tren pengelolaan sampah dan penggunaan koin

---

## 2. Alur Kerja dan Integrasi

- Super Admin mengelola data master (pengguna, jenis sampah, hadiah)
- Super Admin memantau transaksi dan penjemputan yang dilakukan oleh End User
- Kepala Dinas dapat mengakses laporan dan memantau pelaksanaan program
- End User melakukan registrasi, penjadwalan penjemputan, transaksi, dan penukaran hadiah

---

## 3. Teknologi dan Tools

- Framework: Laravel (PHP)
- Database: MySQL / MariaDB
- Frontend: Blade Templates, CSS, JavaScript
- Autentikasi dan Otorisasi: Laravel Sanctum / Middleware Role-based
- Notifikasi: Email / In-app Notification

---

## 4. Langkah Implementasi

1. **Setup Role dan Middleware**
   - Definisikan role di model User
   - Buat middleware untuk proteksi route berdasarkan role

2. **Buat CRUD Manajemen Pengguna**
   - Controller, views, dan routes untuk manajemen pengguna

3. **Implementasi Manajemen Jenis Sampah**
   - CRUD jenis sampah dengan upload foto

4. **Buat Modul Penjadwalan Penjemputan**
   - Tampilkan jadwal, update status, dan notifikasi

5. **Implementasi Modul Transaksi dan Riwayat**
   - Pantau dan verifikasi transaksi

6. **Manajemen Koin dan Hadiah**
   - Kelola saldo koin dan katalog hadiah

7. **Dashboard Super Admin**
   - Statistik dan grafik

---

## 5. Testing dan Validasi

- Unit test untuk model dan controller
- Integration test untuk alur kerja utama
- UI testing untuk dashboard dan form input

---

Jika Anda setuju, saya dapat membantu membuatkan kode awal untuk modul-modul tersebut atau membantu langkah demi langkah sesuai prioritas.
