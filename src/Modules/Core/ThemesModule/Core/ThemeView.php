<?php
namespace Serff\Cms\Modules\Core\ThemesModule\Core;

use Illuminate\Contracts\View\View;

/**
 * Class ThemeView
 *
 * @package Serff\Cms\Modules\Core\ThemesModule\Core
 */
class ThemeView
{

    /**
     * @param $view
     * @param array $with
     *
     * @return View
     */
    public static function getAdminView($view, $with = [])
    {
        return \View::make('admin::' . $view)->with($with);
    }

    /**
     * @param $view
     * @param array $with
     *
     * @return View
     */
    public static function getView($view, $with = [])
    {
        $Theme = app('Container')->getActiveTheme();


        return \View::make($Theme->getName() . '::' . $view)->with($with);
    }

    /**
     * @param $view
     *
     * @return bool
     */
    public static function getViewExists($view)
    {
        $Theme = app('Container')->getActiveTheme();
        
        return \View::exists($Theme->getName() . '::' . $view);
    }

    /**
     * @return mixed
     */
    public static function getWysiwygCssRoute()
    {
        $Theme = app('Container')->getActiveTheme();

        return $Theme->getAdminWysiwygCss();
    }

    /**
     * @return mixed
     */
    public static function getActiveTheme()
    {
        return app('Container')->getActiveTheme();
    }

    /**
     * @return mixed|null
     */
    protected static function getMenuData()
    {
        $locale = app()->getLocale();
        $theme = ThemeView::getActiveTheme()->getName();

        return option_unserialize($theme . '.' . $locale . '.navigation', []);
    }

    /**
     * Temporary menu solution
     *
     * @return array
     */
    public static function getMenu()
    {
        $data = self::getMenuData();
        $items = [];
        foreach (array_get($data, 'pages', []) as $page) {
            $items[] = [
                'label' => array_get($page, 'title'),
                'link'  => route_with_locale('page', ['slug' => array_get($page, 'slug')]),
            ];

        }
        return $items;
    }
}