# Panduan Instalasi Sistem Absensi

Karena keterbatasan akses terminal otomatis, mohon jalankan langkah berikut untuk menyelesaikan instalasi:

1.  **Pastikan Terminal berada di folder project**:

    ```bash
    cd e:\coding\Sistem_Absensi\Absensi
    ```

2.  **Instalasi Dependency (Jika belum)**:

    ```bash
    composer install
    npm install
    npm run build
    ```

3.  **Setup Database & API**:
    - Pastikan file `.env` sudah sesuai (default SQLite ok untuk development).
    - Jalankan migrasi:
        ```bash
        php artisan migrate:fresh --seed
        php artisan install:api
        ```
        (Perintah ini akan membuat database baru, mengisi data dummy, dan menginstall API tokens).

4.  **Akun Login**:
    - **Admin (BKAP)**:
        - Email: `admin@bkap.com`
        - Password: `password`
        - URL: `/admin`
    - **Mentor**:
        - Email: `ahmad@mentor.com`
        - Password: `password`
        - URL: `/mentor`

5.  **Jalankan Server**:
    ```bash
    php artisan serve
    ```
    Buka `http://localhost:8000/admin` atau `http://localhost:8000/mentor`.

## Fitur yang diimplementasikan:

- **Panel BKAP**: Manajemen Data Siswa (Santri), Grup (Halaqah), dan User.
- **Panel Mentor**: Manajemen Sesi Pertemuan (Jadwal) dan Presensi (Absensi).
- **API (Opsional)**:
    - `GET /api/sessions`: Mengambil data sesi dan presensi (Bearer Token required).
    - `PUT /api/attendance/{id}`: Update status kehadiran via API.

## Alur Presensi (Mentor):

1. Mentor login ke `/mentor`.
2. Masuk menu "Jadwal / Sesi".
3. Klik "Buat Sesi" (Pilih tanggal & materi).
4. Sistem otomatis membuat daftar absensi untuk semua santri di grup mentor tersebut.
5. Edit Sesi tersebut, scroll ke bawah untuk mencentang status kehadiran santri (Hadir/Izin/Sakit/Alpha).
