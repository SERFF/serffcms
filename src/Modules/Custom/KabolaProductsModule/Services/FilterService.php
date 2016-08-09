<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Services;

use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models\Category;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models\Product;
use DB;

class FilterService
{
    /**
     * @var Category
     */
    protected $category;
    /**
     * @var Product
     */
    protected $product;

    public function __construct(Category $category, Product $product)
    {
        $this->category = $category;
        $this->product = $product;
    }

    public function filtered($filters)
    {
        $items = $this->getItems($filters);

        return $items->map(function ($item, $key) {
            $item = $item->toArray();

            return [
                'id'                    => array_get($item, 'category.id'),
                'product_id'            => array_get($item, 'id'),
                'product_image'         => array_get($item, 'category.product_image'),
                'title'                 => array_get($item, 'category.title') . ' ' . array_get($item, 'name'),
                'overview_preview_text' => array_get($item, 'category.overview_preview_text'),
                'intro_text'            => array_get($item, 'category.intro_text'),
            ];
        });
    }

    protected function getItems($filters)
    {
        $option_products = FilterAdapter::transformProductOptions(array_get($filters, 'option_products', []));
        $water_cb = FilterAdapter::transformWaterCb(array_get($filters, 'water_cb', []));
        $capacity = FilterAdapter::transformCapacity(array_get($filters, 'capacity', []));
        $efficiency = FilterAdapter::transformEfficiency(array_get($filters, 'efficiency', []));

        $builder = $this->product
            ->with(["category", "attributes"])
            ->select([
                '*',
                DB::raw('(select importance from categories where id = products.category_id) as importance'),
                DB::raw('(select CAST(value as SIGNED) from product_attributes where attribute_id = 1 and product_id = products.id) as capacity'),
            ])
            ->whereIn("type", $option_products)
            ->whereRaw("(select value from product_attributes where attribute_id = 1 and product_id = products.id) >= " . array_get($capacity, "min", 0))
            ->whereRaw("(select value from product_attributes where attribute_id = 1 and product_id = products.id) <= " . array_get($capacity, "max", 0))
            ->whereRaw("(select value from product_attributes where attribute_id = 23 and product_id = products.id) >= " . array_get($water_cb, "min", 0))
            ->whereRaw("(select value from product_attributes where attribute_id = 23 and product_id = products.id) <= " . array_get($water_cb, "max", 0))
            ->whereRaw("(SELECT replace(value, '>', '') FROM product_attributes WHERE attribute_id = 22 AND product_id = products.id) in (" . implode(',', $efficiency) . ')')
            ->orderBy('importance', 'desc')
            ->orderBy('capacity', 'desc');

        return $builder->get();
    }

}