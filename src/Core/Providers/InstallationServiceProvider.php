<?php
namespace Serff\Cms\Core\Providers;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\ServiceProvider;
use Serff\Cms\Core\Facades\Env;
use Serff\Cms\Core\Installer\InstallCommand;
use Serff\Cms\Core\Installer\Installer;
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
     * @var bool
     */
    protected $defer = true;
    /**
     * @var Installer
     */
    protected $installer;
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->installer = app(Installer::class);

        $kernel = app()->make(Kernel::class);
        $kernel->addCommand(InstallCommand::class);
    }

    /**
     * Boot the service provider
     */
    public function boot()
    {
        if ($this->is_installed()) {
            return;
        }

        

        $this->installer->install();
        
        dd('installed');

    }


    /**
     * @return bool
     */
    protected function is_installed()
    {
        return env('INSTALLED', false);
    }
}