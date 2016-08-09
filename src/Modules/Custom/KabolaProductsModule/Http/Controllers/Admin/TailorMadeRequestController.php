<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Http\Controllers\Admin;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories\KabolaProductRequestRepository;

/**
 * Class TailorMadeRequestController
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Http\Controllers\Admin
 */
class TailorMadeRequestController extends Controller
{
    /**
     * @var KabolaProductRequestRepository
     */
    protected $repository;

    /**
     * TailorMadeRequestController constructor.
     *
     * @param KabolaProductRequestRepository $repository
     */
    public function __construct(KabolaProductRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getIndex()
    {
        return ThemeView::getAdminView('admin.tailormade.requests', [
            'requests' => $this->repository->all(),
        ]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getView($id)
    {
        $request = $this->repository->getById($id);

        if ($request === null) {
            abort(500);
        }

        return ThemeView::getAdminView('admin.tailormade.view', [
            'request' => $request,
        ]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getHandle($id)
    {
        $request = $this->repository->getById($id);
        if ($request !== null) {
            $request->handled = !$request->handled;
            $request->save();
        }

        return redirect()->route('admin.tailormade.requests');
    }

}