# 🧪 Testing & Monitoring Guide

## Verifikasi Perubahan

### 1. Cek Pagination Sudah Diimplementasikan

```bash
# Open tinker
php artisan tinker

# Test Student pagination
> App\Models\Student::paginate(25);

# Test Group pagination
> App\Models\Group::paginate(25);

# Test User pagination  
> App\Models\User::paginate(25);

# Output should show:
# Illuminate\Pagination\LengthAwarePaginator {
#   #per_page: 25,
#   #count: 25,
#   ...
# }
```

### 2. Verify Eager Loading

```bash
php artisan tinker

# Check if group relation is loaded (not lazy loaded)
> $students = \App\Models\Student::paginate(25);
> $students->first()->group;  # Should NOT show "query" after

# Enable query logging to see queries
> \Illuminate\Support\Facades\DB::enableQueryLog();
> $students = \App\Models\Student::select(['id', 'name', 'nis', 'group_id'])->with(['group:id,name'])->paginate(25);
> dd(\Illuminate\Support\Facades\DB::getQueryLog());  # Should be 2 queries only (1 students + 1 groups)
```

### 3. Test Caching

```bash
# Test cache operations
php artisan tinker

# Put cache
> \Illuminate\Support\Facades\Cache::put('test.key', 'test.value', 600);

# Get cache
> \Illuminate\Support\Facades\Cache::get('test.key');  # Returns: "test.value"

# Check if Redis is working (if configured)
> \Illuminate\Support\Facades\Cache::driver('redis')->put('test', 'value', 600);
```

---

## Performance Monitoring

### Browser DevTools Method (Recommended)

1. Open login page: `http://localhost:8000/admin` or `/mentor`
2. Press **F12** to open DevTools
3. Go to **Network** tab
4. **Reload page** (Ctrl+R)
5. Check **loading time** at bottom

**Expected Results:**
- Total load time: 1-2 seconds
- Largest files: JS bundles (~500-800ms)
- HTML response: ~200-300ms

### Laravel Debugbar Method

```bash
# Install debugbar
composer require barryvdh/laravel-debugbar --dev

# Publish assets
php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"

# Clear config
php artisan config:clear

# Reload page, then check bottom-right corner
# Should show query count, execution time, etc.
```

---

## Specific Test Cases

### Test 1: List Students Performance

```bash
# Expected: < 2 seconds with 500 students

# Terminal test:
php artisan tinker

> \Illuminate\Support\Facades\DB::enableQueryLog();
> \App\Models\Student::select(['id', 'name', 'nis', 'group_id', 'created_at'])
    ->with(['group:id,name'])
    ->paginate(25);

# Check query count (should be 2-3 queries only)
> count(\Illuminate\Support\Facades\DB::getQueryLog());
```

### Test 2: Login Performance

```bash
# Expected: 800ms - 1 second

# Browser:
1. Open http://localhost:8000/admin
2. Press F12 → Network tab
3. Enter test@example.com / password
4. Click Sign In
5. Measure time until dashboard loads

# Terminal: Check logs for slow queries
tail -f storage/logs/laravel.log
```

### Test 3: Caching

```bash
# Verify user caching works

php artisan tinker

> \Illuminate\Support\Facades\Cache::flush();  # Clear all cache

# Simulate login
> $user = \App\Models\User::where('email', 'admin@test.com')->first();
> \Illuminate\Support\Facades\Cache::put('user.' . $user->id, $user, 3600);

# Retrieve from cache
> $cached = \Illuminate\Support\Facades\Cache::get('user.' . $user->id);
> $cached->name;  # Should show name
```

---

## Monitoring Queries

### Method 1: Real-time Log Monitoring

```bash
# Terminal 1: Start watching logs
tail -f storage/logs/laravel.log | grep "Slow Query"

# Terminal 2: Load page
# Browser: Go to http://localhost:8000/admin/students
```

### Method 2: Query Benchmarking

```php
// Add this to a controller or tinker:

use App\Helpers\QueryOptimizer;

$result = QueryOptimizer::benchmarkQuery(
    fn() => \App\Models\Student::with('group')->paginate(25)
);

dd($result);
// Output: ['result' => [...], 'time' => '245ms']
```

### Method 3: Query Count

```bash
php artisan tinker

> \Illuminate\Support\Facades\DB::enableQueryLog();
> $students = \App\Models\Student::with('group')->paginate(25);
> dd(\Illuminate\Support\Facades\DB::getQueryLog());  # Shows all queries

# Count: Usually 2-3 queries (1 for students + 1 for groups + maybe 1 for count)
```

---

## Performance Baselines

### ✅ Good Performance

- Page load: 1-2 seconds
- List load: 800ms - 1.5 seconds  
- Query count: 2-4 queries per page
- Login: 800ms - 1 second

### ⚠️ Warning Signs

- Page load: > 3 seconds
- List load: > 2 seconds
- Query count: > 10 queries
- Multiple "SELECT *" queries (not using select())
- Missing eager loading (N+1 queries visible)

---

## Optimization Verification Checklist

- [ ] Student list loads in < 2 seconds
- [ ] Group list loads in < 1.5 seconds
- [ ] User list loads in < 1 second
- [ ] Login completes in < 1 second
- [ ] Database debugbar shows 2-4 queries max
- [ ] No "N+1" queries in logs
- [ ] Pagination is working (shows 25 items by default)
- [ ] Eager loading shows correct relations loaded
- [ ] Cache hit rate improving (check after 2nd visit)

---

## Troubleshooting

### Problem: Still slow (> 3 seconds)

**Solution 1: Check Database**
```bash
# Maybe indexes are missing
php artisan tinker
> Schema::getIndexes('students');
> Schema::getIndexes('attendances');

# Run migration if indexes missing:
php artisan migrate
```

**Solution 2: Enable Redis Cache**
```bash
# .env
CACHE_DRIVER=redis

php artisan config:clear
```

**Solution 3: Check Query Count**
```bash
# Enable query logging and check if too many queries
> \Illuminate\Support\Facades\DB::enableQueryLog();
> dd(\Illuminate\Support\Facades\DB::getQueryLog());

# Count queries - should be 2-5 max
```

### Problem: Cache not working

**Check Cache Driver:**
```bash
php artisan tinker
> dd(config('cache.default'));  # Should show 'redis' or 'database'

> \Illuminate\Support\Facades\Cache::put('test', 'value', 600);
> \Illuminate\Support\Facades\Cache::get('test');  # Should return 'value'
```

### Problem: Pagination not showing

**Check if paginate() is called:**
```php
// WRONG:
Student::get();

// RIGHT:
Student::paginate(25);
```

---

## Performance Timeline

### Immediate (Today)
- [x] Pagination implemented
- [x] Eager loading optimized
- [x] Caching layer added
- [ ] **Test & verify loading times**

### Short-term (1-2 days)
- [ ] Monitor with Debugbar
- [ ] Check database indexes
- [ ] Setup Redis if available
- [ ] Enable query logging

### Long-term (1-2 weeks)  
- [ ] Optimize attendance queries
- [ ] Setup CDN for assets
- [ ] Enable APCu caching
- [ ] Database replication (optional)

---

## Command Reference

```bash
# Clear cache & config
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Monitor logs
tail -f storage/logs/laravel.log

# Tinker for testing
php artisan tinker

# Run migrations (verify indexes)
php artisan migrate

# Restart queue (if using)
php artisan queue:restart

# View cache contents (if using Redis)
redis-cli KEYS "*"
```

---

Generated: January 20, 2026
Purpose: Performance testing & verification
