<?php
namespace Serff\Cms\Modules\Core\MediaModule\Services;

use Serff\Cms\Modules\Core\MediaModule\Cache\MediaCacheManager;
use Serff\Cms\Modules\Core\MediaModule\Domain\Models\Media;
use Serff\Cms\Modules\Core\MediaModule\Domain\Repositories\MediaRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

/**
 * Class MediaService
 *
 * @package Serff\Cms\Modules\Core\MediaModule\Services
 */
class MediaService
{
    /**
     * @var MediaRepository
     */
    protected $repository;
    /**
     * @var MediaCacheManager
     */
    protected $cacheManager;

    /**
     * MediaService constructor.
     *
     * @param MediaRepository $repository
     * @param MediaCacheManager $cacheManager
     */
    public function __construct(MediaRepository $repository, MediaCacheManager $cacheManager)
    {
        $this->repository = $repository;
        $this->cacheManager = $cacheManager;
    }

    /**
     * @param UploadedFile $file
     */
    public function upload(UploadedFile $file)
    {
        $media = $this->repository->create([
            'original_name' => $file->getClientOriginalName(),
            'extension'     => $file->getClientOriginalExtension(),
            'author_id'     => Auth::user()->id,
            'title'         => $file->getClientOriginalName(),
            'description'   => null,
            'width'         => 0,
            'height'        => 0,
        ]);
        $path = $this->getMediaPath($media);
        $file->move($path, $file->getClientOriginalName());
    }

    /**
     * @param $thumbnail_width
     * @param $display_width
     *
     * @return array
     */
    public function getLibraryItems($thumbnail_width, $display_width)
    {

        $items = $this->repository->getAll();
        $media_items = [];

        foreach ($items as $media) {
            /**
             * @var Media $media
             */
            $media_items[ $media->id ] = $this->cacheManager->rememberImage($media->id, function () use ($thumbnail_width, $display_width, $media) {
                return array_merge([
                    'thumbnail' => $this->getImage($media, $thumbnail_width),
                    'image'     => $this->getImage($media, $display_width),
                ], $media->toArray());
            });
        }

        return $media_items;
    }

    /**
     * @param Media $media
     *
     * @return string
     */
    public function getMediaPath(Media $media)
    {
        return storage_path(sprintf('media/%s/original/', $media->id));
    }

    /**
     * @param Media $media
     *
     * @return string
     */
    public function getMediaBasePath(Media $media)
    {
        return storage_path(sprintf('media/%s', $media->id));
    }

    /**
     * @param Media $media
     *
     * @return string
     */
    public function getMediaFullPath(Media $media)
    {
        $path = $this->getMediaPath($media);

        return sprintf('%s%s', $path, $media->original_name);
    }

    /**
     * @param Media $media
     * @param $width
     * @param $height
     * @param bool $with_file
     *
     * @return string
     */
    public function getMediaSizePath(Media $media, $width, $height, $with_file = true)
    {
        if (($width === null) && ($height === null)) {
            return $this->getMediaFullPath($media);
        }
        if ($with_file) {
            return storage_path(sprintf('media/%s/%sx%s/%s', $media->id, $width, $height, $media->original_name));
        }

        return storage_path(sprintf('media/%s/%sx%s', $media->id, $width, $height));
    }

    /**
     * @param Media $media
     * @param null $width
     * @param null $height
     *
     * @return string
     */
    public function getImage(Media $media, $width = null, $height = null)
    {
        $media_file = $this->getMediaSizePath($media, $width, $height);
        if ($this->imageExists($media_file)) {
            return ['file' => $media_file, 'width' => $width, 'height' => $height];
        }
        /**
         * @var \Intervention\Image\Image $image
         */
        $image = Image::make($this->getMediaFullPath($media));

        $ratio = $image->getWidth() / $image->getHeight();
        if ($width !== null) {
            if ($height === null) {
                $height = (int)($width / $ratio);
            }
        }
        $media_path = $this->getMediaSizePath($media, $width, $height, false);
        $media_file = $this->getMediaSizePath($media, $width, $height);
        if ($this->imageExists($media_file)) {
            return ['file' => $media_file, 'width' => $width, 'height' => $height];
        }
        $image->fit($width, $height);

        if ($this->imageExists($media_file) == false) {
            \File::makeDirectory($media_path);
            $image->save($media_file);
        }

        return ['file' => $media_file, 'width' => $width, 'height' => $height];
    }

    /**
     * @param $image
     *
     * @return bool
     */
    protected function imageExists($image)
    {
        return \File::exists($image);
    }

    /**
     * @param $media
     *
     * @throws \Exception
     */
    public function delete($media)
    {
        if (is_numeric($media)) {
            $media = $this->repository->getById($media);
        }

        $this->cacheManager->forgetImage($media->id);
        $media->delete();
    }

    public function getLibraryItemsJson($thumbnail_width, $display_width)
    {
        $items = $this->getLibraryItems($thumbnail_width, $display_width);

        return array_map(function ($item) {

            return [
                'thumb' => route('media.view', [
                    'id'     => array_get($item, 'id'),
                    'name'   => array_get($item, 'original_name'),
                    'width'  => array_get($item, 'thumbnail.width'),
                    'height' => array_get($item, 'thumbnail.height'),
                ]),
                'url'   => route('media.view', [
                    'id'     => array_get($item, 'id'),
                    'name'   => array_get($item, 'original_name'),
                    'width'  => array_get($item, 'image.width'),
                    'height' => array_get($item, 'image.height'),
                ]),
                'title' => array_get($item, 'title'),
                'id'    => array_get($item, 'id'),
            ];
        }, $items);
    }

}