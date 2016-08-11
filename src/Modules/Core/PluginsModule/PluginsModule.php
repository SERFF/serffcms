<?php
namespace Serff\Cms\Modules\Core\PluginsModule;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Modules\Module;

/**
 * Class PluginsModule
 *
 * @package Serff\Cms\Modules\Core\PluginsModule
 */
class PluginsModule extends Module implements ModuleContract
{
    /**
     * PluginsModule constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->path = __DIR__;
        $this->namespace = __NAMESPACE__;
    }
    
    public function boot()
    {
        parent::boot();
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
}