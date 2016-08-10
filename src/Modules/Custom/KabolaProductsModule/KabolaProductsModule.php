<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Modules\Module;

/**
 * Class KabolaProductsModule
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule
 */
class KabolaProductsModule extends Module implements ModuleContract
{

    /**
     * KabolaProductsModule constructor.
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

    /**
     *
     */
    public function update()
    {
        // TODO: Implement update() method.
    }

    /**
     *
     */
    protected function buildMenu()
    {
        $this->addAdminMenuGroup('products', [
            'label' => "Producten",
            'icon'  => 'fa fa-archive',
        ], 20);

        $this->addAdminMenuItem('products', [
            'label' => 'Nieuw',
            'icon'  => 'fa fa-plus',
            'link'  => route('admin.products.create'),
        ]);

        $this->addAdminMenuItem('products', [
            'label' => 'Overzicht',
            'icon'  => 'fa fa-list',
            'link'  => route('admin.products.overview'),
        ]);

        $this->addAdminMenuItem('products', [
            'label' => 'Categoriën',
            'icon'  => 'fa fa-level-up',
            'link'  => route('admin.products.categories.overview'),
        ]);

        $this->addAdminMenuItem('products', [
            'label' => 'Attributen',
            'icon'  => 'fa fa-sliders',
            'link'  => route('admin.products.attributes.overview'),
        ]);

        $this->addAdminMenuItem('products', [
            'label' => 'Attribuut groepen',
            'icon'  => 'fa fa-plus-square',
            'link'  => route('admin.products.attributes.groups.overview'),
        ]);

        $this->addAdminMenuItem('products', [
            'label' => 'Verzoek op maat',
            'icon'  => 'fa fa-envelope',
            'link'  => route('admin.tailormade.requests'),
        ]);
    }
}