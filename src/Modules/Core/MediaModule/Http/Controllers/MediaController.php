<?php
namespace Serff\Cms\Modules\Core\MediaModule\Http\Controllers;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\MediaModule\Domain\Models\Media;
use Serff\Cms\Modules\Core\MediaModule\Services\MediaService;

class MediaController extends Controller
{
    /**
     * @var MediaService
     */
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function getImage($id, $name, $width = null, $height = null)
    {
        $item = $this->mediaService->getImage(Media::find($id), $width, $height);
        
        $image = \Image::make(array_get($item, 'file'));
        
        return $image->response();
    }
}