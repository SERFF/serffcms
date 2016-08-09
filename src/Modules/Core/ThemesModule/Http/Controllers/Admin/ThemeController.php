<?php
namespace Serff\Cms\Modules\Core\ThemesModule\Http\Controllers\Admin;

use Serff\Cms\Core\Common\ScreenShot\ScreenShot;
use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\PagesModule\Domain\Repositories\PagesRepository;
use Serff\Cms\Modules\Core\ThemesModule\Core\Theme;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Serff\Cms\Modules\Core\ThemesModule\ThemesModule;
use DataUtil;
use Hook;
use Illuminate\Http\Request;

/**
 * Class ThemeController
 *
 * @package Serff\Cms\Modules\Core\ThemesModule\Http\Controllers\Admin
 */
class ThemeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getSettings()
    {
        return ThemeView::getAdminView('admin.themes.settings', [
            'themes' => ThemesModule::mapThemesToData(app('Container')->getThemes()),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postActivate(Request $request)
    {
        set_option('selected_theme', $request->get('theme'));

        return redirect()->route('admin.theme.settings');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getNavigation(Request $request)
    {
        $sidebar_form_hooks = Hook::getFormHook('theme.navigation.sidebar.form');
        $locale = $request->get('locale', app()->getLocale());
        $theme = ThemeView::getActiveTheme()->getName();
        $data = option_unserialize($theme . '.' . $locale . '.navigation', []);
        
        $pagesRepository = app(PagesRepository::class);
        $pages = $pagesRepository->getPublishedPages($locale);

        return ThemeView::getAdminView('admin.themes.navigation', [
            'sidebar_form_views' => DataUtil::handleFormHooks($sidebar_form_hooks, Theme::class, ['locale' => $locale]),
            'pages'              => $pages->toArray(),
            'data'               => $data,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStoreNavigation(Request $request)
    {
        $this->validate($request, [
            'homepage' => 'required',
            'locale'   => 'required',
        ]);

        $data = [
            'home'   => $request->get('homepage'),
            'locale' => $request->get('locale'),
            'pages'  => $this->getPages($request->all()),
        ];

        $theme = ThemeView::getActiveTheme()->getName();
        set_option($theme . '.' . $request->get('locale') . '.navigation', serialize($data));

        return redirect()->route('admin.theme.navigation');
    }

    /**
     * @param $data
     *
     * @return array
     */
    protected function getPages($data)
    {
        $pages = [];
        $pagesRepository = app(PagesRepository::class);
        foreach ($data as $key => $value) {
            if (starts_with($key, 'item_')) {
                $id = str_replace('item_', '', $key);
                $page = $pagesRepository->getById($id)->toArray();
                $pages[] = ['id' => $id, 'title' => $value, 'slug' => array_get($page, 'slug')];
            }
        }

        return $pages;
    }
}