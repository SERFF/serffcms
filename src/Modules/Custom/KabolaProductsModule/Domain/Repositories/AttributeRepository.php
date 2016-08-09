<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories;

use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models\Attribute;

/**
 * Class AttributeRepository
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories
 */
class AttributeRepository extends Repository
{
    /**
     * AttributeRepository constructor.
     *
     * @param Attribute $attribute
     */
    public function __construct(Attribute $attribute)
    {
        $this->model = $attribute;
    }

    /**
     * @param $attribute_ids
     *
     * @return mixed
     */
    public function getWhereIdNotInList($attribute_ids)
    {
        return $this->model->whereNotIn('id', $attribute_ids)->get();
    }
}