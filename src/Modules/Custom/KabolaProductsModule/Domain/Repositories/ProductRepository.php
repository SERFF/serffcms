<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories;

use Illuminate\Support\Collection;
use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models\Product;

/**
 * Class ProductRepository
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories
 */
class ProductRepository extends Repository
{
    /**
     * ProductRepository constructor.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    /**
     * @param int $limit
     *
     * @return mixed
     */
    public function getRandomItems($limit = 3)
    {
        return $this->model->with(['category'])->inRandomOrder()->limit($limit)->get();
    }

    /**
     * @param $query
     *
     * @return Collection
     */
    public function search($query)
    {
        return $this->model
            ->with(['category'])
            ->whereHas('category', function($q) use($query) {
                $q->where('title', 'like', '%' . $query . '%');
                $q->orWhere('intro_text', 'like', '%' . $query . '%');
                $q->orWhere('product_content', 'like', '%' . $query . '%');
                $q->orWhere('overview_preview_text', 'like', '%' . $query . '%');
            })
            ->orWhere('name', 'like', '%' . $query .'%')
            ->get()
            ->map(function ($item) {
                $item->search_type = 'product';

                return $item;
            });
    }
}