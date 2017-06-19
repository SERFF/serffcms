<?php
namespace Serff\Cms\Modules\Core\MediaModule\Http\Controllers;

use Illuminate\Support\Facades\Cache;
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
        $cache_key = sprintf('image_cache_%s', md5($id.$width.$height.$name));
        
        return Cache::remember($cache_key, 99999, function () use ($id, $width, $height) {
            $item = $this->mediaService->getImage(Media::find($id), $width, $height);

            $image = \Image::make(array_get($item, 'file'));

            return $image->response();
        });
    }
}