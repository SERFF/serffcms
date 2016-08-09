<?php
namespace Serff\Cms\Modules\Core\MediaModule;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Modules\Module;

/**
 * Class MediaModule
 *
 * @package Serff\Cms\Modules\Core\MediaModule
 */
class MediaModule extends Module implements ModuleContract
{

    /**
     * MediaModule constructor.
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
        $this->addAdminMenuGroup('media', [
            'label' => 'Media',
            'icon'  => 'fa fa-camera',
        ], 5);

        $this->addAdminMenuItem('media', [
            'label' => 'Bibiliotheek',
            'icon'  => 'fa fa-list',
            'link'  => route('admin.media.library'),
        ]);

        $this->addAdminMenuItem('media', [
            'label' => 'Nieuw bestand',
            'icon'  => 'fa fa-plus',
            'link'  => route('admin.media.new'),
        ]);
    }
}