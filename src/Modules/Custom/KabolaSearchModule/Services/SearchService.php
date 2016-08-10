<?php
namespace Serff\Cms\Modules\Custom\KabolaSearchModule\Services;

use Serff\Cms\Modules\Core\PagesModule\Domain\Repositories\PagesRepository;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories\ProductRepository;

/**
 * Class SearchService
 *
 * @package Serff\Cms\Modules\Custom\KabolaSearchModule\Services
 */
class SearchService
{
    /**
     * @var PagesRepository
     */
    protected $pagesRepository;
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * SearchService constructor.
     *
     * @param PagesRepository $pagesRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(PagesRepository $pagesRepository, ProductRepository $productRepository)
    {
        $this->pagesRepository = $pagesRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param $query
     *
     * @return array
     */
    public function search($query)
    {
        $pages = $this->pagesRepository->search($query);
        $products = $this->productRepository->search($query);

        return array_map(function($item) { return $this->transformSearchItem($item); }, array_merge($pages->toArray(), $products->toArray()));
    }

    /**
     * @param $item
     *
     * @return mixed
     */
    protected function transformSearchItem($item)
    {
        switch (array_get($item, 'search_type', null)) {
            case 'product':
                return $this->transformProduct($item);
                break;
            case 'page':
            default:
                return $this->transformPage($item);
                break;
        }
    }

    /**
     * @param $item
     *
     * @return array
     */
    protected function transformProduct($item)
    {
        return [
            'title'      => sprintf('%s %s', array_get($item, 'category.title', ''), array_get($item, 'name', '')),
            'date'       => date('d-m-Y', strtotime(array_get($item, 'updated_at', date('d-m-Y')))),
            'intro_text' => array_get($item, 'category.intro_text'),
            'link'       => route('product.category.view', ['id' => array_get($item, 'category.id')]) . '?selected_product=' . array_get($item, 'id'),
        ];
    }

    /**
     * @param $item
     *
     * @return array
     */
    protected function transformPage($item)
    {
        return [
            'title'      => array_get($item, 'title'),
            'date'       => date('d-m-Y', strtotime(array_get($item, 'updated_at', date('d-m-Y')))),
            'intro_text' => substr(strip_tags(array_get($item, 'content')), 0, 300),
            'link'       => route_with_locale('page', ['slug' => array_get($item, 'slug')]),
        ];
    }

}