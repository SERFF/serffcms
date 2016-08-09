<?php
namespace Serff\Cms\Modules\Core\PagesModule\Domain\Repositories;

use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Core\PagesModule\Domain\Models\Pages\Page;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Venturecraft\Revisionable\Revision;

/**
 * Class PagesRepository
 *
 * @package Serff\Cms\Modules\Core\PagesModule\Domain\Repositories
 */
class PagesRepository extends Repository
{
    /**
     * PagesRepository constructor.
     *
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->model = $page;
    }

    /**
     * @return mixed
     */
    public function getPaginated()
    {
        return $this->model->orderBy('id', 'DESC')->paginate(20);
    }

    /**
     * @param $data
     *
     * @return static
     */
    public function createFromForm($data)
    {
        $author = \Auth::user()->toArray();

        $data['author_id'] = array_get($author, 'id', 0);
        if (array_get($data, 'status', 'DRAFT') === 'PUBLISHED') {
            $data['published_at'] = Carbon::now();
        }
        if (array_get($data, 'locale', '') == '') {
            $data['locale'] = app()->getLocale();
        }

        $data['slug'] = Str::slug(array_get($data, 'title'));

        return $this->model->create($data);
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateFromForm($data)
    {
        $page_id = array_get($data, 'page_id', 0);
        $page = $this->getById($page_id);

        if ($page === null) {
            return $page;
        }
        if ((array_get($data, 'status', 'DRAFT') === 'PUBLISHED')
            && ($page->status == Page::STATUS_DRAFT)
        ) {
            $data['published_at'] = Carbon::now();
        }

        if (array_get($data, 'locale', '') == '') {
            $data['locale'] = app()->getLocale();
        }

        $page->update($data);

        return $page;
    }

    /**
     * @param $slug
     * @param array $with
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getPublishedPageBySlug($slug, $with = [])
    {
        $page = $this->model
            ->whereSlug($slug)
            ->whereStatus(Page::STATUS_PUBLISHED)
            ->with($with)
            ->first();

        if ($page === null) {
            $revision = Revision::select('revisionable_id')
                ->where('key', 'slug')
                ->where('revisionable_type', Page::class)
                ->where('old_value', $slug)
                ->join('pages', 'revisionable_id', '=', 'pages.id')
                ->where('pages.status', Page::STATUS_PUBLISHED)
                ->first();

            $page = $this->getById(array_get($revision, 'revisionable_id'));
        }

        return $page;
    }

    /**
     * @return Collection
     */
    public function getPublishedPages($locale)
    {
        return $this->model
            ->whereStatus(Page::STATUS_PUBLISHED)
            ->whereLocale($locale)
            ->get();
    }

    /**
     * @param $locale
     *
     * @return mixed
     */
    public function getFirstPublishedPage($locale)
    {
        return $this->model
            ->whereStatus(Page::STATUS_PUBLISHED)
            ->whereLocale($locale)
            ->first();
    }


}