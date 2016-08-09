<?php
namespace Serff\Cms\Modules\Core\PartialsModule\Http\Controllers\Admin;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\PartialsModule\Domain\Models\Partial;
use Serff\Cms\Modules\Core\PartialsModule\Domain\Repositories\PartialsRepository;
use Serff\Cms\Modules\Core\PartialsModule\Requests\PartialRequest;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use DataUtil;
use Hook;

/**
 * Class PartialsController
 *
 * @package Serff\Cms\Modules\Core\PartialsModule\Http\Controllers\Admin
 */
class PartialsController extends Controller
{
    /**
     * @var PartialsRepository
     */
    protected $partialsRepository;

    /**
     * PartialsController constructor.
     *
     * @param PartialsRepository $partialsRepository
     */
    public function __construct(PartialsRepository $partialsRepository)
    {
        $this->partialsRepository = $partialsRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getOverview()
    {
        $partials = $this->partialsRepository->all();

        return ThemeView::getAdminView('admin.partials.overview', [
            'partials' => $partials,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getCreate()
    {
        $sidebar_form_hooks = Hook::getFormHook('partials.sidebar.form');

        return ThemeView::getAdminView('admin.partials.create', [
            'partial'           => [],
            'wysiwyg_css'       => ThemeView::getWysiwygCssRoute(),
            'sidebar_form_view' => DataUtil::handleFormHooks($sidebar_form_hooks, Partial::class),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getEdit($id)
    {
        $sidebar_form_hooks = Hook::getFormHook('partials.sidebar.form');

        $partial = $this->partialsRepository->getById($id);

        return ThemeView::getAdminView('admin.partials.edit ', [
            'partial'           => $partial->toArray(),
            'wysiwyg_css'       => ThemeView::getWysiwygCssRoute(),
            'sidebar_form_view' => DataUtil::handleFormHooks($sidebar_form_hooks, Partial::class),
        ]);
    }

    /**
     * @param PartialRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStore(PartialRequest $request)
    {
        $data = [
            'name'      => $request->get('name'),
            'slug'      => str_slug($request->get('name')),
            'content'   => $request->get('content'),
            'author_id' => \Auth::user()->id,
            'locale'    => $request->get('locale'),
        ];

        if ($request->get('partial_id', null) !== null) {
            $id = $request->get('partial_id');
            $this->partialsRepository->update($id, $data);
            $partial = $this->partialsRepository->getById($id);
        } else {
            $partial = $this->partialsRepository->create($data);
        }

        return redirect()->route('admin.partials.edit', ['id' => array_get($partial, 'id')]);

    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $partial = $this->partialsRepository->getById($id);
        if ($partial !== null) {
            $partial->delete();
        }

        return redirect()->back();
    }

}