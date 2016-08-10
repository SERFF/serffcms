<?php
namespace Serff\Cms\Modules\Custom\KabolaSearchModule;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Modules\Module;

/**
 * Class KabolaSearchModule
 *
 * @package Serff\Cms\Modules\Custom\KabolaSearchModule
 */
class KabolaSearchModule extends Module implements ModuleContract
{
    /**
     * KabolaSearchModule constructor.
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

    /**
     *
     */
    public function update()
    {
        // TODO: Implement update() method.
    }
}