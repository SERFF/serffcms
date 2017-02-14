<?php
namespace Serff\Cms\Modules\Core\CustomFieldsModule\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Models\Group;
use Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Repositories\FieldRepository;
use Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Repositories\GroupRepository;
use Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Repositories\RuleRepository;
use Serff\Cms\Modules\Core\CustomFieldsModule\Request\CustomFieldsRequest;
use Serff\Cms\Modules\Core\CustomFieldsModule\Service\CustomFieldsService;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;

/**
 * Class CustomFieldsController
 *
 * @package Serff\Cms\Modules\Core\CustomFieldsModule\Http\Controllers\Admin
 */
class CustomFieldsController extends Controller
{
    /**
     * @var CustomFieldsService
     */
    protected $customFieldsService;
    /**
     * @var GroupRepository
     */
    protected $groupRepository;
    /**
     * @var RuleRepository
     */
    protected $ruleRepository;

    /**
     * @var array
     */
    protected $cf_types = [
        'text'     => 'Tekstveld',
        'textarea' => 'Tekstgebied',
        'image'    => 'Afbeelding',
        'galery'   => 'Gallerij',
        'partial'  => 'Deelpagina(s)',
    ];

    /**
     * CustomFieldsController constructor.
     *
     * @param CustomFieldsService $customFieldsService
     * @param GroupRepository $groupRepository
     */
    public function __construct(CustomFieldsService $customFieldsService, GroupRepository $groupRepository, RuleRepository $ruleRepository)
    {
        $this->customFieldsService = $customFieldsService;
        $this->groupRepository = $groupRepository;
        $this->ruleRepository = $ruleRepository;
    }

    /**
     * @return View
     */
    public function getGroups()
    {
        return ThemeView::getAdminView('admin.customfields.group_overview', [
            'groups' => $this->groupRepository->all(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function getNewGroup(Request $request)
    {
        $old_data = $request->old();
        $rows = 1;
        $rules_rows = 1;
        foreach ($old_data as $key => $value) {
            if ($key === 'rules') {
                if (is_array($value)) {
                    if (count($value) > $rules_rows) {
                        $rules_rows = count($value);
                    }
                }
            }
            if (is_array($value)) {
                if (count($value) > $rows) {
                    $rows = count($value);
                }
            }
        }

        return ThemeView::getAdminView('admin.customfields.create_group', [
            'group'         => [],
            'custom_fields' => [],
            'rows'          => $rows,
            'rules_rows'    => $rules_rows,
            'input_types'   => $this->cf_types,
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     *
     * @return View
     */
    public function getEditGroup($id, Request $request)
    {
        $group = $this->groupRepository->getById($id, ['rules', 'fields']);
        if ($group === null) {
            abort(404);
        }

        $old_data = $request->old();

        $rows = $group->fields()->count();
        $rules_rows = $group->rules()->count();

        foreach ($old_data as $key => $value) {
            if ($key === 'rules') {
                if (is_array($value)) {
                    if (count($value) > $rules_rows) {
                        $rules_rows = count($value);
                    }
                }
            }
            if (is_array($value)) {
                if (count($value) > $rows) {
                    $rows = count($value);
                }
            }
        }

        return ThemeView::getAdminView('admin.customfields.edit_group', [
            'group'         => $group->toArray(),
            'custom_fields' => [],
            'rows'          => $rows,
            'rules_rows'    => $rules_rows,
            'input_types'   => $this->cf_types,
        ]);
    }

    /**
     * @param CustomFieldsRequest $request
     * @param FieldRepository $fieldRepository
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStore(CustomFieldsRequest $request, FieldRepository $fieldRepository)
    {
        /**
         * @var Group $group
         */
        $group_data = ['name' => $request->get('name'), 'status' => Group::STATUS_ACTIVE];
        $group_id = $request->get('group_id', null);
        if ($group_id !== null) {
            $this->groupRepository->update($group_id, $group_data);
            $group = $this->groupRepository->getById($group_id);
        } else {
            $group = $this->groupRepository->create($group_data);
        }

        $group->fields()->delete();
        $group->rules()->delete();

        $fields = [];
        $rules = [];

        $request_data = $request->all();
        foreach (array_get($request_data, 'input_label') as $key => $value) {
	        $required_field = array_get( $request_data, 'required.' . $key, false );
	        if($required_field == 'no') {
		        $required_field = false;
	        }
	        if($required_field == 'yes') {
		        $required_field = true;
	        }
	        $fields[]       = $fieldRepository->create([
		        'name'        => Str::slug(array_get($request_data, 'input_name.' . $key)),
		        'label'       => array_get($request_data, 'input_label.' . $key),
		        'type'        => array_get($request_data, 'input_type.' . $key),
		        'description' => array_get($request_data, 'description.' . $key, ''),
		        'required'    => $required_field,
            ]);
        }

        foreach (array_get($request_data, 'rules') as $key => $value) {
            $rules[] = $this->ruleRepository->create([
                'key'        => array_get($value, 'type'),
                'comparator' => array_get($value, 'comparator'),
                'value'      => array_get($value, 'key'),
            ]);
        }

        $group->fields()->saveMany($fields);
        $group->rules()->saveMany($rules);

        return redirect()->route('admin.customfields.groups');
    }

}