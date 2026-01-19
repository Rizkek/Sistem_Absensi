=============================================================
PANDUAN DEPLOYMENT KE SUPABASE (PostgreSQL)
=============================================================

Supabase adalah Firebase alternative dengan PostgreSQL database.
Free tier: 500 MB database, unlimited API calls, 1 GB storage.

---

## LANGKAH 1: SETUP SUPABASE PROJECT

1. Buka: https://supabase.com/
2. Klik "Start your project" dan login (bisa pakai GitHub)
3. Klik "New Project"
4. Isi:
    - Name: sistem-absensi (atau nama lain)
    - Database Password: (SIMPAN password ini!)
    - Region: Singapore (pilih terdekat)
5. Tunggu ~2 menit sampai project ready

---

## LANGKAH 2: DAPATKAN DATABASE CREDENTIALS

1. Di Supabase Dashboard, klik project Anda
2. Klik ikon "Settings" (gear icon) di sidebar kiri
3. Pilih "Database"
4. Scroll ke "Connection string"
5. Pilih tab "URI" dan copy connection string

    Format:
    postgresql://postgres:[YOUR-PASSWORD]@db.xxxxx.supabase.co:5432/postgres

6. Catat informasi ini:
    - Host: db.xxxxx.supabase.co
    - Port: 5432
    - Database: postgres
    - Username: postgres
    - Password: (yang Anda buat tadi)

---

## LANGKAH 3: KONFIGURASI .ENV

1. Buka file .env di project Laravel
2. Ganti bagian DATABASE dengan:

    DB_CONNECTION=pgsql
    DB_HOST=db.xxxxx.supabase.co
    DB_PORT=5432
    DB_DATABASE=postgres
    DB_USERNAME=postgres
    DB_PASSWORD=password_anda_dari_langkah1
    DB_SSLMODE=require

3. Save file .env

---

## LANGKAH 4: TEST KONEKSI & MIGRATE

Di terminal, jalankan:

# Test koneksi

php artisan migrate:status

# Jika berhasil, migrate database

php artisan migrate:fresh --seed

Jika sukses, data akan tersimpan di Supabase PostgreSQL!

---

## LANGKAH 5: DEPLOY APLIKASI (PILIH SALAH SATU)

## OPSI A: Deploy ke Railway.app (Recommended)

1. Push code ke GitHub
2. Buka: https://railway.app/
3. Login dengan GitHub
4. Klik "New Project" → "Deploy from GitHub repo"
5. Pilih repository Anda
6. Railway akan auto-detect Laravel
7. Tambahkan Environment Variables (copy dari .env):
    - APP_KEY (generate: php artisan key:generate --show)
    - DB_CONNECTION=pgsql
    - DB_HOST=db.xxxxx.supabase.co
    - DB_PORT=5432
    - DB_DATABASE=postgres
    - DB_USERNAME=postgres
    - DB_PASSWORD=your_password
    - DB_SSLMODE=require
8. Deploy akan otomatis!

## OPSI B: Deploy ke Vercel (Static + API)

Note: Vercel free tier terbatas untuk Laravel.
Lebih cocok pakai Railway atau Heroku.

## OPSI C: VPS Sendiri (DigitalOcean, Vultr, dll)

Jika punya VPS:

1. Install LEMP stack (Linux, Nginx, MySQL, PHP)
2. Clone repository
3. Setup .env dengan Supabase credentials
4. Run: composer install --no-dev
5. Run: php artisan migrate --force
6. Setup Nginx virtual host

---

## LANGKAH 6: MONITORING DATABASE (OPTIONAL)

Di Supabase Dashboard:

1. Klik "Table Editor" untuk lihat data real-time
2. Klik "SQL Editor" untuk query manual
3. Klik "Database" → "Backups" untuk download backup

---

## TROUBLESHOOTING

ERROR: "SQLSTATE[08006] could not connect to server"
SOLUSI:

- Pastikan DB_SSLMODE=require ada di .env
- Cek firewall (Supabase butuh SSL)

ERROR: "No such file or directory (pgsql ext)"
SOLUSI:

- Install PHP PostgreSQL extension:
    - Windows: enable extension=pdo_pgsql di php.ini
    - Linux: sudo apt install php-pgsql

ERROR: "password authentication failed"
SOLUSI:

- Reset password di Supabase Dashboard → Settings → Database → Reset Password

---

## TIPS DEPLOYMENT

✅ Gunakan .env.production untuk production
✅ Set APP_DEBUG=false di production
✅ Set APP_ENV=production
✅ Jangan commit .env ke Git (sudah di .gitignore)
✅ Backup database rutin (Supabase punya auto-backup daily)

---

## ESTIMASI BIAYA

Supabase Free Tier:

- 500 MB database storage (cukup untuk ~10,000 santri)
- Unlimited API requests
- 1 GB file storage

Railway Free Tier:

- $5 credit/bulan
- Biasanya cukup untuk ~500 JAM runtime/bulan

Total: GRATIS untuk project kecil-menengah!

=============================================================
SELESAI! SISTEM ABSENSI ANDA SUDAH ONLINE
=============================================================

URL Production biasanya:

- Railway: https://sistem-absensi-production.up.railway.app
- Vercel: https://sistem-absensi.vercel.app

Login dengan credentials yang sama:

- Admin: admin@bkap.com / password
- Mentor: ahmad@mentor.com / password

(Jangan lupa ganti password di production!)
