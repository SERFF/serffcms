<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories;

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
    public function getLatestItems($limit = 3)
    {
        return $this->model->limit($limit)->get();
    }

}