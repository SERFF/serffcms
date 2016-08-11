<?php
namespace Serff\Cms\Modules\Core\ThemesModule;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Modules\Module;
use Serff\Cms\Modules\Core\ThemesModule\Core\Theme;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeLoader;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Request;

/**
 * Class ThemesModule
 *
 * @package Serff\Cms\Modules\Core\ThemesModule
 */
class ThemesModule extends Module implements ModuleContract
{
    /**
     * @var string|null
     */
    protected $selected_theme;

    /**
     * Options constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->selected_theme = get_option('selected_theme');
        $this->path = __DIR__;
        $this->namespace = __NAMESPACE__;
    }

    /**
     *
     */
    public function boot()
    {
        parent::boot();

        $this->loadThemes($this->selected_theme);
        $this->buildMenu();
        $this->registerViews();
        $this->registerPageFormExtensions();
    }

    /**
     * @return bool
     */
    public function installed()
    {
        return true;
    }

    /**
     *
     */
    public function update()
    {
        // TODO: Implement update() method.
    }

    /**
     *
     */
    protected function buildMenu()
    {
        $this->addAdminMenuGroup('themes', [
            'label' => "Thema's",
            'icon'  => 'fa fa-circle-o-notch',
        ], 10);


        $this->addAdminMenuItem('themes', [
            'label' => 'Instellingen',
            'icon'  => 'fa fa-cogs',
            'link'  => route('admin.theme.settings'),
        ]);

        $this->addAdminMenuItem('themes', [
            'label' => 'Navigatie',
            'icon'  => 'fa fa-bars',
            'link'  => route('admin.theme.navigation'),
        ]);
    }

    /**
     * Load All Themes
     *
     * @param $selected_theme
     */
    protected function loadThemes($selected_theme)
    {
        $themeLoader = new ThemeLoader();
        $themeLoader->boot($selected_theme);
    }

    /**
     * @param $themes
     *
     * @return array
     */
    public static function mapThemesToData($themes)
    {
        $data = [];
        foreach ($themes as $theme) {
            $data[] = self::mapThemeToData($theme);
        }

        return $data;
    }

    /**
     * @param $theme
     *
     * @return array
     */
    public static function mapThemeToData($theme)
    {
        /**
         * @var Theme $theme
         */
        $data = [
            'name'         => $theme->getNameFormatted(),
            'active'       => ((get_class($theme) === get_option('selected_theme')) ? true : false),
            'class'        => get_class($theme),
            'author'       => $theme->getAuthor(),
            'author_image' => $theme->getAuthorImagePath(),
            'screenshot'   => $theme->getScreenShot(),
            'description'  => $theme->getDescription(),
            'hidden'       => $theme->getHidden(),
        ];

        return $data;
    }

    /**
     * Extension for admin page form
     */
    protected function registerPageFormExtensions()
    {
        $hook_key = 'pages.form';
        $sidebar_hook_key = 'pages.sidebar.form';

        /**
         * Register hook for pages form sidebar - set template
         */
        \Hook::registerFormHook($sidebar_hook_key, function ($record = [], $type) {
            $active_theme = ThemeView::getActiveTheme();

            return ThemeView::getAdminView('admin.themes.partials.pages.template_form', [
                'templates'         => array_pluck($active_theme->getTemplates(), 'name', 'slug'),
                'selected_template' => get_meta_value(array_get($record, 'id'), 'page', 'template'),
            ]);
        });

        /**
         * Register hook for pages submit - save selected template
         */
        \Hook::registerFormSubmit($hook_key, function ($request, $record) {
            /**
             * @var Request $request
             */
            $template = $request->get('template', '');
            set_meta_value(array_get($record, 'id'), 'page', 'template', $template);
        });
    }

    /**
     * @return mixed|null
     */
    public static function getActiveTheme()
    {
        return get_option('selected_theme');
    }
    
    public function getRegisteredThemes()
    {
        
    }
}