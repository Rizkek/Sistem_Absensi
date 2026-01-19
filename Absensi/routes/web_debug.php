<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

Route::get('/debug-db', function () {
    try {
        // 1. Cek Koneksi
        DB::connection()->getPdo();
        $status = ['connection' => 'OK'];

        // 2. Cek Tabel Users
        if (!Schema::hasTable('users')) {
            return response()->json(['error' => 'Table users not found! Try running php artisan migrate']);
        }

        // 3. Cek User Admin
        $admin = User::where('email', 'admin@bkap.com')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin BKAP',
                'email' => 'admin@bkap.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
            $status['admin'] = 'Created';
        } else {
            // Update role dan password just in case
            $admin->update([
                'role' => 'admin',
                'password' => Hash::make('password')
            ]);
            $status['admin'] = 'Exists & Updated';
        }

        // 4. Cek User Mentor
        $mentor = User::where('email', 'ahmad@mentor.com')->first();
        if (!$mentor) {
            $mentor = User::create([
                'name' => 'Ustadz Ahmad',
                'email' => 'ahmad@mentor.com',
                'password' => Hash::make('password'),
                'role' => 'mentor',
            ]);
            $status['mentor'] = 'Created';
        } else {
            $mentor->update([
                'role' => 'mentor',
                'password' => Hash::make('password')
            ]);
            $status['mentor'] = 'Exists & Updated';
        }

        $status['users_table_count'] = User::count();
        $status['users_data'] = User::all(['id', 'email', 'role']);

        return response()->json($status);

    } catch (\Exception $e) {
        return response()->json([
            'connection' => 'FAILED',
            'error' => $e->getMessage()
        ], 500);
    }
});
