<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories;

use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models\Category;

/**
 * Class CategoryRepository
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories
 */
class CategoryRepository extends Repository
{
    /**
     * CategoryRepository constructor.
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function filtered($filters)
    {
        $models = $this->model;

        $option_products = array_get($filters, 'option_products', []);
        
        if (count($option_products) > 0) {
            $models = $this->model->whereHas('products', function ($query) use ($option_products) {
                $query->whereIn('type', FilterAdapter::transformProductOptions($option_products));
            });
        }

        $models = $models->get();

        return $models;
    }  
    

}