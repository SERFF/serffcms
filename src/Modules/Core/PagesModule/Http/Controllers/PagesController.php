<?php
namespace Serff\Cms\Modules\Core\PagesModule\Http\Controllers;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\PagesModule\Domain\Repositories\PagesRepository;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;

/**
 * Class PagesController
 *
 * @package Serff\Cms\Modules\Core\PagesModule\Http\Controllers
 */
class PagesController extends Controller
{
    /**
     * @var PagesRepository
     */
    protected $pagesRepository;

    /**
     * PagesController constructor.
     *
     * @param PagesRepository $pagesRepository
     */
    public function __construct(PagesRepository $pagesRepository)
    {
        $this->pagesRepository = $pagesRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function getIndex()
    {
        $data = $this->getMenuData();

        $page = $this->pagesRepository->getById(array_get($data, 'home'));
        if ($page === null) {
            $page = $this->pagesRepository->getFirstPublishedPage(app()->getLocale());
        }
        if ($page === null) {
            abort(404);
        }

        return $this->getPage($page->slug);
    }

    /**
     * @param $slug
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function getPage($slug)
    {
        $page = $this->pagesRepository->getPublishedPageBySlug($slug);
        if ($page === null) {
            abort(404);
        }

        if ($page->slug !== $slug) {
            return redirect()->route('page', ['slug' => $page->slug]);
        }
        
        return ThemeView::getView($this->getTemplateView($page), [
            'page' => $page->toArray(),
            'menu' => $this->getMenu(),
        ]);
    }

    

    /**
     * @param $page
     * @param string $default
     *
     * @return mixed|null|string
     */
    protected function getTemplateView($page, $default = 'page')
    {
        $slug = get_meta_value($page->id, 'page', 'template', '');
        $template = array_get(ThemeView::getActiveTheme()->getTemplateData($slug), 'view');
        if ($template !== '') {
            if (ThemeView::getViewExists($template)) {
                return $template;
            }
        }

        return $default;
    }
}