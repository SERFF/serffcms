<?php
namespace Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Repositories;

use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Models\Rule;


/**
 * Class RuleRepository
 *
 * @package Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Repositories
 */
class RuleRepository extends Repository
{
    /**
     * RuleRepository constructor.
     *
     * @param Rule $rule
     */
    public function __construct(Rule $rule)
    {
        $this->model = $rule;
    }

}