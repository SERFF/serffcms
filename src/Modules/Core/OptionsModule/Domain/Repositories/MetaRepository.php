<?php
namespace Serff\Cms\Modules\Core\OptionsModule\Domain\Repositories;

use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Core\OptionsModule\Domain\Models\Meta;

/**
 * Class MetaRepository
 *
 * @package Serff\Cms\Modules\Core\OptionsModule\Domain\Repositories
 */
class MetaRepository extends Repository
{
    /**
     * MetaRepository constructor.
     *
     * @param Meta $meta
     */
    public function __construct(Meta $meta)
    {
        $this->model = $meta;
    }

    /**
     * @param $type_id
     * @param $type
     * @param $key
     *
     * @return Meta||null
     */
    public function getByTypeAndKey($type_id, $type, $key)
    {
        return $this->model->where('type_id', $type_id)
            ->where('type', $type)
            ->where('name', $key)
            ->first();
    }
}