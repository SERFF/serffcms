<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Http\Controllers\Admin;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories\AttributeGroupRepository;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories\AttributeRepository;
use Illuminate\Http\Request;

/**
 * Class AttributeGroupsController
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Http\Controllers\Admin
 */
class AttributeGroupsController extends Controller
{
    /**
     * @var AttributeGroupRepository
     */
    protected $attributeGroupRepository;
    /**
     * @var AttributeRepository
     */
    protected $attributeRepository;

    /**
     * AttributeGroupsController constructor.
     *
     * @param AttributeGroupRepository $attributeGroupRepository
     * @param AttributeRepository $attributeRepository
     */
    public function __construct(AttributeGroupRepository $attributeGroupRepository, AttributeRepository $attributeRepository)
    {
        $this->attributeGroupRepository = $attributeGroupRepository;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getEdit($id)
    {
        $group = $this->attributeGroupRepository->getById($id);

        $attribute_ids = array_pluck($group->attributes()->get()->toArray(), 'id');

        return ThemeView::getAdminView('admin.attribute_groups.edit', [
            'group'                      => $group,
            'selected_attributes'        => $group->attributes()->get(),
            'selected_attributes_string' => implode('||', $attribute_ids),
            'available_attributes'       => $this->attributeRepository->getWhereIdNotInList($attribute_ids),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getCreate()
    {
        return ThemeView::getAdminView('admin.attribute_groups.create', [
            'group'                      => null,
            'available_attributes'       => $this->attributeRepository->all(),
            'selected_attributes_string' => '',
            'selected_attributes'        => collect(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getOverview()
    {
        return ThemeView::getAdminView('admin.attribute_groups.overview', [
            'groups' => $this->attributeGroupRepository->all(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStore(Request $request)
    {
        $this->validate($request, [
            'selected_attributes' => 'required',
            'name'                => 'required',
        ]);

        $data = [
            'name' => $request->get('name'),
        ];
        $selected_attributes = explode('||', $request->get('selected_attributes'));

        if ($request->has('attribute_group_id')) {
            $attribute_group_id = $request->get('attribute_group_id');
            $this->attributeGroupRepository->update($attribute_group_id, $data);
            $group = $this->attributeGroupRepository->getById($attribute_group_id);
        } else {
            $group = $this->attributeGroupRepository->create($data);
        }
        $group->attributes()->sync($selected_attributes);
        if ($group === null) {
            abort(500);
        }

        return redirect()->route('admin.products.attributes.groups.edit', ['id' => $group->id]);
    }

}