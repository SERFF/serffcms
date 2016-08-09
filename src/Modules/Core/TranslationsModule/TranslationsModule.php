<?php
namespace Serff\Cms\Modules\Core\TranslationsModule;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Facades\Hook;
use Serff\Cms\Core\Modules\Module;
use Serff\Cms\Modules\Core\PagesModule\Domain\Repositories\PagesRepository;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Serff\Cms\Modules\Core\TranslationsModule\Console\UpdateTranslations;
use Serff\Cms\Modules\Core\TranslationsModule\Domain\Models\Translation;
use Serff\Cms\Modules\Core\TranslationsModule\Domain\Repositories\TranslationsRepository;
use Serff\Cms\Modules\Core\TranslationsModule\Middleware\LocalePrefix;
use Serff\Cms\Modules\Core\TranslationsModule\Observers\TranslationObserver;
use Illuminate\Http\Request;

/**
 * Class TranslationsModule
 *
 * @package Serff\Cms\Modules\Core\TranslationsModule
 */
class TranslationsModule extends Module implements ModuleContract
{
    /**
     * @var TranslationsRepository $repository
     */
    protected $repository;

    /**
     * Options constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->path = __DIR__;
        $this->namespace = __NAMESPACE__;
        $this->repository = app()->make(TranslationsRepository::class);
    }

    public function boot()
    {
        parent::boot();

        $this->buildMenu();

        $this->registerViews();

        $this->registerObservers();

        $this->registerConsoleCommands();

        $this->registerPageOverviewExtension();

        $this->registerThemeNavigationExtension();

        $this->registerPartialExtions();

        $this->registerMiddlewares();
    }

    /**
     * @return bool
     */
    public function installed()
    {
        return true;
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    protected function buildMenu()
    {
        $this->addAdminMenuGroup('translations', [
            'label' => 'Taal instellingen',
            'icon'  => 'fa fa-globe',
        ], 20);

        $this->addAdminMenuItem('translations', [
            'label' => 'Instellingen',
            'icon'  => 'fa fa-cogs',
            'link'  => route('admin.translation.settings'),
        ]);

        $this->addAdminMenuItem('translations', [
            'label' => 'Vertalingen',
            'icon'  => 'fa fa-language',
            'link'  => route('admin.translation.overview'),
        ]);
    }

    protected function registerConsoleCommands()
    {
        $this->addConsoleCommand(UpdateTranslations::class);
    }

    protected function registerObservers()
    {
        Translation::observe(new TranslationObserver());
    }

    /**
     * Register extensions to the pages module
     */
    protected function registerPageOverviewExtension()
    {
        $hook_key = 'pages.overview';
        $repository = $this->repository;

        Hook::addDisplayFields($hook_key, [
            [
                'label' => 'Talen',
                'key'   => 'available_locales',
                'order' => 35,
            ],
        ]);

        Hook::addFormatters($hook_key, [
            'available_locales' => function ($record) {
                $return_value = '';
                foreach (array_get($record, 'available_locales') as $item) {
                    $return_value .= '(' . $item . ')';
                }

                return $return_value;
            },
        ]);


        Hook::addDataManipulation($hook_key, function ($data) {
            return array_map(function ($record) {
                $record['available_locales'] = unserialize(get_option('site_locales', []));

                return $record;
            }, $data);
        });

        Hook::registerFormHook('pages.sidebar.form', function ($record = [], $type) use ($repository) {

            return ThemeView::getAdminView('admin.translations.partials.pages.locale_form', [
                'available_locales' => $repository->getCountriesAndLocalesForSelect(true),
                'selected_locale'   => array_get($record, 'locale', app()->getLocale()),
            ]);
        });

    }

    /**
     * Register the module specific middleware
     */
    protected function registerMiddlewares()
    {
        $this->registerMiddleware(LocalePrefix::class);
    }

    protected function registerThemeNavigationExtension()
    {
        $repository = $this->repository;
        Hook::registerFormHook('theme.navigation.sidebar.form', function ($record = [], $type) use ($repository) {

            return ThemeView::getAdminView('admin.translations.partials.pages.locale_form', [
                'available_locales' => $repository->getCountriesAndLocalesForSelect(true),
                'selected_locale'   => array_get($record, 'locale', app()->getLocale()),
            ]);
        });
    }

    protected function registerPartialExtions()
    {
        $repository = $this->repository;
        
        Hook::registerFormHook('partials.sidebar.form', function ($record = [], $type) use ($repository) {

            return ThemeView::getAdminView('admin.translations.partials.pages.locale_form', [
                'available_locales' => $repository->getCountriesAndLocalesForSelect(true),
                'selected_locale'   => array_get($record, 'locale', app()->getLocale()),
            ]);
        });
    }
}