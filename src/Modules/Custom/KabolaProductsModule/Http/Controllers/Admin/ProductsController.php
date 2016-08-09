<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Http\Controllers\Admin;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\MediaModule\Domain\Repositories\MediaRepository;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models\Product;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories\CategoryRepository;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories\ProductRepository;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Requests\ProductRequest;
use Illuminate\Http\Request;

/**
 * Class ProductsController
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Http\Controllers\Admin
 */
class ProductsController extends Controller
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;
    /**
     * @var MediaRepository
     */
    protected $mediaRepository;
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * ProductsController constructor.
     *
     * @param ProductRepository $productRepository
     * @param MediaRepository $mediaRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(ProductRepository $productRepository,
                                MediaRepository $mediaRepository,
                                CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->mediaRepository = $mediaRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getOverview()
    {
        return ThemeView::getAdminView('admin.products.overview', [
            'products' => $this->productRepository->all(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getCreate()
    {
        return ThemeView::getAdminView('admin.products.create', [
            'product'     => [],
            'categories'  => $this->categoryRepository->all(),
            'wysiwyg_css' => ThemeView::getWysiwygCssRoute(),
        ]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getEdit($id)
    {
        $product = $this->productRepository->getById($id, 'attributes');
        $gallery = get_meta_value($id, 'product', 'product_gallery', []);
        $product->product_gallery = implode('|', array_pluck($gallery, 'id'));

        return ThemeView::getAdminView('admin.products.edit', [
            'product'     => $product->toArray(),
            'categories'  => $this->categoryRepository->all(),
            'wysiwyg_css' => ThemeView::getWysiwygCssRoute(),
        ]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $product = $this->productRepository->getById($id, 'attributes');
        $product->delete();

        return redirect()->route('admin.products.overview');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStore(Request $request)
    {
        $product = null;
        $product_id = $request->get('product_id', '');

        $data = [
            'name'        => $request->get('name'),
            'type'        => $request->get('type'),
            'category_id' => $request->get('category_id'),
        ];
        if (is_numeric($product_id)) {
            $this->productRepository->update($product_id, $data);
            $product = $this->productRepository->getById($product_id);

        } else {
            $product = $this->productRepository->create($data);
        }
        $this->saveProductAttribute($product, $request->all());
        $this->handleProductAttributes($product);

        if ($product === null) {
            abort(500);
        }


        return redirect()->route('admin.products.edit', ['id' => $product->id]);
    }

    /**
     * @param Product $product
     */
    protected function handleProductAttributes(Product $product)
    {
        $product->load('category.attributes');

        foreach ($product->category->attributes as $attribute) {
            if ($product->attributes()->where('attribute_id', $attribute->id)->count() == 0) {
                $product->attributes()->attach($attribute->id);
            }
        }

    }

    /**
     * @param $product
     * @param $data
     */
    protected function saveProductAttribute($product, $data)
    {
        $attributes = [];
        foreach ($data as $key => $value) {
            if (starts_with($key, 'attr_')) {
                $attributes[ str_replace('attr_', '', $key) ] = $value;
            }
        }

        foreach ($attributes as $id => $value) {
            $product->attributes()->where('attribute_id', $id)->update(['value' => $value]);
        }
    }

}