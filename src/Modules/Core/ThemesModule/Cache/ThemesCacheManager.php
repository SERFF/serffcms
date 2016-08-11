<?php
namespace Serff\Cms\Modules\Core\ThemesModule\Cache;

use Serff\Cms\Core\Cache\CacheManager;

/**
 * Class ThemesCacheManager
 *
 * @package Serff\Cms\Modules\Core\ThemesModule\Cache
 */
class ThemesCacheManager extends CacheManager
{
    /**
     * @param \Closure $fn
     *
     * @return mixed
     */
    public function rememberThemes(\Closure $fn) {
        return \Cache::rememberForever('themes', $fn);
    }

    /**
     *
     */
    public function forgetThemes()
    {
        \Cache::forget('themes');
    }

}