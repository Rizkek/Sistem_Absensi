# 🚀 Performance Optimization Guide

**Target**: Reduce loading times dari 5-10 detik ke ~1 detik

---

## 📊 Analisis Masalah & Solusi

### **1. DATABASE QUERY OPTIMIZATION**

#### ❌ Masalah Saat Ini:
- Default eager loading `$with = ['group']` di Student/Group bisa menyebabkan over-fetching
- N+1 Query Problem pada list pages
- Tidak ada pagination strategi
- Index sudah ada tapi perlu diverifikasi

#### ✅ Solusi:

**a) Selective Eager Loading**
```php
// SEBELUM: Load semua relasi
$students = Student::with('group')->get(); // Boros

// SESUDAH: Load hanya field yang dibutuhkan
$students = Student::select(['id', 'name', 'nis', 'group_id'])
    ->with('group:id,name')
    ->paginate(25);
```

**b) Gunakan Pagination (WAJIB)**
```php
// Jangan gunakan ->get() tanpa limit
// Gunakan ->paginate() atau ->simplePaginate()

// Contoh di ListStudents.php:
protected function getTableQuery(): Builder
{
    return parent::getTableQuery()
        ->select(['id', 'name', 'nis', 'group_id', 'created_at'])
        ->with(['group:id,name'])
        ->paginate(25);  // Default 25 per page
}
```

**c) Database Connection Pooling**
```php
// Di .env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_POOL=5        # Tambahkan untuk connection pooling
DB_POOL_MIN=1
DB_POOL_MAX=10
```

---

### **2. CACHING STRATEGY**

#### ✅ Implementasi:

**a) Query Result Caching (untuk data statis)**
```php
// SEBELUM:
$groups = Group::with('mentor')->get();

// SESUDAH: Cache selama 5 menit
$groups = Cache::remember('groups.list', 300, function () {
    return Group::with('mentor:id,name')
        ->select(['id', 'name', 'mentor_id'])
        ->get();
});
```

**b) Tambahan di config/cache.php**
```php
'default' => env('CACHE_DRIVER', 'redis'), // Ganti dari database
'redis' => [
    'default' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD', null),
        'port' => env('REDIS_PORT', 6379),
    ],
],
```

---

### **3. LOGIN OPTIMIZATION**

#### ❌ Masalah:
- Query user profile terjadi multiple times
- Session creation lambat
- No rate limiting

#### ✅ Solusi di AdminLogin.php & MentorLogin.php:

```php
public function authenticate(): ?\Filament\Http\Responses\Auth\Contracts\LoginResponse
{
    $data = $this->form->getState();

    // OPTIMIZED: Gunakan findByEmail() dengan index
    if (
        !\Illuminate\Support\Facades\Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember'] ?? false)
    ) {
        $this->throwFailureValidationException();
    }

    // Cache user data untuk request berikutnya
    $user = \Illuminate\Support\Facades\Auth::user();
    Cache::put('user.'.$user->id, $user, 3600);

    if ($user->role !== 'admin') {
        \Illuminate\Support\Facades\Auth::logout();
        $this->addError('email', 'Akun Anda tidak memiliki akses Admin.');
        return null;
    }

    session()->regenerate();

    return app(\Filament\Http\Responses\Auth\Contracts\LoginResponse::class);
}
```

---

### **4. LIVEWIRE OPTIMIZATION**

#### ✅ Tips:

**a) Disable reactive properties yang tidak perlu**
```php
class SessionResource extends Resource
{
    protected static bool $isLiveReactive = false; // Jika tidak perlu real-time
}
```

**b) Lazy load tables besar**
```php
public static function table(Table $table): Table
{
    return $table
        ->columns([...])
        ->paginated([10, 25, 50])
        ->defaultPaginationPageOption(10) // Mulai dengan 10 items
        ->persistColumns()
        ->persistFiltersInSession()
        ->recordsPerPageSelectOptions([10, 25, 50, 100]);
}
```

---

### **5. FRONTEND OPTIMIZATION**

#### ✅ Implementasi:

**a) Lazy Load Images**
```blade
<img src="{{ $item->image }}" loading="lazy">
```

**b) Minimize CSS/JS**
```bash
# Di terminal
npm run build
```

**c) Enable Gzip Compression**
```php
// Di config/app.php atau middleware
'middleware' => [
    // ... other middleware
    \Illuminate\Middleware\TrustProxies::class,
    // Add gzip middleware
],
```

---

### **6. PRODUCTION READY CHECKLIST**

- [ ] Enable Query Logging untuk debug
  ```php
  \Illuminate\Support\Facades\DB::enableQueryLog();
  ```

- [ ] Setup APCu/Redis untuk caching
- [ ] Enable OPcache di PHP
- [ ] Gunakan HTTP/2
- [ ] Setup CDN untuk static files
- [ ] Monitor dengan New Relic/Datadog
- [ ] Setup Rate Limiting di login

---

### **7. MONITOR PERFORMANCE**

**Query Debugging Tool:**
```bash
# Install Laravel Debugbar
composer require barryvdh/laravel-debugbar --dev
```

**Check Query Count:**
```php
// Di AppServiceProvider
\DB::listen(function ($query) {
    logger()->info('Query Time: ' . $query->time . 'ms - ' . $query->sql);
});
```

---

## 🎯 EXPECTED IMPROVEMENTS

| Metrik | Sebelum | Sesudah |
|--------|--------|--------|
| Page Load | 5-10s | 1-2s |
| API Response | 3-5s | 500-800ms |
| Login | 3-4s | 800-1000ms |
| Data List | 4-6s | 1-2s |

---

## 📋 Implementation Order

1. **Priority 1 (Cepat berdampak):**
   - Tambah pagination di list pages ✅
   - Optimize eager loading ✅
   - Add proper indexes (sudah ada) ✅

2. **Priority 2 (Medium impact):**
   - Setup Redis/APCu caching
   - Query result caching
   - Livewire lazy loading

3. **Priority 3 (Long-term):**
   - CDN setup
   - APCu opcode caching
   - Database replication

---

## 🔧 Quick Wins Hari Ini

### ✅ Todo:
1. Update list page queries dengan select() dan pagination
2. Cache repeated queries (groups, mentors, etc)
3. Add column indexing verification
4. Setup Redis jika server support
5. Monitor dengan Debugbar
