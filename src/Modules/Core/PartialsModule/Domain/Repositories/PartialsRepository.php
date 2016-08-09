<?php
namespace Serff\Cms\Modules\Core\PartialsModule\Domain\Repositories;

use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Core\PartialsModule\Domain\Models\Partial;

/**
 * Class PartialsRepository
 *
 * @package Serff\Cms\Modules\Core\PartialsModule\Domain\Repositories
 */
class PartialsRepository extends Repository
{
    /**
     * PartialsRepository constructor.
     *
     * @param Partial $partial
     */
    public function __construct(Partial $partial)
    {
        $this->model = $partial;
    }

    /**
     * @param null $locale
     *
     * @return mixed
     */
    public function getByLocale($locale = null)
    {
        if ($locale === null) {
            $locale = app()->getLocale();
        }

        return $this->model
            ->where('locale', $locale)
            ->get();
    }

    public function getBySlugAndLocale($slug, $locale = null)
    {
        if ($locale === null) {
            $locale = app()->getLocale();
        }
        
        return $this->model->whereSlug($slug)
            ->whereLocale($locale)
            ->first();
    }
}