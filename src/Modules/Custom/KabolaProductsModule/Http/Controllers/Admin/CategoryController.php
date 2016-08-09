<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Http\Controllers\Admin;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\MediaModule\Domain\Repositories\MediaRepository;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories\AttributeGroupRepository;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories\CategoryRepository;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Requests\ProductRequest;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Http\Controllers\Admin
 */
class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;
    /**
     * @var MediaRepository
     */
    protected $mediaRepository;
    /**
     * @var AttributeGroupRepository
     */
    protected $attributeGroupRepository;

    /**
     * CategoryController constructor.
     *
     * @param CategoryRepository $categoryRepository
     * @param MediaRepository $mediaRepository
     * @param AttributeGroupRepository $attributeGroupRepository
     */
    public function __construct(CategoryRepository $categoryRepository,
                                MediaRepository $mediaRepository,
                                AttributeGroupRepository $attributeGroupRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->mediaRepository = $mediaRepository;
        $this->attributeGroupRepository = $attributeGroupRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getOverview()
    {
        return ThemeView::getAdminView('admin.categories.overview', [
            'categories' => $this->categoryRepository->all(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getCreate()
    {
        return ThemeView::getAdminView('admin.categories.create', [
            'category'                  => null,
            'attribute_groups'          => $this->attributeGroupRepository->all(),
            'selected_attribute_groups' => collect(),
            'wysiwyg_css'               => ThemeView::getWysiwygCssRoute(),
        ]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getEdit($id)
    {
        $category = $this->categoryRepository->getById($id);
        $gallery = get_meta_value($id, 'category', 'product_gallery', []);
        $category->product_gallery = implode('|', array_pluck($gallery, 'id'));

        return ThemeView::getAdminView('admin.categories.edit', [
            'category'                  => $category,
            'attribute_groups'          => $this->attributeGroupRepository->all(),
            'selected_attribute_groups' => $category->attributeGroups()->get(),
            'wysiwyg_css'               => ThemeView::getWysiwygCssRoute(),
        ]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $category = $this->categoryRepository->getById($id);
        $category->delete();

        return redirect()->route('admin.products.categories.overview');
    }

    /**
     * @param ProductRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStore(ProductRequest $request)
    {
        $gallery = $request->get('product_gallery');
        $items = [];
        foreach (explode('|', $gallery) as $item) {
            if (is_numeric($item)) {
                $items[] = $this->mediaRepository->getById($item);
            }
        }
        $category = null;
        $category_id = $request->get('category_id', '');

        $data = [
            'name'                  => $request->get('name'),
            'title'                 => $request->get('title'),
            'importance'            => $request->get('importance'),
            'product_image'         => $request->get('product_image'),
            'intro_text'            => $request->get('intro_text'),
            'product_content'       => $request->get('product_content'),
            'overview_preview_text' => $request->get('overview_preview_text'),
        ];

        if (is_numeric($category_id)) {
            $this->categoryRepository->update($category_id, $data);
            $category = $this->categoryRepository->getById($category_id);

        } else {
            $category = $this->categoryRepository->create($data);
        }

        $ids = [];
        foreach ($request->get('attribute_groups', []) as $group_id) {
            $ids = array_merge($this->attributeGroupRepository->getById($group_id)->attributes()->get()->pluck('id')->toArray(), $ids);
        }
        $ids = array_unique($ids);
        $category->attributes()->sync($ids);
        $category->attributeGroups()->sync($request->get('attribute_groups', []));


        if ($category === null) {
            abort(500);
        }

        set_meta_value(array_get($category->toArray(), 'id'), 'category', 'product_gallery', serialize(collect($items)));

        return redirect()->route('admin.products.categories.edit', ['id' => $category->id]);
    }

}