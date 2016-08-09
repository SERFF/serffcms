<?php
namespace Serff\Cms\Modules\Core\PagesModule\Http\Controllers\Admin;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Core\Facades\DataUtil;
use Serff\Cms\Core\Facades\Hook;
use Serff\Cms\Modules\Core\PagesModule\Domain\Models\Pages\Page;
use Serff\Cms\Modules\Core\PagesModule\Domain\Repositories\PagesRepository;
use Serff\Cms\Modules\Core\PagesModule\PagesModule;
use Serff\Cms\Modules\Core\PagesModule\Requests\PageRequest;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Closure;

class PagesController extends Controller
{
    /**
     * @var PagesRepository
     */
    protected $pagesRepository;

    public function __construct(PagesRepository $pagesRepository)
    {
        $this->pagesRepository = $pagesRepository;
    }

    public function getOverview()
    {
        $hook_key = 'pages.overview';
        $paginator = $this->pagesRepository->getPaginated();
        $data = collect($paginator->items())->toArray();

        $pages = DataUtil::manipulateData($data, Hook::getDataManipulators($hook_key));


        $display_fields = Hook::getDisplayFields($hook_key, PagesModule::getOverviewDisplayFields());
        $formatters = Hook::getFormatters($hook_key, PagesModule::getFormatter());
        $pages = DataUtil::formatData($pages, $formatters);

        return ThemeView::getAdminView('admin.pages.overview', [
            'paginator'      => $paginator,
            'pages'          => $pages,
            'display_fields' => $display_fields,
        ]);
    }

    public function getCreate()
    {
        $sidebar_form_hooks = Hook::getFormHook('pages.sidebar.form');
        $main_form_hooks = Hook::getFormHook('pages.form');

        return ThemeView::getAdminView('admin.pages.create', [
            'method'            => 'create',
            'wysiwyg_css'       => ThemeView::getWysiwygCssRoute(),
            'page'              => [],
            'sidebar_form_view' => DataUtil::handleFormHooks($sidebar_form_hooks, Page::class),
            'main_form_view'    => DataUtil::handleFormHooks($main_form_hooks, Page::class),
        ]);
    }

    public function getEdit($id)
    {
        $sidebar_form_hooks = Hook::getFormHook('pages.sidebar.form');
        $main_form_hooks = Hook::getFormHook('pages.form');

        $page = $this->pagesRepository->getById($id);

        return ThemeView::getAdminView('admin.pages.edit', [
            'method'            => 'edit',
            'wysiwyg_css'       => ThemeView::getWysiwygCssRoute(),
            'page'              => $page,
            'sidebar_form_view' => DataUtil::handleFormHooks($sidebar_form_hooks, Page::class, $page->load('meta')->toArray()),
            'main_form_view'    => DataUtil::handleFormHooks($main_form_hooks, Page::class, $page->load('meta')->toArray()),
        ]);
    }

    public function postStore(PageRequest $request)
    {
        $page = null;
        
        if ($request->get('method') == 'create') {
            $page = $this->pagesRepository->createFromForm($request->all());
        } elseif ($request->get('method') == 'edit') {
            $page = $this->pagesRepository->updateFromForm($request->all());
        }

        if ($page === null) {
            return redirect()->back();
        }
        $page->load('meta');

        DataUtil::handleSubmit($request, $page->toArray(), Hook::getFormSubmit('pages.form'));

        return redirect()->route('admin.pages.edit', ['id' => $page->id]);
    }

    public function getDelete($id)
    {
        $page = $this->pagesRepository->getById($id);
        if ($page !== null) {
            $page->delete();
        }

        return redirect()->route('admin.pages.overview');
    }
}