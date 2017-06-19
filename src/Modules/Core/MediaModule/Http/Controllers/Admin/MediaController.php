<?php
namespace Serff\Cms\Modules\Core\MediaModule\Http\Controllers\Admin;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\MediaModule\Cache\MediaCacheManager;
use Serff\Cms\Modules\Core\MediaModule\Requests\UploadRequest;
use Serff\Cms\Modules\Core\MediaModule\Services\MediaService;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;

class MediaController extends Controller
{
    /**
     * @var MediaService
     */
    protected $mediaService;
    /**
     * @var MediaCacheManager
     */
    protected $cacheManager;

    public function __construct(MediaService $mediaService, MediaCacheManager $cacheManager)
    {
        $this->mediaService = $mediaService;
        $this->cacheManager = $cacheManager;

    }

    public function getLibrary()
    {
        return ThemeView::getAdminView('admin.media.library', [
            'media' => $this->mediaService->getLibraryItems(150, 500),
        ]);
    }

    public function getAdd()
    {
        return ThemeView::getAdminView('admin.media.add');
    }

    public function postUpload(UploadRequest $request)
    {
        $this->mediaService->upload($request->file('file'));
    }

    public function getDelete($id)
    {
        $this->mediaService->delete($id);

        return redirect()->back();
    }

    public function getImagesJson()
    {
        return $this->mediaService->getLibraryItemsJson(150, 500);
    }

}