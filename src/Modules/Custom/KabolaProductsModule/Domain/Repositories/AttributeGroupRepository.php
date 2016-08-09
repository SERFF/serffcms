<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories;

use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models\AttributeGroup;

/**
 * Class AttributeGroupRepository
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories
 */
class AttributeGroupRepository extends Repository
{
    /**
     * AttributeGroupRepository constructor.
     *
     * @param AttributeGroup $attributeGroup
     */
    public function __construct(AttributeGroup $attributeGroup)
    {
        $this->model = $attributeGroup;
    }
}