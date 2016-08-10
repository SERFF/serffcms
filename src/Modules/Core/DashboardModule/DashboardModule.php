<?php
namespace Serff\Cms\Modules\Core\DashboardModule;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Modules\Module;

/**
 * Class DashboardModule
 *
 * @package Serff\Cms\Modules\Core\DashboardModule
 */
class DashboardModule extends Module implements ModuleContract
{
    /**
     * PagesModule constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->path = __DIR__;
        $this->namespace = __NAMESPACE__;
    }

    /**
     *
     */
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

    /**
     *
     */
    public function update()
    {
        // TODO: Implement update() method.
    }

}