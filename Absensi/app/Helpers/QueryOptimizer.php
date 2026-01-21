<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

/**
 * Query Optimizer Helper
 *
 * Membantu mengoptimasi query Eloquent dengan caching dan lazy loading
 *
 * Penggunaan:
 * - QueryOptimizer::cacheQuery('groups', 300, fn() => Group::with('mentor')->get())
 * - QueryOptimizer::paginatedQuery(Student::query(), ['group'], 25)
 */
class QueryOptimizer
{
    /**
     * Cache query results dengan automatic invalidation
     *
     * @param string $cacheKey Unique cache key
     * @param int $ttl Time to live in seconds
     * @param callable $query Query closure
     * @return mixed
     */
    public static function cacheQuery(string $cacheKey, int $ttl = 300, callable $query = null)
    {
        if ($query === null) {
            return Cache::get($cacheKey);
        }

        return Cache::remember($cacheKey, $ttl, function () use ($query) {
            return $query();
        });
    }

    /**
     * Paginate query dengan eager loading optimization
     *
     * @param Builder $query
     * @param array $with Relations to eager load
     * @param int $perPage Items per page
     * @return mixed
     */
    public static function paginatedQuery(Builder $query, array $with = [], int $perPage = 25)
    {
        foreach ($with as $relation) {
            // Load hanya field yang diperlukan dari relation
            if (is_string($relation)) {
                $query->with($relation . ':id,name');  // Default: load id & name saja
            } else {
                $query->with($relation);
            }
        }

        return $query->paginate($perPage);
    }

    /**
     * Select only needed columns to reduce memory usage
     *
     * @param Builder $query
     * @param array $columns Columns to select
     * @param array $with Relations to eager load (with selective columns)
     * @return Builder
     */
    public static function selectOptimized(Builder $query, array $columns = ['*'], array $with = [])
    {
        $query->select($columns);

        foreach ($with as $relation => $relationColumns) {
            if (is_numeric($relation)) {
                // Numeric key = simple relation name, load id + name
                $query->with($relationColumns . ':id,name');
            } else {
                // Association with specific columns
                $query->with([$relation => function ($q) use ($relationColumns) {
                    $q->select($relationColumns);
                }]);
            }
        }

        return $query;
    }

    /**
     * Invalidate related caches
     *
     * @param array $cacheKeys
     * @return void
     */
    public static function invalidateCaches(array $cacheKeys)
    {
        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Get query execution time (for debugging)
     *
     * @param callable $query
     * @return array ['result' => ..., 'time' => ...ms]
     */
    public static function benchmarkQuery(callable $query)
    {
        $start = microtime(true);
        $result = $query();
        $end = microtime(true);
        $time = round(($end - $start) * 1000, 2);

        return [
            'result' => $result,
            'time' => $time . 'ms',
        ];
    }
}
