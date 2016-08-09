<?php
namespace Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Repositories;

use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Models\Field;

/**
 * Class FieldRepository
 *
 * @package Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Repositories
 */
class FieldRepository extends Repository
{
    /**
     * FieldRepository constructor.
     *
     * @param Field $field
     */
    public function __construct(Field $field)
    {
        $this->model = $field;
    }
}