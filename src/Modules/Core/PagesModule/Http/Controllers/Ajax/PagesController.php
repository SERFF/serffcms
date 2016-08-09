<?php
namespace Serff\Cms\Modules\Core\PagesModule\Http\Controllers\Ajax;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\PagesModule\Domain\Repositories\PagesRepository;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * @var PagesRepository
     */
    protected $repository;

    public function __construct(PagesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getContent(Request $request)
    {
        $page_id = (int)$request->get('key');
        $page = $this->repository->getById($page_id);
        if ($page === null) {
            abort(500);
        }

        return parse_page_content($page->content, $page->id, false);
    }

    public function updateContent(Request $request)
    {
        $page_id = (int)$request->get('key');
        $value = $request->get('value');

        $page = $this->repository->getById($page_id);
        if ($page === null) {
            abort(404);
        }
        if ($page->update(['content' => $value]) === false) {
            abort(500);
        }

        return $page->content;
    }

}