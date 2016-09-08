<?php
namespace Serff\Cms\Core\Modules;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Modules\Core\CustomFieldsModule\CustomFieldsModule;
use Serff\Cms\Modules\Core\MediaModule\MediaModule;
use Serff\Cms\Modules\Core\OptionsModule\OptionsModule;
use Serff\Cms\Modules\Core\PagesModule\PagesModule;
use Serff\Cms\Modules\Core\PartialsModule\PartialsModule;
use Serff\Cms\Modules\Core\TranslationsModule\TranslationsModule;
use Serff\Cms\Modules\Core\UsersModule\UsersModule;

/**
 * Class ModuleManager
 *
 * @package Serff\Cms\Core\Modules
 */
class ModuleManager
{
    protected $core_modules = [
        OptionsModule::class,
        PagesModule::class,
        UsersModule::class,
        TranslationsModule::class,
        MediaModule::class,
        CustomFieldsModule::class,
        PartialsModule::class,
    ];

    /**
     * Register core and custom modules
     */
    public function coreModules()
    {
        return array_map(function ($module) {
            return new $module;
        }, $this->core_modules);
    }

    /**
     * @param $modules
     */
    public function install($modules)
    {
        if (is_array($modules)) {
            foreach ($modules as $module) {
                $this->installModule($module);
            }

            return;
        }
        $this->installModule($modules);
    }

    /**
     * @param ModuleContract $module
     */
    protected function installModule(ModuleContract $module)
    {
        $module->install();
    }
}