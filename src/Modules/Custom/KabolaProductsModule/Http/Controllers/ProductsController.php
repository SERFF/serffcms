<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Http\Controllers;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories\CategoryRepository;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories\ProductRepository;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Services\FilterService;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Services\TailorMadeService;
use Illuminate\Http\Request;

/**
 * Class ProductsController
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Http\Controllers
 */
class ProductsController extends Controller
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * ProductsController constructor.
     *
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getView($id)
    {
        $product = $this->productRepository->getById($id);
        if ($product === null) {
            abort(404);
        }

        return ThemeView::getView('single-product', [
            'product' => $product->toArray(),
            'menu'    => $this->getMenu(),
        ]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getCategoryView($id)
    {
        $category = $this->categoryRepository->getById($id, ['attributes', 'products.attributes']);

        return ThemeView::getView('category-view', [
            'category' => $category->toArray(),
            'menu'     => $this->getMenu(),
        ]);
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function postFiltered(Request $request)
    {
        $filters = [
            'option_products' => $request->get('option_products', []),
            'water_cb'        => $request->get('water_cb', []),
            'capacity'        => $request->get('capacity', []),
            'efficiency'      => $request->get('efficiency', []),
            'appliance'       => $request->get('appliciance', []),
        ];

        $this->storeSessionData($filters);

        $categories = app(FilterService::class)->filtered($filters);

        $best_choice = null;

        if (count($categories) < 10) {
            $best_choice = array_get($categories, 0, null);
        }

        return ThemeView::getView('partials.products', [
            'categories'       => $categories,
            'best_choice'      => $best_choice,
            'products_defined' => true,
        ]);
    }

    /**
     * Store the session request data for tailor made suggestions
     *
     * @param $data
     */
    protected function storeSessionData($data)
    {
        \Session::set('product_filter', $data);
    }

    /**
     * @param Request $request
     * @param TailorMadeService $tailorMadeService
     */
    public function postTailorMade(Request $request, TailorMadeService $tailorMadeService)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $tailorMadeService->send($request->get('email'), $request->get('phone'));
    }
}