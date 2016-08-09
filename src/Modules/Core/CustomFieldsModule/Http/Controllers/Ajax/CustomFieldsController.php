<?php
namespace Serff\Cms\Modules\Core\CustomFieldsModule\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\PagesModule\Domain\Repositories\PagesRepository;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;

/**
 * Class CustomFieldsController
 *
 * @package Serff\Cms\Modules\Core\CustomFieldsModule\Http\Controllers\Ajax
 */
class CustomFieldsController extends Controller
{
    /**
     * @var PagesRepository
     */
    protected $pagesRepository;

    /**
     * CustomFieldsController constructor.
     *
     * @param PagesRepository $pagesRepository
     */
    public function __construct(PagesRepository $pagesRepository)
    {
        $this->pagesRepository = $pagesRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRulesValues(Request $request)
    {
        $type = $request->get('type');
        $items = [];

        switch ($type) {
            case 'template':
                $items = array_pluck(ThemeView::getActiveTheme()->getTemplates(), 'name', 'slug');
                break;
            case 'page':
                $items = array_pluck($this->pagesRepository->all()->toArray(), 'title', 'id');
                break;
        }

        $result = [];
        foreach ($items as $key => $value) {
            $result[] = [$key => $value];
        }

        return response()->json($result);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getGalleryModal()
    {
        return ThemeView::getAdminView('admin.customfields.image.gallery_modal', []);
    }

}