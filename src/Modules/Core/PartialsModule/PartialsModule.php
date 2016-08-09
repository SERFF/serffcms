<?php
namespace Serff\Cms\Modules\Core\PartialsModule;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Modules\Module;

class PartialsModule extends Module implements ModuleContract
{
    /**
     * PartialsModule constructor.
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
        
        $this->buildMenu();

        $this->registerViews();
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
        $this->addAdminMenuGroup('partials', [
            'label' => "Deelpagina's",
            'icon'  => 'fa fa-compress', 
        ], 15);

        $this->addAdminMenuItem('partials', [
            'label' => 'Nieuw',
            'icon'  => 'fa fa-plus',
            'link'  => route('admin.partials.create'),
        ]);

        $this->addAdminMenuItem('partials', [
            'label' => 'Overzicht',
            'icon'  => 'fa fa-list',
            'link'  => route('admin.partials.overview'),
        ]);
    }
}