<?php
namespace Serff\Cms\Core\Controllers;

use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;

class Controller extends \App\Http\Controllers\Controller
{
    /**
     * @return mixed|null
     */
    protected function getMenuData()
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
    protected function getMenu()
    {
        $data = $this->getMenuData();
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