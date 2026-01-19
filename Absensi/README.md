# Sistem Absensi & Monitoring (SI-AMON)

Sistem manajemen kehadiran santri berbasis Laravel 11 + Filament 3 untuk institusi pendidikan Islam.

## 🎯 Fitur Utama

### Portal BKAP (Admin Akademik)

- 📊 Dashboard statistik kehadiran global
- 👥 Manajemen data santri (CRUD)
- 🏫 Manajemen kelompok/halaqah
- 👨‍💼 Manajemen user (Admin & Mentor)
- 📈 Laporan kehadiran per periode

### Portal Pembimbing (Mentor)

- 📅 Jadwal & sesi pertemuan (CRUD)
- ✅ Input kehadiran santri (Hadir/Sakit/Izin/Alpha)
- 📊 Statistik kehadiran kelompok
- 📝 Catatan per santri

## 🛠️ Tech Stack

- **Backend**: Laravel 11
- **Admin Panel**: Filament 3
- **Database**: PostgreSQL (Supabase) / SQLite (local)
- **Styling**: Tailwind CSS (built-in Filament)
- **Icons**: Material Symbols (Google Fonts)
- **Authentication**: Laravel Sanctum
- **API**: RESTful API (optional)

## 📦 Requirements

- PHP 8.2+
- Composer
- Node.js & NPM
- PostgreSQL (production) / SQLite (local)

## 🚀 Quick Start (Local Development)

### 1. Clone & Install Dependencies

```bash
git clone <repository-url>
cd Sistem_Absensi/Absensi
composer install
npm install
```

### 2. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Setup Database

**Opsi A: SQLite (Recommended untuk local)**

```bash
touch database/database.sqlite
php artisan migrate:fresh --seed
```

**Opsi B: PostgreSQL (untuk testing production)**

- Edit `.env` sesuai `DEPLOY_SUPABASE.md`
- Run: `php artisan migrate:fresh --seed`

### 4. Install Filament

```bash
# Jika extension intl sudah enabled:
composer require filament/filament:"^3.2" -W

# Atau pakai bypass (dev only):
composer require filament/filament:"^3.2" -W --ignore-platform-req=ext-intl
```

### 5. Run Development Server

```bash
# Manual
php artisan serve

# Atau pakai batch script (Windows)
./run_app.bat
```

Akses aplikasi:

- Admin: http://localhost:8000/admin
- Mentor: http://localhost:8000/mentor

## 🔑 Default Login Credentials

| Role       | Email            | Password | URL     |
| ---------- | ---------------- | -------- | ------- |
| Admin BKAP | admin@bkap.com   | password | /admin  |
| Mentor     | ahmad@mentor.com | password | /mentor |

**⚠️ PENTING**: Ganti password default setelah deployment!

## 🌐 Deployment ke Production

Lihat panduan lengkap di: **[DEPLOY_SUPABASE.md](DEPLOY_SUPABASE.md)**

### Quick Deploy Options:

1. **Railway.app** (Recommended)
    - Auto-deploy dari GitHub
    - Free tier: $5 credit/month
    - Support Laravel out-of-the-box

2. **Vercel** (Static + Serverless)
    - Cocok untuk frontend
    - Butuh konfigurasi khusus untuk Laravel

3. **VPS Sendiri**
    - Full control
    - Install LEMP stack manual

### Database Production:

- **Supabase PostgreSQL** (Free 500 MB)
- Dashboard: https://supabase.com

## 📁 Struktur Project

```
Sistem_Absensi/Absensi/
├── app/
│   ├── Filament/
│   │   ├── Resources/          # Admin Resources (BKAP)
│   │   │   ├── StudentResource.php
│   │   │   ├── GroupResource.php
│   │   │   └── UserResource.php
│   │   ├── Mentor/             # Mentor Resources
│   │   │   └── Resources/
│   │   │       └── SessionResource.php
│   │   └── Widgets/            # Dashboard Widgets
│   ├── Models/                 # Eloquent Models
│   │   ├── User.php
│   │   ├── Student.php
│   │   ├── Group.php
│   │   ├── Session.php
│   │   └── Attendance.php
│   └── Http/Controllers/Api/   # API Controllers (optional)
├── database/
│   ├── migrations/             # Database Schema
│   └── seeders/                # Sample Data
├── resources/
│   └── views/
│       └── components/
│           └── material-symbols.blade.php
└── public/
    └── icon-reference.html     # Material Icons Reference
```

## 🎨 UI/UX Guidelines

### Design Principles:

- ✅ Minimalist & Professional
- ✅ Corporate-grade aesthetics
- ✅ No emojis / playful elements
- ✅ Neutral color palette (Navy, Slate, Emerald)
- ✅ Clear typography hierarchy
- ✅ Accessibility-first

### Color Scheme:

- **Admin Panel**: Navy Blue (#1e3a8a) + Slate Gray
- **Mentor Panel**: Emerald Green (#059669) + Slate Gray
- **Backgrounds**: White (#ffffff) & Light Gray (#f8fafc)

### Icons:

- **Source**: Material Symbols (Google Fonts)
- **Style**: Outlined (default)
- **Usage**: `<span class="material-symbols-outlined">icon_name</span>`
- **Reference**: `/icon-reference.html`

## 🔧 Konfigurasi Komentar Kode

Semua file sudah dilengkapi **komentar bahasa Indonesia** untuk memudahkan maintenance:

- Models: Dokumentasi relasi dan fungsi
- Resources: Penjelasan form & table
- Migrations: Keterangan field database

## 📖 Dokumentasi Tambahan

- `SETUP_FINAL.txt` - Panduan instalasi awal
- `DEPLOY_SUPABASE.md` - Panduan deployment Supabase
- `BACA_SAYA.txt` - Quick start bahasa Indonesia
- `icon-reference.html` - Referensi Material Icons

## 🧪 Testing

```bash
# Run tests
php artisan test

# Run dengan coverage
php artisan test --coverage
```

## 🤝 Contributing

1. Fork repository
2. Create feature branch: `git checkout -b feature/AmazingFeature`
3. Commit changes: `git commit -m 'Add some AmazingFeature'`
4. Push to branch: `git push origin feature/AmazingFeature`
5. Open Pull Request

## 📝 License

[MIT License](LICENSE)

## 👥 Authors

- **Developer**: Antigravity AI Agent
- **Client**: [Your Name/Organization]

## 🐛 Bug Reports & Feature Requests

Laporkan bug atau request fitur di [Issues](../../issues)

## 📞 Support

Untuk bantuan deployment atau konfigurasi, hubungi:

- Email: support@example.com
- Documentation: [Wiki](../../wiki)

---

**Made with ❤️ using Laravel + Filament**
