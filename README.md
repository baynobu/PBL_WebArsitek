<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Website Lowongan Kerja Arsitek 

## Latar Belakang

Proses rekrutmen arsitek lepas (freelance) saat ini masih terhambat oleh ketidakefisienan dan kurangnya transparansi akibat absennya wadah digital yang terspesialisasi. Arsitek (terutama fresh graduate) sulit membangun rekam jejak, sementara klien kesulitan menemukan talenta yang sesuai dengan gaya desain dan kualifikasi proyek mereka.

- Untuk mengatasi kesenjangan tersebut, diperlukan sebuah platform digital terintegrasi yang mampu:
- Menghubungkan secara Langsung: Mempertemukan klien dan arsitek dalam satu ekosistem contract-based hiring.
- Standarisasi Portofolio: Menyediakan fitur validasi portofolio digital untuk mempermudah proses matching berdasarkan kualitas dan gaya desain.
- Transparansi Kerja: Menerapkan mekanisme pengajuan proposal yang terbuka serta sistem manajemen status proyek yang terstruktur.
- Profesionalisme: Membantu arsitek membangun profil profesional sekaligus menjamin alur kerja yang efektif bagi pemberi kerja.

## Pengguna

- Admin
- Arsitek
- Client

## Lingkup Sistem

- Management Akun & Role
- Lowongan Kerja Berbasis Proyek
- Sistem Proposal (Lamaran Kerja Proyek)
- Profil dan Portofolio Digital
- Sistem Status Proyek
- Rating dan Review

## Teknologi Pemrograman
- Laravel
- Filament
- MySQL
- Git & Github

## Instalasi

1. Install Dependency Laravel
```bash
composer install
```

2. Copy File Environment
```bash
cp .env.example .env
```

3. Generate App Key
```bash
php artisan key:generate
```

4. Setup Database "db_pbl_arsitek"

5. Migrasi Database
```bash
php artisan migrate
```

6. Install Dependency Frontend
```bash
npm install
```

7. Jalankan Vite (Frontend)
```bash
npm run dev
```

8. Jalankan Server Laravel
```bash
php artisan serve
```

## Update
1. 🔐 Authentication & Authorization
Aplikasi ini sudah mengimplementasikan sistem autentikasi menggunakan:
- Laravel Breeze

Fitur:
- Registrasi user
- Login & logout
- Session management

2. 🔒 Proteksi Akses (Middleware)
Aplikasi menggunakan custom middleware:
"RoleMiddleware"
```bash
Route::middleware(['auth', 'role:admin'])->group(function () {
    // route admin
});
```

3. 🛠 Admin Panel
Admin panel dibangun menggunakan:

Filament
Akses:
```bash
http://127.0.0.1:8000/admin
```

4. 🔐 Proteksi Admin Panel
Hanya user dengan role admin yang dapat mengakses panel:
```bash
public function canAccessPanel(\Filament\Panel $panel): bool
{
    return $this->role === 'admin';
}
```

## Struktur Sistem Saat Ini
✔ Backend
- Laravel (MVC)
- MySQL Database

✔ Frontend
- Blade (Laravel)
- Vite

✔ Tools
- Laragon
- Git