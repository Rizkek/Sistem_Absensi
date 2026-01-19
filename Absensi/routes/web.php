<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $user = \Illuminate\Support\Facades\Auth::user();

    if ($user) {
        if ($user->role === 'mentor') {
            return redirect('/mentor');
        }
        if ($user->role === 'admin') {
            return redirect('/admin');
        }
    }

    // Default redirect ke login admin jika belum login
    return redirect('/admin/login');
})->name('home');

require __DIR__ . '/web_debug.php';
