<?php
namespace Serff\Cms\Modules\Core\CustomFieldsModule;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Modules\Module;
use Serff\Cms\Modules\Core\CustomFieldsModule\Service\CustomFieldsService;

class CustomFieldsModule extends Module implements ModuleContract
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

        $this->registerHooks();
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
        $this->addAdminMenuGroup('customfields', [
            'label' => 'Extra velden',
            'icon'  => 'fa fa-columns',
        ], 50);

        $this->addAdminMenuItem('customfields', [
            'label' => 'Groepen',
            'icon'  => 'fa fa-list',
            'link'  => route('admin.customfields.groups'),
        ]);

        $this->addAdminMenuItem('customfields', [
            'label' => 'Nieuwe groep',
            'icon'  => 'fa fa-plus',
            'link'  => route('admin.customfields.new_group'),
        ]);
    }

    protected function registerHooks()
    {
        $service = app(CustomFieldsService::class);
        \Hook::registerFormHook('pages.form', function ($record = [], $type) use ($service) {
            return $service->getViewsForRecord($record, $type);
        });

        //Hook::registerFormValidation('pages.form', [], []); // add validation on required items

        \Hook::registerFormSubmit('pages.form', function ($request, $record) use ($service) {
            $inputs = $service->getInputsForRecord($record, Page::class);

            foreach ($inputs as $input) {
                $slug = str_slug(array_get($input, 'group.name')) . '_' . array_get($input, 'name');
                $key = str_slug(array_get($input, 'group.name')) . '.' . array_get($input, 'name');
                $value = $service->getValueForInput($input, $request->get($slug, ''));
                set_meta_value(array_get($record, 'id'), 'page', $key, $value);
            }
        });
    }
}