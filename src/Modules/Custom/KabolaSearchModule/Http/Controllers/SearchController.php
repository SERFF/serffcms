<?php
namespace Serff\Cms\Modules\Custom\KabolaSearchModule\Http\Controllers;

use Illuminate\Http\Request;
use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Serff\Cms\Modules\Custom\KabolaSearchModule\Services\SearchService;

class SearchController extends Controller
{
    /**
     * @var SearchService
     */
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function getSearch(Request $request)
    {
        return ThemeView::getView('search_results', [
            'results' => $this->searchService->search($request->get('s', null)),
            'menu'    => $this->getMenu(),
            's'       => $request->get('s', ''),
        ]);
    }

}