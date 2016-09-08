<?php
namespace Serff\Cms\Core\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\ProviderRepository;
use \Illuminate\Support\ServiceProvider;
use ReflectionClass;
use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Cms\Loader\Loader;
use Serff\Cms\Core\Container\Container;
use Serff\Cms\Core\Facades\DataUtil;
use Serff\Cms\Core\Facades\Env;
use Serff\Cms\Core\Facades\Hook;
use Serff\Cms\Core\Navigation\AdminMenu;
use Illuminate\Filesystem\Filesystem;
use Serff\Cms\Modules\Core\UsersModule\Domain\Models\User\User;

/**
 * Class CmsServiceProvider
 *
 * @package Serff\Cms\Core\Providers
 */
class CmsServiceProvider extends ServiceProvider
{
    /**
     * @var Loader
     */
    protected $loader;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->activateAdminMenu();
        $this->activateHook();

        $this->registerAuthUser();
    }

    /**
     * Boot the class
     */
    public function boot()
    {
        $this->setKernel();
        $this->registerFacades();
        $this->otherServiceProviders();

        $this->loader = app()->make(Loader::class);
        $this->registerContainer();
        $this->registerModules();
        $this->registerMiddlewares();
    }

    /**
     * Register core and custom modules
     */
    public function registerModules()
    {
        $namespace  = 'Serff\Cms\Modules';
        $reflector  = new ReflectionClass(get_class($this));
        $modulePath = str_replace('Core/Providers/CmsServiceProvider.php', 'Modules/', $reflector->getFileName());

        $customModules    = [];
        $modulePathCustom = app_path('Modules');
        $modulesNamespace = 'App\Modules';

        $coreModules = $this->loader->find($namespace, $modulePath);
        if (\File::exists($modulePathCustom)) {
            $customModules = $this->loader->find($modulesNamespace, $modulePathCustom);
        }
        app('Container')->setCoreModules($coreModules);
        app('Container')->setCustomModules($this->sanitizeCustomModules($customModules));
        
        $coreModules = array_merge($coreModules, $customModules);
        foreach ($coreModules as $class) {
            $this->loadModule($class);
        }
    }

    public function sanitizeCustomModules($modules)
    {
        $modules = ( array_map(function($module) {
            if($module->implementsInterface(ModuleContract::class)) {
                return $module->newInstance();
            }
            return false;
        }, $modules));
        
        return array_filter($modules, function($item) {
            return ($item !== false);
        });
    }

    /**
     * @param \ReflectionClass $class
     */
    protected function loadModule(\ReflectionClass $class)
    {
        if ($class->implementsInterface(ModuleContract::class)) {
            /**
             * @var ModuleContract $Module
             */
            $Module = $class->newInstance();
            $Module->boot();
        }
    }

    /**
     * Register the hook component
     */
    protected function activateHook()
    {
        app()->singleton(
            'Hook',
            \Hook::class
        );
    }

    /**
     * Register the admin menu component
     */
    protected function activateAdminMenu()
    {
        app()->singleton(
            'AdminMenu',
            AdminMenu::class
        );
    }

    /**
     * Register the CMS Container
     */
    protected function registerContainer()
    {
        app()->singleton(
            'Container',
            Container::class
        );
    }

    /**
     * Overwrite standard Laravel kernels
     */
    protected function setKernel()
    {
        app()->singleton(
            \Illuminate\Contracts\Http\Kernel::class,
            \Serff\Cms\Core\Http\Kernel::class
        );

        app()->singleton(
            \Illuminate\Contracts\Console\Kernel::class,
            \Serff\Cms\Core\Console\Kernel::class
        );

        app()->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \Serff\Cms\Core\Exceptions\Handler::class
        );
    }

    /**
     * Register CMS Facades
     */
    protected function registerFacades()
    {
        $facades = [
            'Env'      => Env::class,
            'Hook'     => Hook::class,
            'DataUtil' => DataUtil::class,
            'AdminLTE' => \Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::class,
            'Form'     => \Collective\Html\FormFacade::class,
            'Html'     => \Collective\Html\HtmlFacade::class,
            'Image'    => \Intervention\Image\Facades\Image::class,
        ];

        AliasLoader::getInstance($facades)->register();
    }

    /**
     * Register extra service providers
     */
    protected function otherServiceProviders()
    {
        $providers = [
            \Collective\Html\HtmlServiceProvider::class,
            \Intervention\Image\ImageServiceProvider::class,
            \Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider::class,
            \Serff\Cms\Core\Providers\InstallationServiceProvider::class,
            \Serff\Cms\Core\Providers\AdminServiceProvider::class,
        ];

        $manifestPath = app()->getCachedServicesPath();

        (new ProviderRepository(app(), new Filesystem, $manifestPath))
            ->load($providers);
    }

    /**
     *
     */
    protected function registerAuthUser()
    {
        app('config')->set(['auth.providers.users.model' => User::class]);
    }

    /**
     * Register middlewares to group
     *
     * @param string $group
     */
    protected function registerMiddlewares($group = 'web')
    {
        foreach (app('Container')->getMiddlewares() as $middleware) {
            app('router')->pushMiddlewareToGroup($group, $middleware);
        }
    }
}