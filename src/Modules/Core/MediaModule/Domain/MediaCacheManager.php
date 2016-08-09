<?php
namespace Serff\Cms\Modules\Core\MediaModule\Cache;

use Serff\Cms\Core\Cache\CacheManager;
use Cache;
use Closure;

/**
 * Class MediaCacheManager
 *
 * @package Serff\Cms\Modules\Core\MediaModule\Cache
 */
class MediaCacheManager extends CacheManager
{

    /**
     * @param string $key
     * @param string $locale_code
     * @param Closure $fn
     *
     * @return mixed
     */
    public function rememberLibrary($key, $locale_code, Closure $fn)
    {
        return Cache::rememberForever($this->getCacheKey($key, $locale_code), $fn);
    }

    /**
     * @param string $key
     * @param string $locale_code
     *
     * @return bool
     */
    public function forgetLibrary($key, $locale_code)
    {
        return Cache::forget($this->getCacheKey($key, $locale_code));
    }

    /**
     * @param $key
     * @param Closure $fn
     *
     * @return mixed
     */
    public function rememberImage($key, Closure $fn)
    {
        return Cache::rememberForever('image_'.$key, $fn);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function forgetImage($key)
    {
        return Cache::forget('image_'.$key);
    }
}