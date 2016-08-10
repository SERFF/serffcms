<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Http\Controllers;

use Illuminate\Http\Request;
use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Services\FilterService;

/**
 * Class ConfiguratorController
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Http\Controllers
 */
class ConfiguratorController extends Controller
{
    public function getOverview()
    {
        return ThemeView::getView('configurator_overview', [
            'menu' => $this->getMenu(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCalculate(Request $request)
    {
        $data = [
            'application'      => $request->get('application'),
            'heating_m3'       => $request->get('heating_m3'),
            'isolation'        => $request->get('isolation'),
            'application_area' => $request->get('application_area'),
        ];

        $this->storeSessionData($data);

        return redirect()->route('configurator.overview');
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function postFiltered(Request $request)
    {
        $filters = [
            'application'      => $request->get('application'),
            'heating_m3'       => $request->get('heating_m3'),
            'isolation'        => $request->get('isolation'),
            'application_area' => $request->get('application_area'),
        ];

        $filters = $this->handleFilters($filters);
        \Log::info($filters);
        $this->storeSessionData($filters);

        $categories = app(FilterService::class)->filtered($filters);

        $best_choice = null;

        if (count($categories) < 10) {
            $best_choice = array_get($categories, 0, null);
        }

        return ThemeView::getView('partials.products', [
            'categories'       => $categories,
            'best_choice'      => $best_choice,
            'products_defined' => true,
        ]);
    }

    protected function storeSessionData($data)
    {
        \Session::put('configurator_filter', $data);
    }

    protected function handleFilters($filters)
    {
        $filters = [
            'application'      => array_get($filters, 'application', []),
            'heating_m3'       => array_get(array_get($filters, 'heating_m3', []), 0),
            'isolation'        => array_get(array_get($filters, 'isolation', []), 0),
            'application_area' => array_get(array_get($filters, 'application_area', []), 0),
        ];

        return $filters;
    }
}