<?php
namespace Serff\Cms\Core\Modules;

use App;
use File;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Foundation\AliasLoader;
use Serff\Cms\Core\Console\Kernel;
use Serff\Cms\Core\Migrations\MigrationManager;
use Serff\Cms\Core\Navigation\AdminMenu;

abstract class Module
{
    /**
     * @var string
     */
    protected $path = null;
    /**
     * @var string
     */
    protected $namespace = null;
    /**
     * @var MigrationManager $migrationManager
     */
    protected $migrationManager;

    /**
     * @var AdminMenu $adminMenu
     */
    protected $adminMenu = null;
    /**
     * @var AliasLoader
     */
    protected $aliasLoader;
    /**
     * @var string
     */
    protected $name = 'Module';
    /**
     * @var string
     */
    protected $class = null;
    /**
     * @var Kernel $consoleKernel
     */
    protected $consoleKernel;
    /**
     * @var HttpKernel $kernel
     */
    protected $httpKernel;

    /**
     * Module constructor.
     */
    public function __construct()
    {
        $this->migrationManager = App::make(MigrationManager::class);
        $this->adminMenu = app('AdminMenu');
        $this->consoleKernel = app()->make(Kernel::class);
        $this->httpKernel = app(HttpKernel::class);
    }

    public function install()
    {
        $this->migrate();
    }

    /**
     * Run the migrations that have not yet ran
     */
    protected function migrate()
    {
        $migrations = $this->migrationManager->getMigrations($this->getMigrationPath(), $this->getMigrationNameSpace());
        $this->migrationManager->run($migrations);
    }

    /**
     * Boot the module
     */
    public function boot()
    {
        $this->loadRoutes();
    }

    /**
     * @return string
     */
    protected function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    protected function getMigrationPath()
    {
        return $this->path . '/Migrations';
    }

    /**
     * @return string
     */
    protected function getNameSpace()
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    protected function getMigrationNameSpace()
    {
        return $this->namespace . '\\Migrations\\';
    }

    /**
     * load the routes for the module
     */
    public function loadRoutes()
    {
        $routes_file = $this->getPath() . '/Http/routes.php';
        if (File::exists($routes_file) === false) {
            return;
        }
        if (!app()->routesAreCached()) {
            $router = app('router');
            $site_locales = [];
            try {
                $site_locales = unserialize(get_option('site_locales', ''));
            }catch(\Exception $e) {
                
            }
            $primary_locale = get_option('primary_locale', app()->getLocale());
            if(trim($site_locales) == '') {
                $site_locales = [];
            }

            foreach ($site_locales as $locale) {
                $route_group_params = ['namespace' => $this->getNameSpace() . '\Http\Controllers', 'middleware' => 'web'];
                $router->group($route_group_params, function () use ($routes_file, $locale, $primary_locale) {
                    $prefix = '';
                    $route_prefix = '';
                    if ($locale !== $primary_locale) {
                        $prefix = $locale . '.';
                        $route_prefix = $locale;
                    }
                    require $routes_file;
                });
            }
        }
    }

    /**
     * @param $group
     * @param $item
     * @param null $sort_order
     */
    public function addAdminMenuGroup($group, $item, $sort_order = null)
    {
        $this->adminMenu->addGroup($group, $item, $sort_order);
    }

    /**
     * @param $group
     * @param $item
     */
    public function addAdminMenuItem($group, $item)
    {
        $this->adminMenu->addItem($group, $item);
    }


    protected function registerViews()
    {
        $viewPath = $this->getPath() . '/views';
        \View::addLocation($viewPath);
        \View::addNamespace('admin', $viewPath);
    }

    /**
     * @param string $command
     */
    protected function addConsoleCommand($command)
    {
        $this->consoleKernel->addCommand($command);
    }

    /**
     * Register Middleware
     *
     * @param  string $middleware
     */
    protected function registerMiddleware($middleware)
    {
        $this->httpKernel->pushMiddleware($middleware);
    }

}