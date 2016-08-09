<?php
namespace Serff\Cms\Core\Installer;

use Serff\Cms\Core\Migrations\MigrationManager;
use Serff\Cms\Core\Modules\ModuleManager;
use Serff\Cms\Theme\Core\Nano\Nano;

/**
 * Class Installer
 *
 * @package Serff\Cms\Core\Installer
 */
class Installer
{
    /**
     * @var MigrationManager
     */
    protected $migrationManager;
    /**
     * @var ModuleManager
     */
    protected $moduleManager;

    /**
     * Installer constructor.
     *
     * @param MigrationManager $migrationManager
     * @param ModuleManager $moduleManager
     */
    public function __construct(MigrationManager $migrationManager, ModuleManager $moduleManager)
    {
        $this->migrationManager = $migrationManager;
        $this->moduleManager = $moduleManager;
    }

    /**
     *
     */
    public function install()
    {
        $this->migrationManager->prepare();
        $modules = $this->moduleManager->coreModules();

        $this->moduleManager->install($modules);

        $this->selected_theme();

        $this->publishPublicAssets();

        $this->publishResources();

        \Env::update(['INSTALLED' => 'true']);
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
        foreach (\File::directories($dir) as $directory) {
            \File::copyDirectory($directory, $this->getPublishPath(\File::name($directory), $target));
        }

        foreach (\File::files($dir) as $file) {
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
        if ($type == 'public') {
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
     * Select standard theme if not defined
     */
    protected function selected_theme()
    {
        if (get_option('selected_theme') === null) {
            set_option('selected_theme', Nano::class);
        }
    }
}