<?php
namespace Serff\Cms\Modules\Custom\KabolaDealersModule;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Modules\Module;
use Serff\Cms\Modules\Custom\KabolaDealersModule\Domain\Models\Dealer;
use Serff\Cms\Modules\Custom\KabolaDealersModule\Observers\DealerObserver;

/**
 * Class KabolaDealersModule
 *
 * @package Serff\Cms\Modules\Custom\KabolaDealersModule
 */
class KabolaDealersModule extends Module implements ModuleContract
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

        $this->buildMenu();

        $this->registerViews();

        $this->registerObservers();
    }

    /**
     * @return bool
     */
    public function installed()
    {
        // TODO: Implement installed() method.
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
        $this->addAdminMenuGroup('kabola_dealers', [
            'label' => 'Kabola Dealers',
            'icon'  => 'fa fa-users',
        ], 100);

        $this->addAdminMenuItem('kabola_dealers', [
            'label' => 'Nieuw',
            'icon'  => 'fa fa-plus',
            'link'  => route('admin.kabola_dealers.create'),
        ]);

        $this->addAdminMenuItem('kabola_dealers', [
            'label' => 'Overzicht',
            'icon'  => 'fa fa-list',
            'link'  => route('admin.kabola_dealers.overview'),
        ]);

        $this->addAdminMenuItem('kabola_dealers', [
            'label' => 'Instellingen',
            'icon'  => 'fa fa-cogs',
            'link'  => route('admin.kabola_dealers.settings'),
        ]);
    }

    /**
     *
     */
    protected function registerObservers()
    {
        Dealer::observe(new DealerObserver());
    }
}