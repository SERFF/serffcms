<?php
namespace Serff\Cms\Modules\Core\TranslationsModule\Http\Controllers\Admin;

use Serff\Cms\Core\Controllers\Controller;
use Serff\Cms\Modules\Core\OptionsModule\OptionsModule;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;
use Serff\Cms\Modules\Core\TranslationsModule\Domain\Repositories\TranslationsRepository;
use Illuminate\Http\Request;

/**
 * Class TranslationController
 *
 * @package Serff\Cms\Modules\Core\TranslationsModule\Http\Controllers\Admin
 */
class TranslationController extends Controller
{
    /**
     * @var TranslationsRepository
     */
    protected $translationRepository;

    /**
     * TranslationController constructor.
     *
     * @param TranslationsRepository $translationRepository
     */
    public function __construct(TranslationsRepository $translationRepository)
    {
        $this->translationRepository = $translationRepository;
    }

    /**
     * @param Request $request
     */
    public function ajaxUpdate(Request $request)
    {
        $key = $request->input('key');
        $value = $request->input('value');
        $locale = $request->input('locale');

        $this->translationRepository->updateTranslation($key, $value, $locale);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleTranslate(Request $request)
    {
        $value = $request->session()->get('translationEnabled', false);
        $toggle = false;
        if ($value === false) {
            $toggle = true;
        }
        $request->session()->put('translationEnabled', $toggle);

        return redirect()->back();
    }

    /**
     * @param Request $request
     *
     * @return null
     */
    public function getValue(Request $request)
    {
        $key = $request->get('key');
        $locale = $request->input('locale');

        return $this->translationRepository->getByKeyAndLocale($key, $locale);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getSettings()
    {
        $locales = $this->translationRepository->getCountriesAndLocales();

        $site_locales = OptionsModule::getOption('site_locales', []);
        if (!is_array($site_locales)) {
            $site_locales = unserialize($site_locales);
        }

        return ThemeView::getAdminView('admin.translations.settings', [
            'locales'         => $locales,
            'selected_locale' => OptionsModule::getOption('primary_locale', app()->getLocale()),
            'site_locales'    => $site_locales,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getOverview(Request $request)
    {
        $locales = $this->translationRepository->getCountriesAndLocales(true);
        $translations = $this->translationRepository->getPaginatedByQueryAndLocalesAndGroup($request->get('query'), $request->get('locale'), $request->get('group'));
        $translations->setPath('/' . $request->path() . '?' . http_build_query($request->all()));

        return ThemeView::getAdminView('admin.translations.overview', [
            'query'        => [
                'query'   => $request->get('query'),
                'locales' => $request->get('locale', []),
                'group'   => $request->get('group', []),
            ],
            'translations' => $translations,
            'groups'       => $this->translationRepository->getGroups(),
            'locales'      => $locales,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSaveSettings(Request $request)
    {
        $this->validate($request, [
            'locale'          => 'required',
            'selected_locale' => 'required',
        ], [], [
            'locale'          => 'Actieve landen',
            'selected_locale' => 'Standaard taal',
        ]);

        $used_locales = $request->get('locale');
        $selected_locale = $request->get('selected_locale');

        OptionsModule::setOption('site_locales', serialize($used_locales));
        OptionsModule::setOption('primary_locale', $selected_locale);

        return redirect()->route('admin.translation.settings');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getEdit($id)
    {
        $translation = $this->translationRepository->getById($id);
        if ($translation === null) {
            abort(500);
        }

        return ThemeView::getAdminView('admin.translations.edit', [
            'translation' => $translation,
        ]);
    }

    /**
     * @param Request $request
     */
    public function postStore(Request $request)
    {
        $translation = $this->translationRepository->getById($request->get('id'));
        if ($translation === null) {
            abort(500);
        }

        $translation->value = $request->get('value');
        $translation->save();
        
        return redirect()->route('admin.translations.edit', ['id' => $request->get('id')]);
    }
}