<?php
namespace Serff\Cms\Modules\Core\TranslationsModule\Cache;

use Serff\Cms\Core\Cache\CacheManager;
use Cache;
use Closure;

class TranslationCacheManager extends CacheManager
{

    /**
     * @param string $key
     * @param string $locale_code
     * @param Closure $fn
     *
     * @return mixed
     */
    public function rememberTranslation($key, $locale_code, Closure $fn)
    {
        return Cache::rememberForever($this->getCacheKey($key, $locale_code), $fn);
    }

    /**
     * @param string $key
     * @param string $locale_code
     *
     * @return bool
     */
    public function forgetTranslation($key, $locale_code)
    {
        return Cache::forget($this->getCacheKey($key, $locale_code));
    }
}