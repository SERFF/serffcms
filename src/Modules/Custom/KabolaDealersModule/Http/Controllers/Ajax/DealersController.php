<?php
namespace Serff\Cms\Modules\Custom\KabolaDealersModule\Http\Controllers\Ajax;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Serff\Cms\Modules\Custom\KabolaDealersModule\Domain\Repositories\DealerRepository;
use Illuminate\Http\Request;

/**
 * Class DealersController
 *
 * @package Serff\Cms\Modules\Custom\KabolaDealersModule\Http\Controllers\Ajax
 */
class DealersController extends Controller
{
    /**
     * @var DealerRepository
     */
    protected $dealerRepository;

    /**
     * DealersController constructor.
     *
     * @param DealerRepository $dealerRepository
     */
    public function __construct(DealerRepository $dealerRepository)
    {
        $this->dealerRepository = $dealerRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getDealers(Request $request)
    {
        $lat = $request->get('lat');
        $lng = $request->get('lng');

        $dealers = $this->dealerRepository->getByLatAndLong($lat, $lng, 10);
        
        return ThemeView::getAdminView('dealers', [
            'dealers' => $dealers
        ]);
    }

}