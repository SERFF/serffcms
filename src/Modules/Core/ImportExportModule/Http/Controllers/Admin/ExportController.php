<?php
namespace Serff\Cms\Modules\Core\ImportExportModule\Http\Controllers\Admin;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\ImportExportModule\Services\ExportService;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Response;

/**
 * Class ExportController
 *
 * @package Serff\Cms\Modules\Core\ImportExportModule\Http\Controllers\Admin
 */
class ExportController extends Controller
{
    /**
     * @var ExportService
     */
    protected $exportService;

    /**
     * ExportController constructor.
     *
     * @param ExportService $exportService
     */
    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getExport()
    {
        $exports = $this->exportService->getExports();

        return ThemeView::getAdminView('admin.exports.overview', [
            'exports' => $exports,
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getCreate()
    {
        $this->exportService->createExport();

        return redirect()->route('admin.import-export.export');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $this->exportService->deleteExport($id);

        return redirect()->route('admin.import-export.export');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getDownload($id)
    {
        $export = $this->exportService->getExport($id);

        return Response::download(array_get($export,'path'), 'cmsexport.zip');
    }

}