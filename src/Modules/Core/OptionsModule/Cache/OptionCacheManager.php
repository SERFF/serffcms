<?php
namespace Serff\Cms\Modules\Core\OptionsModule\Cache;

use Serff\Cms\Core\Cache\CacheManager;
use Cache;
use Closure;

/**
 * Class OptionCacheManager
 *
 * @package Serff\Cms\Modules\Core\OptionsModule\Cache
 */
class OptionCacheManager extends CacheManager
{
    /**
     * @param string $key
     * @param Closure $fn
     *
     * @return mixed
     */
    public function rememberOption($key, Closure $fn)
    {
        return Cache::rememberForever($key, $fn);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function forgetOption($key)
    {
        return Cache::forget($key);
    }

}