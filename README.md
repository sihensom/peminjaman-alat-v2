# SIPENAL - Sistem Peminjaman Alat (Inventori)

SIPENAL adalah sistem terintegrasi berbasis web untuk manajemen peminjaman alat praktik dan laboratorium. Dibangun menggunakan framework Laravel 12, aplikasi ini ditujukan untuk mempermudah proses peminjaman, pengembalian, dan pelacakan inventori alat secara aman, cepat, dan transparan.

---

## 🚀 Panduan Setup Project (Instalasi di Komputer / Laptop Lain)

Ikuti setiap langkah di bawah ini secara **berurutan** agar project dapat berjalan tanpa error.

---

### 📦 Kebutuhan Sistem (Prerequisites)

Sebelum mulai, pastikan semua software berikut **sudah terinstall** di komputer kamu:

| Software | Versi Minimal | Keterangan |
|---|---|---|
| **PHP** | 8.2+ | Pastikan sudah ditambahkan ke PATH sistem |
| **Composer** | 2.x | Package manager PHP |
| **Node.js & NPM** | 18.x+ | Untuk build asset frontend (CSS/JS) |
| **XAMPP / Laragon** | Terbaru | Menjalankan MySQL lokal |
| **Git** _(opsional)_ | — | Jika ingin clone via git |

> ⚠️ **Pastikan PHP bisa dipanggil dari terminal.** Buka CMD/PowerShell dan ketik `php -v`. Jika muncul versi PHP, berarti sudah benar. Jika error, tambahkan PHP ke PATH sistem Windows kamu.

---

### 🗂️ Langkah 1 — Clone / Download Project

**Opsi A — Git Clone:**
```bash
git clone https://github.com/username/ukk-laravel.git
cd ukk-laravel
```

**Opsi B — Download ZIP:**
1. Download file ZIP project dari sumber yang diberikan
2. Ekstrak ke folder pilihan kamu (contoh: `D:\ukk-laravel`)
3. Buka terminal/CMD lalu masuk ke folder tersebut:
```bash
cd D:\ukk-laravel
```

---

### 📥 Langkah 2 — Install Dependensi PHP (Composer)

Jalankan perintah berikut di dalam folder project untuk menginstall semua library PHP yang dibutuhkan (termasuk Laravel framework-nya sendiri):

```bash
composer install
```

> ⏳ Proses ini membutuhkan koneksi internet dan bisa memakan waktu 1–3 menit. Tunggu hingga muncul pesan `No security vulnerability advisories found` atau sejenisnya.

---

### 🎨 Langkah 3 — Install Dependensi Frontend (NPM)

Install library JavaScript dan CSS (Vite, TailwindCSS, dll) dengan perintah:

```bash
npm install
```

> ⏳ Proses ini juga membutuhkan koneksi internet. Folder `node_modules` akan terbentuk setelah selesai.

---

### ⚙️ Langkah 4 — Konfigurasi File Environment (`.env`)

File `.env` adalah file rahasia yang menyimpan konfigurasi aplikasi (termasuk koneksi database). File ini **tidak** ikut di-commit ke Git.

**4a. Buat file `.env` dari template:**
```bash
cp .env.example .env
```
> Di Windows (Command Prompt) jika perintah `cp` tidak dikenal, pakai:
> ```bash
> copy .env.example .env
> ```

**4b. Edit file `.env` dan sesuaikan bagian database:**

Buka file `.env` di text editor (VSCode), cari bagian `DB_*` dan ubah sesuai settingan MySQL lokal kamu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ukk_laravel
DB_USERNAME=root
DB_PASSWORD=
```

> 📌 **Keterangan:**
> - `DB_DATABASE` → Nama database yang akan kamu buat di phpMyAdmin (harus sama persis: `ukk_laravel`)
> - `DB_USERNAME` → Default XAMPP adalah `root`
> - `DB_PASSWORD` → Biarkan **kosong** jika XAMPP default. Isi `admin` jika kamu sudah mengatur password MySQL sendiri.

---

### 🔑 Langkah 5 — Generate Application Key

Laravel butuh key unik untuk enkripsi session dan data sensitif. Generate dengan perintah:

```bash
php artisan key:generate
```

> ✅ Perintah ini akan otomatis menulis nilai `APP_KEY` di file `.env` kamu. Jika berhasil akan muncul: `Application key set successfully.`

---

### 🗄️ Langkah 6 — Siapkan Database di phpMyAdmin

Sebelum menjalankan migrasi, kamu harus membuat databasenya terlebih dahulu:

1. Buka **XAMPP Control Panel**, klik **Start** pada baris **Apache** dan **MySQL**
2. Buka browser, akses: `http://localhost/phpmyadmin`
3. Di panel kiri klik **New** (Baru)
4. Isi nama database: `ukk_laravel`
5. Pilih collation: `utf8mb4_unicode_ci`
6. Klik **Create / Buat**

---

### 🏗️ Langkah 7 — Migrasi Database & Seeding Data Awal

Setelah database kosong (`ukk_laravel`) sudah dibuat, jalankan perintah berikut untuk membuat semua tabel sekaligus mengisi data awal (akun default, kategori alat, dan puluhan contoh alat lab):

```bash
php artisan migrate:fresh --seed
```

> 📋 **Penjelasan perintah:**
> - `migrate:fresh` → Menghapus semua tabel yang ada (jika ada) lalu membuat ulang semua tabel dari file migrasi di folder `database/migrations/`
> - `--seed` → Setelah tabel terbuat, otomatis mengisi data awal dari file `database/seeders/DatabaseSeeder.php`

> ✅ Jika berhasil, terminal akan menampilkan daftar tabel yang dibuat dan pesan `Database seeding completed successfully.`

> ⚠️ **Jika muncul error koneksi:** Pastikan MySQL di XAMPP sudah **Running** dan isi `.env` sudah benar.

**Setelah seeder selesai, akun login yang tersedia adalah:**

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@sipenal.com` | `password` |
| **Petugas** | `petugas@sipenal.com` | `password` |
| **Peminjam** | `peminjam@sipenal.com` | `password` |

---

> ### 💡 Alternatif: Import File SQL Langsung (Tanpa Artisan)
>
> Jika kamu **tidak mau** menggunakan perintah artisan, kamu bisa langsung import file SQL yang sudah disediakan:
> 1. Buka phpMyAdmin → pilih database `ukk_laravel`
> 2. Klik tab **Import**
> 3. Klik **Choose File**, pilih file `ukk_laravel.sql` di root folder project ini
> 4. Klik **Go / Jalankan**
>
> File ini sudah berisi: struktur tabel lengkap, data dummy alat lab, dan **Database Triggers** otomatis.

---

### 🎨 Langkah 8 — Build Asset Frontend

Ini adalah langkah **wajib** agar tampilan (CSS/desain) aplikasi bisa tampil dengan benar. Jika dilewati, akan muncul error _"Vite manifest not found"_.

```bash
npm run build
```

> ✅ Jika berhasil, akan muncul ringkasan file yang di-compile seperti `app-xxx.css` dan `app-xxx.js` di folder `public/build/`.

---

### 🚀 Langkah 9 — Jalankan Aplikasi

Aktifkan server lokal Laravel:

```bash
php artisan serve
```

Buka browser dan akses: **`http://127.0.0.1:8000`**

Kamu akan langsung diarahkan ke halaman **Login**. Gunakan salah satu akun dari tabel di Langkah 7.

---

### 📋 Ringkasan Semua Command (Copy-Paste Cepat)

```bash
# 1. Install dependensi
composer install
npm install

# 2. Setup environment
cp .env.example .env
# → Edit file .env: isi DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 3. Generate key & migrasi
php artisan key:generate
php artisan migrate:fresh --seed

# 4. Build frontend & jalankan
npm run build
php artisan serve
```

---


## 🛠️ Troubleshooting (Pemecahan Masalah)

Jika terjadi masalah saat mencoba menjalankan (run) aplikasi, cek beberapa hal berikut:

- **Error: `Vite manifest not found` at public\build/manifest.json**
  - **Penyebab**: Folder `public/build` belum terbentuk karena asset frontend belum di-build.
  - **Solusi**: Pastikan Anda sudah menjalankan perintah `npm install` lalu `npm run build` di terminal (pastikan koneksi internet aktif saat instalasi npm).

- **Error: `php_network_getaddresses: getaddrinfo failed: No such host is known` / `Connection refused`**
  - **Penyebab**: Laravel gagal menghubungi database MySQL gara-gara salah penulisan `DB_HOST` atau service MySQL di XAMPP belum menyala.
  - **Solusi**: Cek file `.env`, pastikan `DB_HOST=127.0.0.1`. Dan pastikan service MySQL di aplikasi XAMPP/Laragon sudah berstatus "Running" atau "Start".

- **Penyebab Halaman Web / Login Terlihat Berantakan (CSS Tidak Meload)**
  - **Solusi**: Biasakan menjalankan ulang kompilasi asset jika kamu mendownload resource baru. Jalankan `npm run build`.

---

## 💾 Struktur Database dan Relasi

Aplikasi ini menggunakan sistem Relational Database berbasis MySQL (`ukk_laravel`).
Berikut penjelasan tabel-tabel utama yang dipakai (selain tabel bawaan Laravel seperti jobs, sessions, dll):

**1. Tabel `users`**
- Tabel bawaan Laravel yang kami gunakan untuk menyimpan data otentikasi.
- **Kolom Utama**: `id` (PK), `name`, `email`, `password`.

**2. Tabel `kategoris` (Kategori Alat)**
- Menyimpan pengelompokan jenis alat yang tersedia.
- **Kolom Utama**: `id` (PK), `nama_kategori`.
- **Relasi**: *One-to-Many* dengan tabel `alats`. (1 Kategori bisa dimiliki banyak alat).

**3. Tabel `alats` (Inventaris Alat Utama)**
- Menyimpan detail inventaris alat laboratorium.
- **Kolom Utama**: `id` (PK), `nama_alat`, `stok`, `kondisi`, `kategori_id` (FK ke `kategoris`).

**4. Tabel `peminjamans` (Data Transaksi Peminjaman)**
- Mengatur data header setiap kali ada peminjaman.
- **Kolom Utama**: `id` (PK), `user_id` (FK ke `users`), `tanggal_pinjam`, `tanggal_kembali`, `status` (menunggu, disetujui, ditolak, dikembalikan).
- **Relasi**: *One-to-Many* terhadap `detail_peminjamans`.

**5. Tabel `detail_peminjamans` (Keranjang / Detail Alat yang Dipinjam)**
- Mengatur *item* apa saja dan jumlah alat pada satu ID transaksi peminjaman.
- **Kolom Utama**: `id` (PK), `peminjaman_id` (FK ke `peminjamans`), `alat_id` (FK ke `alats`), `jumlah`.
- **Relasi**: Bergabung via peminjaman dan menarik detail Alat. (*Foreign Keys: Cascade On Delete*).

**6. Tabel `pengembalians` (Data Transaksi Pengembalian)**
- Mengatur pencatatan riwayat kapan alat benar-benar dikembalikan dan jika ada denda.
- **Kolom Utama**: `id` (PK), `peminjaman_id` (FK ke `peminjamans`), `tanggal_dikembalikan`, `denda`.

**[BARU] 7. Database Triggers (Keamanan & Konsistensi Stok)**
Aplikasi ini dipasangi *Database Triggers* pada level MySQL murni. Ini wajib digunakan (tercantum di file `ukk_laravel.sql`) agar stok alat otomatis ter-update dan data sangat sulit bocor/selisih:
- **`tg_kurangi_stok`**: Bekerja ketika Admin / Petugas mengubah `status` peminjaman menjadi `disetujui`. Otomatis mengurangi kolom `stok` di tabel `alats` sejumlah alat yang dipinjam.
- **`tg_tambah_stok`**: Bekerja ketika Peminjam / Petugas menginput data ke tabel `pengembalians`. Otomatis menambah kembali kolom `stok` di tabel `alats` sejumlah alat yang dikembalikan.

*(File `ukk_laravel.sql` berisi skema dan DDL tabel ini telah digenerate beserta dummy datanya pada root proyek)*

---

## 📁 Penjelasan Struktur Folder Penting (Custom / Diubah Dari Bawaan)

Project ini telah disesuaikan strukturnya. Folder yang krusial untuk dipelajari selama proses development:

1. **`app/Http/Controllers/`**
   Tempat logika bisnis berjalan. Di sinilah tersimpan file Controller seperti `AlatController`, `PeminjamanController`, `DashboardController`, dll.
2. **`resources/views/`**
   Tempat seluruh tata letak / HTML (Blade) disimpan.
   - `auth/`: View untuk Halaman Login / Register.
   - `layouts/`: Template luar dari aplikasi (komponen header, navigasi sidebar).
   - *File blade lainnya ada di sub-folder berdasarkan fitur.*
3. **`routes/web.php`**
   File daftar rute aplikasi. Mencatat rute URL web apa yang digunakan beserta middleware (seperti pengecekan apakah user sudah login/belum sebelum bisa akses `/dashboard`).
4. **`database/migrations/`**
   Tempat cetak biru (Blueprint) struktul tabel dari database didefinisikan secara kode dengan urutan pembuatan (`down` / `up`).
# peminjaman-alat-v2
