# CRM TipeCreative

Project Praktikum Rekayasa Perangkat Lunak - Kelompok 2
Program Studi Sistem Informasi, Universitas Muhammadiyah Gresik

Sistem Customer Relationship Management (CRM) untuk PT TipeCreative, dikembangkan dengan metode Agile Scrum.

| Nama | NIM | Peran |
|---|---|---|
| M. Ibrahim Firdaus Maulana | 240609008 | Team Leader |
| Ikhsanul Rendi | 240609020 | System Analyst |
| M. Mahdy | 240609010 | System Analyst |
| Afif Akbar | 240609012 | Frontend Developer |
| M. Insan Kamil Alfangky | 240609015 | Backend Developer |

## Teknologi

- Laravel 12 (PHP 8.2 ke atas)
- MySQL
- Tailwind CSS

## Cara Install (Windows)

### 1. Install aplikasi yang dibutuhkan

- **Laragon** (sudah termasuk PHP, MySQL, Composer). Kalau pakai XAMPP juga bisa, asal PHP-nya 8.2 ke atas dan Composer di-install terpisah dari https://getcomposer.org
- **Node.js** versi LTS dari https://nodejs.org
- **GitHub Desktop** dari https://desktop.github.com
- **VS Code** dari https://code.visualstudio.com

### 2. Clone project

Buka GitHub Desktop, pilih **File > Clone repository**, cari `haloteman/crm-rpl`, lalu klik Clone.

### 3. Setup project

Nyalakan MySQL dulu (di Laragon klik **Start All**).

Buat database baru dengan nama `crm_rpl` lewat HeidiSQL (Laragon) atau phpMyAdmin (XAMPP).

Buka folder project di VS Code, lalu buka terminal (**Terminal > New Terminal**) dan jalankan satu per satu:

```
composer install
npm install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
```

Kalau password MySQL kamu tidak kosong, isi dulu `DB_PASSWORD` di file `.env` sebelum `php artisan migrate --seed`.

### 4. Menjalankan project

Buka dua terminal di VS Code:

```
npm run dev
```

```
php artisan serve
```

Lalu buka http://localhost:8000 di browser.

## Update dari GitHub

Setiap mau mulai kerja, klik **Fetch origin** lalu **Pull** di GitHub Desktop, kemudian jalankan:

```
composer install
npm install
php artisan migrate
```

## Aturan Kerja

- Selalu pull dulu sebelum mulai ngoding.
- Commit kecil-kecil dengan pesan yang jelas, misal `halaman login`.
- Jangan commit file `.env`.
- Nama file view pakai huruf kecil semua, misal `lupa-password.blade.php`.
