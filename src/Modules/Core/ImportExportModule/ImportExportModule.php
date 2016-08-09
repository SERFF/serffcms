<?php
namespace Serff\Cms\Modules\Core\ImportExportModule;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Modules\Module;
use Serff\Cms\Modules\Core\ImportExportModule\Console\ImportExport;

/**
 * Class ImportExportModule
 *
 * @package Serff\Cms\Modules\Core\ImportExportModule
 */
class ImportExportModule extends Module implements ModuleContract
{
    /**
     * ImportExportModule constructor.
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
        
        $this->registerConsoleCommands();
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
        $this->addAdminMenuGroup('import-export', [
            'label' => 'Import/Export',
            'icon'  => 'fa fa-exchange',
        ], 999);

        $this->addAdminMenuItem('import-export', [
            'label' => 'Export',
            'icon'  => 'fa fa-download',
            'link'  => route('admin.import-export.export'),
        ]);
    }

    /**
     *
     */
    protected function registerConsoleCommands()
    {
        $this->addConsoleCommand(ImportExport::class);
    }
}