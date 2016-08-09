<?php
namespace Serff\Cms\Modules\Core\PagesModule;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Modules\Module;

class PagesModule extends Module implements ModuleContract
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
        $this->addAdminMenuGroup('pages', [
            'label' => "Pagina's",
            'icon'  => 'fa fa-file-text',
        ], 1);

        $this->addAdminMenuItem('pages', [
            'label' => 'Nieuw',
            'icon'  => 'fa fa-plus',
            'link'  => route('admin.pages.create'),
        ]);

        $this->addAdminMenuItem('pages', [
            'label' => 'Overzicht',
            'icon'  => 'fa fa-list',
            'link'  => route('admin.pages.overview'),
        ]);
    }

    /**
     * @return array
     */
    public static function getOverviewDisplayFields()
    {
        return [
            [
                'label' => '#',
                'key'   => 'id',
                'order' => 10,
            ],
            [
                'label' => 'Titel',
                'key'   => 'title',
                'order' => 20,
            ],
            [
                'label' => 'Locale',
                'key'   => 'locale',
                'order' => 30,
            ],
            [
                'label' => 'Status',
                'key'   => 'status',
                'order' => 40,
            ],
        ];
    }

    /**
     * Return formatter rules
     *
     * @return array
     */
    public static function getFormatter()
    {
        return [
            'locale' => function ($record) {
                return strtoupper(array_get($record, 'locale'));
            },
            'status' => function ($record) {
                return ucfirst(strtolower(array_get($record, 'status')));
            },
        ];
    }

}