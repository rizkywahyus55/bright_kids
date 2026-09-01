# 📘 DOKUMEN ARSITEKTUR & IMPLEMENTASI SISTEM BRIGHT KIDS
**Sistem Informasi & Manajemen Bimbingan Belajar Membaca & Menulis Anak Usia Dini**
*Disusun untuk: Bright Kids (Barijanti, S.Pd. — TK PGRI 105 Semarang)*

---

## DAFTAR ISI
1. [Ringkasan Eksekutif & Karakteristik Sistem](#1-ringkasan-eksekutif--karakteristik-sistem)
2. [Arsitektur Proyek & Struktur Direktori](#2-arsitektur-proyek--struktur-direktori)
3. [Analisis Frontend & Desain Antarmuka](#3-analisis-frontend--desain-antarmuka)
4. [Analisis Backend & Alur Kerja Server](#4-analisis-backend--alur-kerja-server)
5. [Penerapan Konsep Object-Oriented Programming (OOP)](#5-penerapan-konsep-object-oriented-programming-oop)
6. [Seluruh Integrasi API & Layanan Eksternal](#6-seluruh-integrasi-api--layanan-eksternal)
7. [Skema Basis Data & Data Dictionary (ERD)](#7-skema-basis-data--data-dictionary-erd)
8. [Penjelasan Rinci Seluruh File & Komponen Kode](#8-penjelasan-rinci-seluruh-file--komponen-kode)
9. [Keamanan, Validasi & Integritas Data](#9-keamanan-validasi--integritas-data)
10. [Panduan Instalasi & Deployment](#10-panduan-instalasi--deployment)

---

## 1. RINGKASAN EKSEKUTIF & KARAKTERISTIK SISTEM

### 1.1 Profil Bimbel Bright Kids
**Bright Kids** adalah platform sistem informasi dan manajemen bimbingan belajar khusus membaca dan menulis tanpa mengeja untuk anak usia dini (TK Kecil, TK Besar, hingga SD Kelas 1–3). Bimbel ini dibimbing langsung oleh **Ibu Barijanti, S.Pd.**, seorang pengajar berdedikasi dari TK PGRI 105 Semarang yang berlokasi di Jl. Sidodrajat No. 57, Semarang.

### 1.2 Tujuan Pembangunan Sistem
- **Digitalisasi Pendaftaran:** Mempermudah orang tua mendaftarkan anak secara daring tanpa perlu datang langsung untuk mengisi formulir kertas.
- **Transparansi Tracking:** Memberikan kode pendaftaran instan agar wali murid dapat mengecek status penerimaan, riwayat pembayaran, hingga perkembangan belajar anak secara mandiri.
- **Otomatisasi Pembayaran (Midtrans):** Menyediakan opsi pembayaran digital modern (GoPay, QRIS, Virtual Account Bank) dengan verifikasi otomatis, disamping metode pembayaran tunai kasir.
- **Manajemen Operasional Terpadu (Admin Panel):** Memudahkan pengajar dalam mengelola jadwal belajar, kuota sesi (maks. 4 anak per sesi), absensi harian, pembuatan rapor perkembangan anak (ekspor PDF), dan pencatatan kas.

### 1.3 Peran Pengguna (*Actors*)
| Peran (*Actor*) | Hak Akses (*Privileges*) | Antarmuka (*Interface*) |
|---|---|---|
| **Publik / Orang Tua Murid** | Melihat profil & jadwal, pendaftaran online, tracking status, bayar Midtrans, unduh rapor PDF, chat WA. | Frontend Portal (`/`, `/pendaftaran/status/{code}`) |
| **Admin / Pengajar (Ibu Barijanti)** | Manajemen jadwal, verifikasi pendaftar, input presensi, buat laporan belajar, kasir manual, cetak kwitansi, ubah pengaturan web. | Backend Admin Panel (`/admin/*`) |

---

## 2. ARSITEKTUR PROYEK & STRUKTUR DIREKTORI

Proyek ini dibangun menggunakan **Laravel 12 (PHP 8.2+)** dengan pola desain **Model-View-Controller (MVC)**.

```
bright_kids/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Controller.php                    # Base Controller
│   │       ├── LandingController.php             # Handler Landing Page & Dynamic Settings
│   │       ├── RegistrationController.php        # Form Pendaftaran & Tracking Status Publik
│   │       ├── PaymentController.php             # Midtrans Snap Token & Webhook Notification
│   │       └── Admin/
│   │           ├── Auth/
│   │           │   └── LoginController.php       # Login Guard Admin + RateLimiter Throttling
│   │           ├── DashboardController.php       # Agregasi Metrik & Aktivitas Terkini
│   │           ├── ScheduleController.php        # CRUD Jadwal Belajar & Toggle Status
│   │           ├── RegistrationController.php    # Verifikasi & Manajemen Pendaftaran
│   │           ├── StudentController.php         # Manajemen Direktori Murid & Wali
│   │           ├── AttendanceController.php      # Pencatatan Presensi Pertemuan & Murid
│   │           ├── ProgressReportController.php  # CRUD Laporan Perkembangan & Download PDF
│   │           ├── PaymentController.php         # Kasir Manual, Status Pembayaran & Kwitansi
│   │           └── SettingController.php         # Pengaturan Profil, Biaya & Banner Foto
│   └── Models/
│       ├── Admin.php                             # Authenticatable Admin Model
│       ├── Attendance.php                        # Presensi Kehadiran Siswa
│       ├── Meeting.php                           # Sesi Pertemuan Kelas
│       ├── ParentModel.php                       # Data Orang Tua / Wali
│       ├── Payment.php                           # Transaksi Pembayaran (Midtrans / Tunai)
│       ├── ProgressReport.php                    # Laporan Perkembangan Belajar
│       ├── Registration.php                      # Transaksi Pendaftaran Siswa
│       ├── Schedule.php                          # Jadwal Sesi Belajar
│       ├── Setting.php                           # Key-Value Configuration Store
│       ├── Student.php                           # Data Pokok Murid
│       └── User.php                              # Default User Model
├── config/
│   ├── app.php                                   # Konfigurasi Aplikasi (Timezone: Asia/Jakarta, Locale: id)
│   ├── auth.php                                  # Multi-auth guards (web & admin)
│   ├── database.php                              # Database Drivers (MySQL/SQLite)
│   ├── filesystems.php                           # Storage Disk Public untuk Foto Guru
│   └── midtrans.php                              # Midtrans Environment Configuration
├── database/
│   ├── migrations/                               # 14 Schema Migrations
│   └── seeders/
│       └── DatabaseSeeder.php                    # Inisialisasi Akun Admin, Jadwal & Default Settings
├── public/
│   ├── index.php                                 # Single Entry Point HTTP Request
│   └── storage/                                  # Symlink ke storage/app/public
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php                     # Layout Utama Publik (Navbar, Footer, WA Floating)
│       │   └── admin.blade.php                   # Layout Panel Admin (Sidebar, Header, Alert, Modal)
│       ├── public/
│       │   ├── index.blade.php                   # Landing Page Interaktif & Form Pendaftaran
│       │   └── status.blade.php                  # Tracking Pendaftaran, Bayar Midtrans & Cek Rapor
│       ├── pdf/
│       │   └── progress_report.blade.php         # Template Resmi PDF Laporan Perkembangan
│       └── admin/                                # View Admin CRUD Lengkap
│           ├── auth/login.blade.php
│           ├── dashboard.blade.php
│           ├── attendances/                      # create.blade.php, index.blade.php
│           ├── payments/                         # index.blade.php, create.blade.php, receipt.blade.php
│           ├── progress_reports/                 # index.blade.php, create.blade.php, edit.blade.php, pdf.blade.php
│           ├── registrations/                    # index.blade.php, create.blade.php, show.blade.php
│           ├── schedules/                        # index.blade.php
│           ├── settings/                         # index.blade.php
│           └── students/                         # index.blade.php, show.blade.php, edit.blade.php
├── routes/
│   ├── web.php                                   # Routing Web Publik & Admin Panel
│   ├── api.php                                   # Webhook Midtrans & AJAX Jadwal Aktif
│   └── console.php                               # Artisan Console Commands
├── storage/
│   ├── app/public/teacher/                       # Direktori File Foto Pengajar
│   └── logs/laravel.log                          # System Execution & Error Logs
└── composer.json                                 # Dependency Definitions
```

---

## 3. ANALISIS FRONTEND & DESAIN ANTARMUKA

### 3.1 Design System & Tipografi
- **CSS Framework:** Tailwind CSS (dikustomisasi via Script Configuration).
- **Tipografi:** Google Fonts `Plus Jakarta Sans` (400, 500, 600, 700, 800) untuk keterbacaan tinggi.
- **Palet Warna:**
  - *Primary Blue / Sky:* `#0284c7` (Sky-500), `#0369a1` (Sky-700) — mencerminkan kecerdasan, ketenangan, dan pendidikan.
  - *Warm Amber:* `#f59e0b` (Amber-500), `#fbbf24` (Amber-400) — mencerminkan keceriaan dan keramahan anak-anak.
  - *Slate Neutral:* `#0f172a`, `#1e293b`, `#f8fafc` — kontras elegan dan profesional.
- **Ikonografi:** FontAwesome 6.5.1 Pro/Free Vector Icons.
- **Custom Scrollbar:** Diatur dengan WebKit Scrollbar kustom pada global body, sidebar navigasi admin, dan panel utama.

### 3.2 Halaman Publik
1. **Landing Page (`public/index.blade.php`):**
   - **Hero Section:** Headline dinamis, badge rating, tombol CTA pendaftaran cepat, serta preview statistik.
   - **Metode Belajar:** Edukasi visual 4 langkah belajar tanpa mengeja (Pengenalan Simbol $\rightarrow$ Suku Kata Intuitif $\rightarrow$ Kata Bermakna $\rightarrow$ Kalimat Sederhana).
   - **Profil Pengajar:** Menampilkan profil Ibu Barijanti, S.Pd., foto pengajar, sertifikasi, pengalaman 10+ tahun di TK PGRI 105 Semarang.
   - **Jadwal & Kuota Sesi:** Menampilkan daftar sesi sore dan malam dengan status kuota real-time.
   - **Biaya & Fasilitas:** Menampilkan rincian biaya pendaftaran (Rp 50.000) dan SPP bulanan (Rp 150.000).
   - **Formulir Pendaftaran Online:** Validasi langsung untuk data murid, orang tua, dan pemilihan jadwal aktif.
   - **Peta Lokasi:** Google Maps Iframe responsif dan informasi alamat lengkap.
2. **Halaman Tracking Status (`public/status.blade.php`):**
   - **Mesin Pencarian Cerdas:** Menerima input Kode Pendaftaran (`BK-2026-0001`), Nomor WhatsApp Orang Tua, maupun Nama Lengkap Anak.
   - **Timeline Status:** Menampilkan indikator visual status (*Menunggu Verifikasi* $\rightarrow$ *Terverifikasi / Aktif* $\rightarrow$ *Nonaktif*).
   - **Panel Pembayaran Digital:** Terkoneksi ke Midtrans Snap SDK untuk eksekusi pembayaran langsung di browser.
   - **Riwayat Perkembangan Belajar:** Menampilkan daftar rapor murid lengkap dengan tombol pratinjau & cetak PDF.

### 3.3 Halaman Admin Panel (`resources/views/admin/*`)
- **Responsive Layout (`layouts/admin.blade.php`):** Dilengkapi collapsible sidebar, header interaktif dengan profile menu, flash alerts (SweetAlert/Tailwind alerts), dan modal konfirmasi.
- **Dashboard (`admin/dashboard.blade.php`):** 5 kartu metrik utama (Total Siswa Aktif, Pendaftaran Baru, Tagihan Pending, Pertemuan Hari Ini, Kehadiran Hari Ini) serta tabel 5 transaksi dan pendaftar terbaru.
- **Data Table:** Dilengkapi fitur pencarian (*search filter*), filter status, filter jadwal, dan paginasi 15 data per halaman.

---

## 4. ANALISIS BACKEND & ALUR KERJA SERVER

### 4.1 Routing Architecture (`routes/web.php` & `routes/api.php`)

```mermaid
flowchart TD
    User([Pengunjung / Orang Tua]) -->|GET /| Landing[LandingController@index]
    User -->|POST /pendaftaran| Register[RegistrationController@store]
    User -->|GET /pendaftaran/status| Status[RegistrationController@status]
    User -->|POST /pembayaran/snap| Snap[PaymentController@getSnapToken]
    
    Midtrans([Midtrans Gateway]) -->|POST /api/midtrans/notification| Webhook[PaymentController@handleNotification]
    
    Admin([Ibu Barijanti / Admin]) -->|GET /admin/login| Login[LoginController@showLoginForm]
    Admin -->|POST /admin/login| AuthAttempt[LoginController@login - RateLimited]
    
    subgraph Protected Admin Guard [auth:admin Middleware]
        Dashboard[DashboardController@index]
        Jadwal[ScheduleController Resource]
        Pendaftaran[AdminRegistrationController Resource]
        Siswa[StudentController Resource]
        Absensi[AttendanceController Resource]
        Laporan[ProgressReportController Resource]
        Pembayaran[AdminPaymentController Resource]
        Pengaturan[SettingController Resource]
    end
    
    AuthAttempt -->|Valid| Protected Admin Guard
```

### 4.2 Alur Pendaftaran & Verifikasi Murid
1. Wali murid mengisi form pendaftaran di Landing Page.
2. `RegistrationController@store` memvalidasi input, membuat entitas `Student`, `ParentModel`, `Registration` (dengan kode unik `BK-YYYY-XXXX`), serta tagihan awal `Payment` berstatus `pending`.
3. Pendaftar diarahkan ke halaman status pendaftaran.
4. Admin dapat memverifikasi pendaftaran di menu Admin Pendaftaran:
   - Jika status diubah menjadi `terverifikasi`, status siswa di tabel `students` otomatis disinkronkan menjadi `aktif`.
   - Jika ditolak, status siswa menjadi `nonaktif`.

### 4.3 Alur Presensi Pertemuan (Absensi)
1. Guru memilih Jadwal Sesi dan Tanggal Pertemuan di menu Admin Absensi.
2. Sistem otomatis menarik daftar seluruh siswa berstatus `terverifikasi` yang terdaftar pada jadwal sesi tersebut.
3. Guru menandai kehadiran: *Hadir*, *Izin*, *Sakit*, atau *Alpa* beserta catatan singkat.
4. Sistem menggunakan `Meeting::firstOrCreate()` dan `Attendance::updateOrCreate()` sehingga data dapat diedit ulang sewaktu-waktu tanpa terjadi duplikasi data pertemuan.

---

## 5. PENERAPAN KONSEP OBJECT-ORIENTED PROGRAMMING (OOP)

| Prinsip OOP | Implementasi di Proyek Bright Kids | Contoh File & Kode |
|---|---|---|
| **Encapsulation (Enkapsulasi)** | - Pembatasan akses variabel dan mutasi data lewat properti `$fillable` dan `$casts`.<br>- Konstanta keamanan privat pada controller autentikasi. | [Student.php](file:///c:/xampp/htdocs/bright_kids/app/Models/Student.php): `$fillable = [...]`, `$casts = ['date_of_birth' => 'date']`<br>[LoginController.php](file:///c:/xampp/htdocs/bright_kids/app/Http/Controllers/Admin/Auth/LoginController.php): `private const MAX_ATTEMPTS = 5;` |
| **Inheritance (Pewarisan)** | - Pewarisan hierarki class Framework Laravel.<br>- Controller mewarisi `App\Http\Controllers\Controller`.<br>- Admin Model mewarisi `Illuminate\Foundation\Auth\User as Authenticatable`. | [Admin.php](file:///c:/xampp/htdocs/bright_kids/app/Models/Admin.php): `class Admin extends Authenticatable`<br>[LandingController.php](file:///c:/xampp/htdocs/bright_kids/app/Http/Controllers/LandingController.php): `class LandingController extends Controller` |
| **Polymorphism & Dynamic Accessors** | - Penyesuaian representasi data dinamis berbasis nilai atribut (*Virtual Attributes*).<br>- Penggunaan ekspresi PHP 8 `match()` untuk formatting label. | [Student.php](file:///c:/xampp/htdocs/bright_kids/app/Models/Student.php): `public function getClassLevelLabelAttribute(): string { return match($this->class_level) {...}; }`<br>[Schedule.php](file:///c:/xampp/htdocs/bright_kids/app/Models/Schedule.php): `public function getFormattedTimeAttribute(): string` |
| **Abstraction & Facades** | - Pengabstraksian query database melalui Eloquent ORM.<br>- Pengabstraksian HTTP Midtrans client via `\Midtrans\Snap`.<br>- Pengabstraksian PDF rendering via `Barryvdh\DomPDF\Facade\Pdf`. | [PaymentController.php](file:///c:/xampp/htdocs/bright_kids/app/Http/Controllers/PaymentController.php): `\Midtrans\Snap::getSnapToken($params);`<br>[ProgressReportController.php](file:///c:/xampp/htdocs/bright_kids/app/Http/Controllers/Admin/ProgressReportController.php): `Pdf::loadView(...)` |
| **Relational Mapping** | - Pemodelan relasi antar objek (*One-to-One, One-to-Many, HasOneThrough, HasManyThrough, LatestOfMany*). | [Student.php](file:///c:/xampp/htdocs/bright_kids/app/Models/Student.php): `$this->hasOneThrough(ParentModel::class, Registration::class, ...)`<br>[Registration.php](file:///c:/xampp/htdocs/bright_kids/app/Models/Registration.php): `$this->hasOne(Payment::class)->latestOfMany()` |
| **Repository Helper Pattern** | - Pengelolaan key-value configuration terpusat via static helper methods. | [Setting.php](file:///c:/xampp/htdocs/bright_kids/app/Models/Setting.php): `Setting::getByKey($key, $default)` & `Setting::setKey($key, $value)` |

---

## 6. SELURUH INTEGRASI API & LAYANAN EKSTERNAL

### 6.1 Midtrans Payment Gateway (Snap API & Webhooks)
- **Library:** `midtrans/midtrans-php: ^2.6`
- **Konfigurasi:** Terintegrasi di [config/midtrans.php](file:///c:/xampp/htdocs/bright_kids/config/midtrans.php) dan dapat di-override melalui menu Pengaturan Admin.
- **Kredensial:**
  - `MIDTRANS_SERVER_KEY`: Digunakan di server-side untuk autentikasi API dan verifikasi signature webhook.
  - `MIDTRANS_CLIENT_KEY`: Digunakan di frontend JavaScript untuk inisialisasi `snap.js`.
  - `MIDTRANS_IS_PRODUCTION`: Sakelar boolean antara Sandbox (Testing) dan Production.
- **Keamanan Signature Webhook:**
  Setiap notifikasi webhook yang masuk diverifikasi keasliannya dengan rumus hashing SHA-512:
  $$\text{ValidSignature} = \text{hash}(\text{"sha512"}, \text{order\_id} + \text{status\_code} + \text{gross\_amount} + \text{server\_key})$$
  Jika hash yang dikirimkan Midtrans tidak cocok dengan hash internal, request ditolak dengan status HTTP 403 Forbidden.

### 6.2 WhatsApp Direct Communication API
- Menghubungkan orang tua murid dengan admin/pengajar tanpa perantara database pihak ketiga.
- Format URL standar internasional: `https://wa.me/6282137690701?text=...` dengan sanitasi otomatis awalan `0` menjadi `62` dan URL Encoding pesan kustom.

### 6.3 Google Maps Embed API
- Merender peta lokasi presisi bimbingan belajar Bright Kids di Semarang.
- Kode iframe Google Maps tersimpan di database dan dapat diperbarui secara dinamis oleh admin.

### 6.4 Barryvdh DomPDF Document Generator
- **Library:** `barryvdh/laravel-dompdf: ^3.1`
- Digunakan untuk merender dokumen berstandar cetak resmi:
  1. **Laporan Perkembangan Belajar Murid:** Dilengkapi kop surat resmi, identitas siswa, nilai membaca & menulis, ringkasan kehadiran, narasi perkembangan, rekomendasi guru, serta tanda tangan Ibu Barijanti, S.Pd.
  2. **Kwitansi / Nota Pembayaran Kasir:** Dilengkapi rincian biaya, tanggal bayar, metode pembayaran, nomor kode bayar, dan tanda tangan penerima kas.

---

## 7. SKEMA BASIS DATA & DATA DICTIONARY (ERD)

### 7.1 Tabel `admins`
Menyimpan akun pengajar/administrator untuk login ke panel admin.
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED (PK) | Auto increment |
| `name` | VARCHAR(255) | Nama lengkap admin (contoh: Barijanti, S.Pd.) |
| `email` | VARCHAR(255) (UNIQUE) | Email login (contoh: Barijanti@gmail.com) |
| `password` | VARCHAR(255) | Hash Bcrypt password (default: admin123) |
| `phone` | VARCHAR(20) | Nomor telepon pengajar |
| `created_at`, `updated_at` | TIMESTAMP | Audit timestamps |

### 7.2 Tabel `students`
Menyimpan data pokok murid bimbingan belajar.
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED (PK) | Auto increment |
| `full_name` | VARCHAR(255) | Nama lengkap anak |
| `date_of_birth` | DATE | Tanggal lahir anak |
| `class_level` | VARCHAR(50) | `tk_kecil`, `tk_besar`, `sd_1`, `sd_2`, `sd_3` |
| `school_origin` | VARCHAR(255) | Asal sekolah / TK anak |
| `status` | ENUM | `aktif`, `nonaktif` (default: `aktif`) |

### 7.3 Tabel `parents`
Menyimpan data orang tua / wali murid.
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED (PK) | Auto increment |
| `full_name` | VARCHAR(255) | Nama lengkap orang tua / wali |
| `whatsapp_number` | VARCHAR(20) | Nomor WhatsApp aktif untuk notifikasi & tracking |
| `address` | TEXT | Alamat domisili |

### 7.4 Tabel `schedules`
Menyimpan master data sesi jadwal belajar.
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED (PK) | Auto increment |
| `session_name` | VARCHAR(100) | Sesi 1 (Sore), Sesi 2 (Malam 1), Sesi 3 (Malam 2) |
| `day` | VARCHAR(100) | Hari belajar (contoh: Senin – Kamis) |
| `start_time` | TIME | Jam mulai (contoh: 16:00:00) |
| `end_time` | TIME | Jam selesai (contoh: 17:30:00) |
| `quota` | INT | Batas kuota per sesi (default: 4 anak) |
| `is_active` | BOOLEAN | Status aktif jadwal (default: true) |

### 7.5 Tabel `registrations`
Menyimpan transaksi formulir pendaftaran murid.
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED (PK) | Auto increment |
| `registration_code` | VARCHAR(50) (UNIQUE) | Format: `BK-YYYY-XXXX` |
| `student_id` | BIGINT UNSIGNED (FK) | Relasi ke `students.id` |
| `parent_id` | BIGINT UNSIGNED (FK) | Relasi ke `parents.id` |
| `schedule_id` | BIGINT UNSIGNED (FK) | Relasi ke `schedules.id` |
| `status` | ENUM | `menunggu_verifikasi`, `terverifikasi`, `ditolak`, `nonaktif` |
| `registered_at` | DATETIME | Waktu pendaftaran masuk |

### 7.6 Tabel `meetings` & `attendances`
Menyimpan agenda pertemuan dan catatan presensi harian siswa.
- **`meetings`**: `id`, `schedule_id` (FK), `meeting_date` (DATE), `notes` (TEXT).
- **`attendances`**: `id`, `meeting_id` (FK), `student_id` (FK), `status` (ENUM: `hadir`, `izin`, `sakit`, `alpa`), `notes` (TEXT).

### 7.7 Tabel `progress_reports`
Menyimpan catatan laporan perkembangan belajar berkala setiap siswa.
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED (PK) | Auto increment |
| `student_id` | BIGINT UNSIGNED (FK) | Relasi ke `students.id` |
| `period` | VARCHAR(100) | Periode evaluasi (contoh: Bulan Agustus 2026) |
| `current_stage` | VARCHAR(200) | Tahap capaian (contoh: Tahap 3 - Membaca Kalimat) |
| `reading_skill` | VARCHAR(100) | Nilai / Predikat Membaca (contoh: Sangat Lancar) |
| `writing_skill` | VARCHAR(100) | Nilai / Predikat Menulis (contoh: Rapi & Mandiri) |
| `attendance_summary` | VARCHAR(200) | Ringkasan kehadiran (contoh: 16 dari 16 Sesi Hadir) |
| `progress_narrative` | TEXT | Penjelasan detail kemajuan belajar anak |
| `recommendations` | TEXT | Rekomendasi latihan di rumah bagi orang tua |
| `created_by` | BIGINT UNSIGNED (FK) | Admin pembuat laporan |

### 7.8 Tabel `payments`
Menyimpan seluruh transaksi tagihan pendaftaran dan SPP bulanan.
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED (PK) | Auto increment |
| `registration_id` | BIGINT UNSIGNED (FK) | Relasi ke `registrations.id` |
| `payment_code` | VARCHAR(50) (UNIQUE) | Format: `PAY-XXXXXXXX` |
| `method` | VARCHAR(50) | `online` (Midtrans) atau `tunai` (Manual) |
| `amount` | DECIMAL(12,2) | Jumlah nominal tagihan (contoh: Rp 50.000 / Rp 150.000) |
| `status` | ENUM | `pending`, `lunas`, `kedaluwarsa`, `batal` |
| `midtrans_order_id` | VARCHAR(100) | Order ID unik pengenal Midtrans |
| `midtrans_transaction_id` | VARCHAR(100) | ID transaksi dari server Midtrans |
| `paid_at` | DATETIME | Waktu pelunasan transaksi |
| `recorded_by` | BIGINT UNSIGNED (FK) | Admin pencatat kas manual |
| `notes` | TEXT | Keterangan pembayaran (contoh: Biaya Awal / SPP Bulan X) |

### 7.9 Tabel `settings`
Tabel *key-value store* untuk seluruh parameter konfigurasi dinamis aplikasi.

---

## 8. PENJELASAN RINCI SELURUH FILE & KOMPONEN KODE

### 8.1 Controller Publik
1. **`app/Http/Controllers/LandingController.php`**
   - Mengambil seluruh jadwal belajar aktif dari database: `Schedule::orderBy('start_time')->get()`.
   - Mengambil seluruh setting website (judul, tagline, hero text, profil guru, kontak, biaya, alamat, maps iframe) via `Setting::getByKey()`.
   - Merender tampilan `public.index`.
2. **`app/Http/Controllers/RegistrationController.php`**
   - `store()`: Validasi form pendaftaran secara menyeluruh, simpan data Student, Parent, Registration, inisialisasi tagihan Payment, dan redirect ke halaman status.
   - `status()`: Mengambil data registrasi via query fleksibel (kode pendaftaran, no WA, atau nama anak), memuat relasi student, progress report, dan riwayat pembayaran, lalu merender `public.status`.
3. **`app/Http/Controllers/PaymentController.php`**
   - `getSnapToken()`: Mengonfigurasi parameter pembayaran, membuat entitas payment jika belum ada, inisialisasi Midtrans Snap Config, meminta Snap Token dari Midtrans, dan mengembalikan response JSON.
   - `handleNotification()`: Menerima callback webhook Midtrans, memverifikasi keaslian signature key SHA-512, dan memperbarui status pembayaran dan status pendaftaran secara otomatis.

### 8.2 Controller Admin
1. **`app/Http/Controllers/Admin/Auth/LoginController.php`**
   - Mengatur tampilan login admin, autentikasi guard `admin`, proteksi pembatasan percobaan login (Rate Limiter: maks 5x percobaan per 60 detik per IP/email), regenerasi session, dan logout aman.
2. **`app/Http/Controllers/Admin/DashboardController.php`**
   - Mengagregasi metrik: jumlah siswa aktif, pendaftaran menunggu verifikasi, pembayaran pending, sesi pertemuan hari ini, serta daftar pendaftar dan pembayaran terkini.
3. **`app/Http/Controllers/Admin/ScheduleController.php`**
   - Menangani pembuatan, pembaruan, penghapusan, dan pengubahan status aktif (*toggle status*) jadwal belajar sesi sore dan malam.
4. **`app/Http/Controllers/Admin/RegistrationController.php`**
   - Menampilkan direktori pendaftar, pencatatan pendaftaran offline langsung, verifikasi status penerimaan (`terverifikasi`, `ditolak`, `nonaktif`), serta penghapusan data berelasi bersih menggunakan `DB::transaction()`.
5. **`app/Http/Controllers/Admin/StudentController.php`**
   - Direktori murid aktif, edit data profil anak dan orang tua, melihat detail profil komprehensif (riwayat presensi, rapor, pembayaran), serta penghapusan data murid secara atomic.
6. **`app/Http/Controllers/Admin/AttendanceController.php`**
   - Manajemen presensi harian per jadwal dan tanggal pertemuan. Otomatis menarik daftar siswa aktif dan menyinkronkan status presensi setiap murid.
7. **`app/Http/Controllers/Admin/ProgressReportController.php`**
   - Input laporan kemajuan belajar siswa (kemampuan baca, tulis, narasi perkembangan, saran guru) dan render laporan resmi dalam format PDF yang dapat diunduh orang tua.
8. **`app/Http/Controllers/Admin/PaymentController.php`**
   - Kasir pembayaran tunai manual (pendaftaran & SPP bulanan), konfirmasi pelunasan tagihan, serta pembuatan bukti kwitansi pembayaran resmi (*receipt*).
9. **`app/Http/Controllers/Admin/SettingController.php`**
   - Mengelola seluruh konfigurasi dinamis website, nomor WA, alamat, tarif biaya, teks informasi landing page, dan penggantian/penghapusan file foto guru dari penyimpanan disk publik.

---

## 9. KEAMANAN, VALIDASI & INTEGRITAS DATA

1. **Proteksi Autentikasi Multi-Guard:**
   - Pemisahan guard `admin` dari guard web biasa di [config/auth.php](file:///c:/xampp/htdocs/bright_kids/config/auth.php).
   - Seluruh route admin diproteksi middleware `auth:admin`.
2. **Mitigasi Brute-Force Attack:**
   - Penerapan `Illuminate\Support\Facades\RateLimiter` pada endpoint login admin (maksimal 5 kali percobaan gagal per 60 detik).
3. **Proteksi Injeksi & Form:**
   - Parameter binding otomatis pada Eloquent ORM melindungi aplikasi dari **SQL Injection**.
   - Setiap form transmisi data POST/PUT/DELETE wajib menyertakan token `@csrf` untuk mencegah serangan **Cross-Site Request Forgery (CSRF)**.
   - Password disimpan menggunakan algoritma hashing **Bcrypt** berstandar industri.
4. **Integritas Relasional & Transaksi Basis Data:**
   - Operasi penghapusan pendaftaran dan murid dibungkus dalam blok `DB::transaction()`. Hal ini menjamin bahwa seluruh data anak, wali, presensi, rapor, dan pembayaran terhapus secara serempak atau dibatalkan seutuhnya jika terjadi kesalahan (*Atomicity & Consistency*).
5. **Keamanan Upload File:**
   - File foto pengajar divalidasi tipe MIME (`jpeg, png, jpg, webp`) dengan ukuran maksimal 2 MB, serta disimpan dengan nama hash acak di direktori storage privat yang di-symlink ke publik.

---

## 10. PANDUAN INSTALASI & DEPLOYMENT

### 10.1 Kebutuhan Sistem
- PHP >= 8.2 (Ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `gd`, `fileinfo`, `curl`)
- Composer >= 2.0
- MySQL >= 8.0 atau MariaDB >= 10.4
- Node.js & NPM (Opsional untuk asset compiling)
- Web Server: Apache (XAMPP) atau Nginx

### 10.2 Langkah Instalasi Lokal
1. **Clone / Buka Proyek:**
   Pastikan folder proyek berada di direktori web server (misal: `c:\xampp\htdocs\bright_kids`).
2. **Instal Dependensi PHP:**
   ```bash
   composer install
   ```
3. **Konfigurasi Environment (`.env`):**
   Salin file `.env.example` menjadi `.env` lalu sesuaikan kredensial basis data:
   ```ini
   APP_NAME="Bright Kids"
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_URL=http://localhost/bright_kids/public

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bright_kids
   DB_USERNAME=root
   DB_PASSWORD=

   MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxx
   MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxx
   MIDTRANS_IS_PRODUCTION=false
   ```
4. **Generate Application Key & Symlink Storage:**
   ```bash
   php artisan key:generate
   php artisan storage:link
   ```
5. **Jalankan Migrasi & Seeder Awal:**
   ```bash
   php artisan migrate:fresh --seed
   ```
   *Seeder akan membuat akun admin default:*
   - **Email:** `Barijanti@gmail.com`
   - **Password:** `admin123`
   - **Jadwal Belajar:** Sesi 1 (Sore), Sesi 2 (Malam 1), Sesi 3 (Malam 2)
   - **Default Settings:** Tarif Biaya, Profil Ibu Barijanti, S.Pd., Kontak WA & Alamat.

6. **Menjalankan Aplikasi:**
   - Akses via Apache XAMPP: `http://localhost/bright_kids/public`
   - Atau via PHP Built-in Server:
     ```bash
     php artisan serve
     ```
     Lalu akses di browser: `http://127.0.0.1:8000`

---

*Dokumen ini dibuat secara komprehensif sebagai acuan teknis, operasional, dan pengembangan berkelanjutan bagi sistem Bright Kids.*
