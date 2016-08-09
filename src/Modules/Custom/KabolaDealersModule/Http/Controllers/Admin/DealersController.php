<?php
namespace Serff\Cms\Modules\Custom\KabolaDealersModule\Http\Controllers\Admin;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\OptionsModule\OptionsModule;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Serff\Cms\Modules\Custom\KabolaDealersModule\Domain\Repositories\DealerRepository;
use Serff\Cms\Modules\Custom\KabolaDealersModule\Requests\DealerRequest;
use Illuminate\Http\Request;

/**
 * Class DealersController
 *
 * @package Serff\Cms\Modules\Custom\KabolaDealersModule\Http\Controllers\Admin
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
     * @return \Illuminate\Contracts\View\View
     */
    public function getCreate()
    {
        return ThemeView::getAdminView('admin.kabolaDealers.create', [
            'dealer' => [],
        ]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getEdit($id)
    {
        $dealer = $this->dealerRepository->getById($id);
        if ($dealer === null) {
            abort(500);
        }

        return ThemeView::getAdminView('admin.kabolaDealers.edit', [
            'dealer' => $dealer->toArray(),
        ]);
    }

    /**
     * @param DealerRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStore(DealerRequest $request)
    {
        $data = array_except($request->all(), ['_token']);
        if (is_numeric(array_get($data, 'id'))) {
            $this->dealerRepository->update(array_get($data, 'id'), $data);
            $dealer = $this->dealerRepository->getById(array_get($data, 'id'));
        } else {
            $dealer = $this->dealerRepository->create($data);
        }

        if ($dealer === null) {
            abort(500);
        }

        return redirect()->route('admin.kabola_dealers.edit', ['id' => $dealer->id]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getOverview()
    {
        return ThemeView::getAdminView('admin.kabolaDealers.overview', [
            'dealers' => $this->dealerRepository->all(),
        ]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $dealer = $this->dealerRepository->getById($id);
        if ($dealer === null) {
            abort(404);
        }
        $dealer->delete();

        return redirect()->route('admin.kabola_dealers.overview');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getSettings()
    {
        return ThemeView::getAdminView('admin.kabolaDealers.settings', [
            'settings' => OptionsModule::getOptionGroup('kabola_dealers'),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStoreSettings(Request $request)
    {
        set_option('kabola_dealers.google_maps_js_api_key', $request->get('google_maps_js_api_key'));

        return redirect()->route('admin.kabola_dealers.settings');
    }
}
