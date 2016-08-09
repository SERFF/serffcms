<?php
namespace Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Models\Group;

/**
 * Class GroupRepository
 *
 * @package Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Repositories
 */
class GroupRepository extends Repository
{
    /**
     * GroupRepository constructor.
     *
     * @param Group $group
     */
    public function __construct(Group $group)
    {
        $this->model = $group;
    }

    /**
     * @return Collection
     */
    public function all()
    {
        return $this->model->get();
    }
}