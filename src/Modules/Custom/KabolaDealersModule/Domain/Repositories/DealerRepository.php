<?php
namespace Serff\Cms\Modules\Custom\KabolaDealersModule\Domain\Repositories;

use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Custom\KabolaDealersModule\Domain\Models\Dealer;

/**
 * Class DealerRepository
 *
 * @package Serff\Cms\Modules\Custom\KabolaDealersModule\Domain\Repositories
 */
class DealerRepository extends Repository
{
    /**
     * DealerRepository constructor.
     *
     * @param Dealer $dealer
     */
    public function __construct(Dealer $dealer)
    {
        $this->model = $dealer;
    }

    /**
     * @param $lat
     * @param $lng
     * @param $limit
     *
     * @return \Illuminate\Database\Eloquent\Collection|static
     */
    public function getByLatAndLong($lat, $lng, $limit)
    {
        $dealers = $this->all();

        $dealers = $dealers->map(function ($item) use ($lat, $lng) {
            $item->distance = distance($lat, $lng, $item->latitude, $item->longitude);

            return $item;
        });

        $dealers = $dealers->sortBy('distance');

        $dealers = $dealers->slice(0, $limit);

        return $dealers;
    }

}