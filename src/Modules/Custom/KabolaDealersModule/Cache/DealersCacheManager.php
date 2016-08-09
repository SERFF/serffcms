<?php
namespace Serff\Cms\Modules\Custom\KabolaDealersModule\Cache;

use Serff\Cms\Core\Cache\CacheManager;
use Cache;
use Closure;

class DealersCacheManager extends CacheManager
{

    /**
     * @param string $key
     * @param Closure $fn
     *
     * @return mixed
     */
    public function rememberLocation($key, Closure $fn)
    {
        return Cache::remember($key, 30, $fn);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function forgetLocation($key)
    {
        return Cache::forget($key);
    }
}