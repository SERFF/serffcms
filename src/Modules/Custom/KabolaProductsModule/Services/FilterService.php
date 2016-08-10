<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Services;

use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models\Category;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models\Product;
use DB;

/**
 * Class FilterService
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Services
 */
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

    /**
     * FilterService constructor.
     *
     * @param Category $category
     * @param Product $product
     */
    public function __construct(Category $category, Product $product)
    {
        $this->category = $category;
        $this->product = $product;
    }

    /**
     * @param $filters
     *
     * @return mixed
     */
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
                'water_capacity'        => $this->getAttribute('waterinhoud-ketel', array_get($item, 'attributes')),
                'capacity'              => $this->getAttribute('capaciteit-in-kw', array_get($item, 'attributes')),
                'build_size_w'          => $this->getAttribute('breedte-inbouwmaat', array_get($item, 'attributes')),
                'build_size_d'          => $this->getAttribute('diepte-inbouwmaat', array_get($item, 'attributes')),
                'build_size_h'          => $this->getAttribute('hoogte-inbouwmaat', array_get($item, 'attributes')),
            ];
        });
    }

    /**
     * @param $name
     * @param $items
     *
     * @return mixed|null
     */
    protected function getAttribute($name, $items)
    {
        foreach ($items as $item) {
            if (array_get($item, 'name') == $name) {
                return array_get($item, 'pivot.value');
            }
        }

        return null;
    }

    /**
     * @param $filters
     *
     * @return mixed
     */
    protected function getItems($filters)
    {
        $option_products = FilterAdapter::transformProductOptions(array_get($filters, 'option_products', []));
        $water_cb = FilterAdapter::transformWaterCb(array_get($filters, 'water_cb', []));
        $capacity = FilterAdapter::transformCapacity(array_get($filters, 'capacity', []));
        //$efficiency = FilterAdapter::transformEfficiency(array_get($filters, 'efficiency', []));
        $appliciance = FilterAdapter::transformAppliciance(array_get($filters, 'appliance', []));

        $builder = $this->product
            ->with(["category", "attributes"])
            ->select([
                '*',
                DB::raw('(select importance from categories where id = products.category_id) as importance'),
                DB::raw('(select CAST(value as SIGNED) from product_attributes where attribute_id = 1 and product_id = products.id) as capacity'),
            ]);
        if (count(array_get($filters, 'option_products', [])) > 0) {
            $builder->whereIn("type", $option_products);
        }


        $builder->whereIn("type", $appliciance)
            ->whereRaw("(select CAST(replace(value, ',', '.') AS DECIMAL(9,2)) from product_attributes where attribute_id = 1 and product_id = products.id) >= " . array_get($capacity, "min", 0))
            ->whereRaw("(select CAST(replace(value, ',', '.') AS DECIMAL(9,2)) from product_attributes where attribute_id = 1 and product_id = products.id) <= " . array_get($capacity, "max", 0))
            ->whereRaw("(select CAST(replace(value, ',', '.') AS DECIMAL(9,2)) from product_attributes where attribute_id = 23 and product_id = products.id) >= " . array_get($water_cb, "min", 0))
            ->whereRaw("(select CAST(replace(value, ',', '.') AS DECIMAL(9,2)) from product_attributes where attribute_id = 23 and product_id = products.id) <= " . array_get($water_cb, "max", 0))
            //->whereRaw("(SELECT replace(value, '>', '') FROM product_attributes WHERE attribute_id = 22 AND product_id = products.id) in (" . implode(',', $efficiency) . ')')
            ->orderBy('importance', 'desc')
            ->orderBy('capacity', 'desc');

        return $builder->get();
    }

}