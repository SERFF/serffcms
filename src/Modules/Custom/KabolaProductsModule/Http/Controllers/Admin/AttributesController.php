<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Http\Controllers\Admin;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories\AttributeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class AttributesController
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Http\Controllers\Admin
 */
class AttributesController extends Controller
{
    /**
     * @var AttributeRepository
     */
    protected $attributeRepository;

    /**
     * AttributesController constructor.
     *
     * @param AttributeRepository $attributeRepository
     */
    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getOverview()
    {
        return ThemeView::getAdminView('admin.attributes.overview', [
            'attributes' => $this->attributeRepository->all(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getCreate()
    {
        return ThemeView::getAdminView('admin.attributes.create', [
            'attribute' => null,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getEdit($id)
    {
        return ThemeView::getAdminView('admin.attributes.edit', [
            'attribute' => $this->attributeRepository->getById($id),
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
            'name'  => 'required',
            'label' => 'required',
            'type'  => 'required',
        ]);
        
        $data = [
            'name'                 => Str::slug($request->get('name')),
            'label'                => $request->get('label'),
            'type'                 => $request->get('type'),
            'prefilled_list_items' => $request->get('prefilled_list_items'),
        ];

        if ($request->has('attribute_id')) {
            $this->attributeRepository->update($request->get('attribute_id'), $data);
            $attribute = $this->attributeRepository->getById($request->get('attribute_id'));
        } else {
            $attribute = $this->attributeRepository->create($data);
        }

        if ($attribute === null) {
            abort(500);
        }

        return redirect()->route('admin.products.attributes.edit', ['id' => $attribute->id]);
    }

}