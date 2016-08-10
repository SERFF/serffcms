<?php


/**
 * @param int $limit
 * @param bool $as_array
 *
 * @return mixed
 */
function get_latest_products($limit = 3, $as_array = false)
{
    $repo = app(\Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories\ProductRepository::class);
    $items = $repo->getLatestItems($limit);

    if (!$as_array) {
        return $items;
    } else {
        return $items->toArray();
    }
}


/**
 * @param $attribute_id
 * @param $product_attributes
 *
 * @return mixed|null
 */
function get_attribute_value($attribute_id, $product_attributes)
{
    foreach($product_attributes as $attribute) {
        if(array_get($attribute, 'id')==$attribute_id) {
            return array_get($attribute, 'pivot.value');
        }
    }
    return null;
}