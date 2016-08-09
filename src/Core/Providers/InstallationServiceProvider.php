<?php
namespace Serff\Cms\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Serff\Cms\Core\Facades\Env;
use Serff\Cms\Core\Migrations\MigrationManager;
use Serff\Cms\Core\Modules\ModuleManager;
use Serff\Cms\Theme\Core\Nano\Nano;

/**
 * Class InstallationServiceProvider
 *
 * @package Serff\Cms\Core\Providers
 */
class InstallationServiceProvider extends ServiceProvider
{
    /**
     * @var MigrationManager $migrationManager
     */
    protected $migrationManager = null;
    /**
     * @var ModuleManager $moduleManager
     */
    protected $moduleManager;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->migrationManager = new MigrationManager();
        $this->moduleManager = new ModuleManager();
    }

    /**
     * Boot the service provider
     */
    public function boot()
    {
        if ($this->is_installed()) {
            return;
        }

        $this->migrationManager->prepare();
        $modules = $this->moduleManager->coreModules();

        $this->moduleManager->install($modules);

        $this->selected_theme();
        
        $this->publishPublicAssets();
        
        $this->publishResources();

        Env::update(['INSTALLED' => 'true']);
        
        dd('installed');

    }

    /**
     *
     */
    protected function publishPublicAssets()
    {
        $dir = __DIR__ . '/../../public';
        
        $this->copyDirectory($dir, 'public');
    }

    /**
     * @param $dir
     * @param string $target
     */
    protected function copyDirectory($dir, $target = 'public')
    {
        foreach(\File::directories($dir) as $directory) {
            \File::copyDirectory($directory, $this->getPublishPath(\File::name($directory), $target));
        }

        foreach(\File::files($dir) as $file) {
            \File::copy($file, $this->getPublishPath(\File::basename($file), $target));
        }
    }

    /**
     * @param $target
     * @param $type
     *
     * @return string
     */
    protected function getPublishPath($target, $type)
    {
        if($type == 'public') {
            return public_path($target);
        } else {
            return resource_path($target);
        }
    }

    /**
     *
     */
    protected function publishResources()
    {
        $dir = __DIR__ . '/../../resources';

        $this->copyDirectory($dir, 'resources');
    }

    /**
     * @return bool
     */
    protected function is_installed()
    {
        return env('INSTALLED', false);
    }

    /**
     * Select standard theme if not defined
     */
    protected function selected_theme()
    {
        if (get_option('selected_theme') === null) {
            set_option('selected_theme', Nano::class);
        }
    }
}