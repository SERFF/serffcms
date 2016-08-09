<?php
namespace Serff\Cms\Modules\Core\TranslationsModule\Middleware;

use Closure;
use Illuminate\Contracts\Http\Kernel;

class LocalePrefix
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $path_info = $request->getPathInfo();
        $locale = false;
        if (strlen($path_info) >= 3) {
            $locale = $this->getLocaleFromPath($path_info);
        }
        if ($locale == false) {
            $locale = app()->getLocale();
        }
        app()->setLocale($locale);

        return $next($request);
    }

    /**
     * @param $path_info
     *
     * @return bool|string
     */
    public function getLocaleFromPath($path_info)
    {
        if (substr($path_info, '0', 1) == '/') {
            if (strlen($path_info) > 3) {
                if (substr($path_info, '3', 1) == '/') {
                    return $this->getFoundLocale($path_info);
                }
            } else {
                return $this->getFoundLocale($path_info);
            }
        }

        return false;
    }

    public function getFoundLocale($path_info)
    {
        $found_locale = substr($path_info, 1, 2);
        $site_locales = unserialize(get_option('site_locales', []));
        if (in_array($found_locale, $site_locales)) {
            return $found_locale;
        }
    }


}