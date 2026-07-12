# 📚 SEMAR JKB — Sistem Manajemen Sidang Akademik

**SEMAR JKB** adalah aplikasi web berbasis **Laravel 12** untuk mengelola seluruh alur proses sidang akademik, mulai dari pengajuan proposal oleh mahasiswa, verifikasi oleh admin, penjadwalan sidang, hingga penilaian oleh dosen penguji. Sistem ini dirancang untuk Jurusan/Prodi dengan tiga peran utama: **Mahasiswa**, **Admin**, dan **Dosen**.

---

## ✨ Fitur Utama

### 🎓 Mahasiswa
- Mengajukan proposal sidang (Seminar Proposal, Seminar Hasil, Tugas Akhir)
- Mengunggah dokumen draf proposal dalam format PDF
- Melihat status pengajuan secara real-time (Pending → Terverifikasi → Dijadwalkan → Lulus)
- Melihat jadwal sidang yang telah ditetapkan
- Melakukan revisi pengajuan jika diminta oleh admin
- Menghapus pengajuan yang masih berstatus *pending*

### 🛡️ Admin
- Dashboard statistik dinamis dengan ringkasan data sistem (total pengajuan, jadwal, pengguna)
- Memverifikasi atau menolak pengajuan mahasiswa beserta catatan
- Mengelola penjadwalan sidang (CRUD: tambah, ubah, hapus) dengan validasi tabrakan jadwal
- Menentukan dosen penguji 1 dan penguji 2 untuk setiap sidang
- Mengelola data pengguna — tambah, ubah, hapus (Soft Delete)
- Melihat rekapitulasi hasil sidang dengan fitur cetak
- Menghapus (reset) penilaian dosen jika diperlukan

### 👨‍🏫 Dosen
- Dashboard ringkasan tugas penguji (total jadwal, sidang hari ini, menunggu penilaian)
- Melihat jadwal sidang yang ditugaskan sebagai penguji
- Memberikan penilaian sidang (Presentasi, Materi, Tanya Jawab)
- Memberikan catatan revisi untuk mahasiswa
- Mengunci penilaian agar tidak bisa diubah lagi (`is_locked`)

### 🔐 Umum
- Autentikasi lengkap (Register, Login, Logout) menggunakan **Laravel Breeze**
- Sistem role-based access control (RBAC) via custom `RoleMiddleware`
- Manajemen profil pengguna (edit nama, email, avatar, prodi)
- Akses dokumen yang aman melalui `DocumentController`
- Flash message system untuk notifikasi sukses/gagal
- Validasi input server-side menggunakan **Form Request** classes
- **Soft Deletes** pada tabel `users` dan `submissions`

---

## 🛠️ Teknologi yang Digunakan

| Komponen       | Teknologi                        |
| -------------- | -------------------------------- |
| Framework      | Laravel 12                       |
| PHP            | >= 8.2                           |
| Autentikasi    | Laravel Breeze                   |
| Frontend       | Blade, TailwindCSS, Alpine.js    |
| Build Tool     | Vite 6                           |
| Database       | MySQL                            |
| Server Lokal   | XAMPP / Laravel Artisan Serve    |

---

## 📂 Struktur Database

Sistem ini menggunakan **5 tabel utama** dan **3 tabel penunjang**:

### Tabel Utama

#### `users`
| Kolom              | Tipe         | Keterangan                          |
| ------------------ | ------------ | ----------------------------------- |
| id                 | bigint (PK)  | Primary key                         |
| name               | string       | Nama lengkap pengguna               |
| email              | string       | Email (unique)                      |
| nim_nip            | string       | NIM/NIP (unique, nullable)          |
| role               | enum         | `admin`, `dosen`, `mahasiswa`       |
| avatar             | string       | Path foto profil (nullable)         |
| prodi              | string       | Program studi (nullable)            |
| password           | string       | Password (hashed)                   |
| deleted_at         | timestamp    | Soft Delete marker                  |

#### `submissions`
| Kolom              | Tipe         | Keterangan                                                                       |
| ------------------ | ------------ | -------------------------------------------------------------------------------- |
| id                 | bigint (PK)  | Primary key                                                                      |
| user_id            | FK → users   | Mahasiswa pemilik pengajuan                                                      |
| supervisor_id      | FK → users   | Dosen pembimbing                                                                 |
| type               | enum         | `sempro`, `semhas`, `ta`                                                         |
| title              | string       | Judul proposal                                                                   |
| document_path      | string       | Path file PDF draf                                                               |
| status             | enum         | `pending`, `revisi_tu`, `terverifikasi`, `dijadwalkan`, `revisi_dosen`, `lulus`  |
| admin_notes        | text         | Catatan dari admin (nullable)                                                    |
| deleted_at         | timestamp    | Soft Delete marker                                                               |

#### `schedules`
| Kolom              | Tipe         | Keterangan                          |
| ------------------ | ------------ | ----------------------------------- |
| id                 | bigint (PK)  | Primary key                         |
| submission_id      | FK → submissions | Pengajuan yang dijadwalkan      |
| date               | date         | Tanggal sidang                      |
| time_start         | time         | Jam mulai                           |
| time_end           | time         | Jam selesai                         |
| room               | string       | Ruangan sidang                      |
| examiner_1_id      | FK → users   | Dosen penguji 1                     |
| examiner_2_id      | FK → users   | Dosen penguji 2                     |

#### `assessments`
| Kolom              | Tipe         | Keterangan                              |
| ------------------ | ------------ | --------------------------------------- |
| id                 | bigint (PK)  | Primary key                             |
| schedule_id        | FK → schedules | Jadwal sidang yang dinilai            |
| examiner_id        | FK → users   | Dosen yang memberikan penilaian         |
| score_presentation | integer      | Nilai presentasi (default: 0)           |
| score_material     | integer      | Nilai materi (default: 0)               |
| score_qna          | integer      | Nilai tanya jawab (default: 0)          |
| total_score        | decimal(5,2) | Total skor (default: 0)                 |
| revision_notes     | text         | Catatan revisi (nullable)               |
| is_locked          | boolean      | Status kunci penilaian (default: false) |

#### `revisions`
| Kolom                    | Tipe         | Keterangan                      |
| ------------------------ | ------------ | ------------------------------- |
| id                       | bigint (PK)  | Primary key                     |
| submission_id            | FK → submissions | Pengajuan terkait           |
| final_document_path      | string       | File laporan final (nullable)   |
| is_approved_by_supervisor| boolean      | Status ACC dosen pembimbing     |

### Relasi Antar Tabel

```
User (mahasiswa) ──┐
                   ├──> Submission ──> Schedule ──> Assessment
User (dosen)    ───┘                      │
                                          └──> Revision
```

- Satu **Mahasiswa** dapat memiliki banyak **Submission** (pengajuan)
- Satu **Submission** memiliki satu **Dosen Pembimbing** (`supervisor_id`)
- Satu **Submission** memiliki satu **Schedule** (jadwal sidang)
- Satu **Schedule** memiliki 2 **Dosen Penguji** (`examiner_1_id` & `examiner_2_id`)
- Satu **Schedule** memiliki banyak **Assessment** (penilaian dari tiap penguji)
- Satu **Submission** memiliki satu **Revision** (laporan revisi final)

---

## 🚀 Cara Instalasi

### Prasyarat

- **PHP** >= 8.2
- **Composer** (versi terbaru)
- **Node.js** >= 18 & **NPM**
- **MySQL** (via XAMPP atau standalone)
- **Git**

### Langkah-langkah

1. **Clone repository**
   ```bash
   git clone https://github.com/username/project-pbf.git
   cd project-pbf
   ```

2. **Install dependensi PHP**
   ```bash
   composer install
   ```

3. **Install dependensi Node.js**
   ```bash
   npm install
   ```

4. **Salin file konfigurasi environment**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Konfigurasi database**

   Buka file `.env` dan sesuaikan pengaturan database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_semar_jkb
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   > **Catatan:** Pastikan database `db_semar_jkb` sudah dibuat terlebih dahulu di MySQL.

7. **Jalankan migrasi dan seeder**
   ```bash
   php artisan migrate --seed
   ```

8. **Buat symbolic link untuk storage**
   ```bash
   php artisan storage:link
   ```

9. **Jalankan server development**
   ```bash
   # Terminal 1: Laravel server
   php artisan serve

   # Terminal 2: Vite (untuk kompilasi asset)
   npm run dev
   ```

   Atau jalankan keduanya sekaligus:
   ```bash
   composer run dev
   ```

10. **Akses aplikasi**

    Buka browser dan kunjungi: [http://localhost:8000](http://localhost:8000)

---

## 👥 Akun Demo (Seeder)

Setelah menjalankan `php artisan migrate --seed`, tersedia 3 akun demo:

| Peran      | Email                | Password   | NIM/NIP              |
| ---------- | -------------------- | ---------- | -------------------- |
| Admin      | admin@pnc.ac.id      | `password` | 198001012000031001   |
| Dosen      | dosen@pnc.ac.id      | `password` | 197502022005011002   |
| Mahasiswa  | mahasiswa@pnc.ac.id  | `password` | 240202001            |

---

## 👥 Peran Pengguna (Roles)

| Peran      | Deskripsi                                                  |
| ---------- | ---------------------------------------------------------- |
| Mahasiswa  | Mengajukan sidang, mengunggah dokumen, melihat jadwal      |
| Admin      | Memverifikasi pengajuan, menjadwalkan sidang, kelola data  |
| Dosen      | Menilai sidang, memberikan catatan revisi                  |

---

## 📁 Struktur Direktori Utama

```
project-pbf/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                    # Controller untuk peran Admin
│   │   │   │   ├── AssessmentController.php    # Reset penilaian
│   │   │   │   ├── DashboardController.php     # Statistik dashboard
│   │   │   │   ├── ScheduleController.php      # CRUD jadwal + rekapitulasi
│   │   │   │   ├── UserController.php          # CRUD pengguna
│   │   │   │   └── VerificationController.php  # Approve/reject pengajuan
│   │   │   ├── Dosen/                    # Controller untuk peran Dosen
│   │   │   │   ├── AssessmentController.php    # Form penilaian sidang
│   │   │   │   ├── DashboardController.php     # Ringkasan tugas penguji
│   │   │   │   └── ScheduleController.php      # Lihat jadwal ditugaskan
│   │   │   ├── Mahasiswa/                # Controller untuk peran Mahasiswa
│   │   │   │   ├── DashboardController.php     # Ringkasan status pengajuan
│   │   │   │   ├── ScheduleController.php      # Lihat jadwal sidang
│   │   │   │   └── SubmissionController.php    # CRUD pengajuan proposal
│   │   │   ├── Auth/                     # Controller autentikasi (Breeze)
│   │   │   ├── DocumentController.php    # Akses file dokumen aman
│   │   │   └── ProfileController.php     # Manajemen profil pengguna
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php        # Middleware custom RBAC
│   │   └── Requests/                     # Form Request Validation
│   │       ├── StoreAssessmentRequest.php
│   │       ├── StoreScheduleRequest.php
│   │       ├── StoreSubmissionRequest.php
│   │       ├── StoreUserRequest.php
│   │       ├── UpdateScheduleRequest.php
│   │       ├── UpdateSubmissionRequest.php
│   │       └── UpdateUserRequest.php
│   └── Models/
│       ├── User.php                      # + SoftDeletes
│       ├── Submission.php                # + SoftDeletes
│       ├── Schedule.php
│       ├── Assessment.php
│       └── Revision.php
├── database/
│   ├── migrations/                       # 10 file migrasi database
│   └── seeders/
│       └── DatabaseSeeder.php            # 3 akun demo (admin, dosen, mhs)
├── resources/views/
│   ├── admin/                            # Tampilan halaman Admin
│   │   ├── dashboard.blade.php
│   │   ├── jadwal.blade.php
│   │   ├── pengguna.blade.php
│   │   ├── rekapitulasi.blade.php
│   │   └── verifikasi.blade.php
│   ├── dosen/                            # Tampilan halaman Dosen
│   │   ├── dashboard.blade.php
│   │   ├── jadwal.blade.php
│   │   └── penilaian.blade.php
│   ├── mahasiswa/                        # Tampilan halaman Mahasiswa
│   │   ├── dashboard.blade.php
│   │   ├── jadwal.blade.php
│   │   └── pengajuan.blade.php
│   ├── auth/                             # Tampilan halaman autentikasi
│   ├── layouts/                          # Template layout
│   │   ├── app.blade.php                 # Layout utama (sidebar + navbar)
│   │   ├── guest.blade.php               # Layout halaman tamu
│   │   ├── sidebar.blade.php             # Sidebar navigasi per-role
│   │   ├── navbar.blade.php              # Top navigation bar
│   │   ├── footer.blade.php              # Footer
│   │   ├── _flash.blade.php              # Notifikasi flash message
│   │   └── navigation.blade.php          # Navigasi Breeze bawaan
│   ├── components/                       # Komponen Blade reusable (13 file)
│   ├── profile/                          # Halaman profil pengguna
│   └── welcome.blade.php                # Landing page
├── routes/
│   └── web.php                           # Definisi seluruh rute aplikasi
└── public/                               # File publik (CSS, JS, gambar)
```

---

## 🔄 Alur Kerja Sistem

```
┌─────────────┐     ┌──────────────┐     ┌───────────────┐     ┌────────────────┐
│  Mahasiswa   │────>│    Admin      │────>│    Admin       │────>│   Dosen        │
│  Mengajukan  │     │  Memverifikasi│     │  Menjadwalkan  │     │  Menilai       │
│  Proposal    │     │  Pengajuan    │     │  Sidang        │     │  Sidang        │
└─────────────┘     └──────────────┘     └───────────────┘     └────────────────┘
      │                    │                      │                      │
      ▼                    ▼                      ▼                      ▼
   [pending]     [terverifikasi/revisi_tu]   [dijadwalkan]    [lulus/revisi_dosen]
```

1. **Mahasiswa** mengajukan proposal sidang dengan mengunggah dokumen PDF
2. **Admin** memverifikasi kelengkapan berkas (setujui atau minta revisi)
3. **Admin** menjadwalkan sidang dan menentukan dosen penguji 1 & 2
4. **Dosen Penguji** memberikan penilaian (Presentasi, Materi, Tanya Jawab) dan catatan revisi
5. **Dosen** mengunci penilaian setelah final → status mahasiswa: **Lulus** atau **Revisi Dosen**

---

## ⚙️ Komponen Penilaian

| Komponen     | Kolom DB             | Keterangan                             |
| ------------ | -------------------- | -------------------------------------- |
| Presentasi   | `score_presentation` | Nilai kemampuan presentasi mahasiswa   |
| Materi       | `score_material`     | Nilai penguasaan materi/konten         |
| Tanya Jawab  | `score_qna`          | Nilai kemampuan menjawab pertanyaan    |
| Total Skor   | `total_score`        | Perhitungan total dari ketiga komponen |

---

## 🛡️ Keamanan & Validasi

| Fitur                | Implementasi                                    |
| -------------------- | ----------------------------------------------- |
| Autentikasi          | Laravel Breeze (session-based)                  |
| Otorisasi            | Custom `RoleMiddleware` per route group          |
| Validasi Input       | 7 Form Request classes (Store & Update)          |
| Soft Deletes         | Pada tabel `users` dan `submissions`             |
| Akses Dokumen        | `DocumentController` — hanya user login          |
| Penguncian Penilaian | Field `is_locked` pada tabel `assessments`       |

---

## 📝 Lisensi

Proyek ini dikembangkan sebagai tugas mata kuliah **Pemrograman Berbasis Framework (PBF)**.

---

## 🤝 Kontributor

Dikembangkan oleh mahasiswa sebagai proyek akhir mata kuliah PBF.
