<?php
namespace Serff\Cms\Core\Cache;

abstract class CacheManager
{
    /**
     * @param $name
     * @param null $locale_code
     *
     * @return string
     */
    protected function getCacheKey($name, $locale_code = null)
    {
        if ($locale_code === null) {
            $locale_code = app()->getLocale();
        }

        return ($name . '-' . $locale_code);
    }

}