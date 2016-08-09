<?php
namespace Serff\Cms\Modules\Core\UsersModule;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Modules\Module;
use Serff\Cms\Modules\Core\UsersModule\Domain\Models\User\User;

class UsersModule extends Module implements ModuleContract
{
    /**
     * Options constructor.
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
    }

    public function install()
    {
        parent::install();
        $this->seed();
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

    /**
     * Create admin user
     */
    protected function seed()
    {
        //@todo: needs to be an incremental seed
        if (User::whereEmail('admin@serff.nl')->count() === 0) {
            User::create([
                'name'     => 'Admin',
                'email'    => 'admin@serff.nl',
                'password' => \Hash::make('admin'),
            ]);
        }
    }

    public function buildMenu()
    {
        $this->addAdminMenuGroup('users', [
            'label' => 'Gebruikers',
            'icon'  => 'fa fa-users',
        ], 15);

        $this->addAdminMenuItem('users', [
            'sort_order' => 1,
            'label'      => 'view',
            'link'       => '#',
        ]);
    }
}