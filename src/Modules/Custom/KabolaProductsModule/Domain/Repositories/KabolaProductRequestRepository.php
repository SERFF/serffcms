<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories;

use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models\KabolaProductRequest;

/**
 * Class KabolaProductRequestRepository
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories
 */
class KabolaProductRequestRepository extends Repository
{
    /**
     * KabolaProductRequestRepository constructor.
     *
     * @param KabolaProductRequest $request
     */
    public function __construct(KabolaProductRequest $request)
    {
        $this->model = $request;
    }

}