<?php
namespace Serff\Cms\Modules\Core\MediaModule\Domain\Repositories;

use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Core\MediaModule\Domain\Models\Media;

/**
 * Class MediaRepository
 *
 * @package Serff\Cms\Modules\Core\MediaModule\Domain\Repositories
 */
class MediaRepository extends Repository
{
    /**
     * MediaRepository constructor.
     *
     * @param Media $media
     */
    public function __construct(Media $media)
    {
        $this->model = $media;
    }

    /**
     * @param $attributes
     *
     * @return Media
     */
    public function create($attributes)
    {
        return parent::create($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->model->orderBy('id', 'desc')->get();
    }

}