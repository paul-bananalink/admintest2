<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    const EXPIRATION_HOURS = 2; // Expiration hours

    private Cache $cache;

    /**
     * Create a new class instance.
     */
    public function __construct(public string $cache_name = 'default')
    {
        $this->cache = new Cache();
    }

    public function getDataCache(): array
    {
        return $this->cache::get($this->cache_name, []);
    }

    public function setDataCache(mixed $value = []): CacheService
    {
        $this->cache::put($this->cache_name, $value, now()->addHours(self::EXPIRATION_HOURS));

        return $this;
    }
}
