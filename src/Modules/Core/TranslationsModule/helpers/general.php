<?php


/**
 * @param $id
 * @param array $parameters
 * @param bool $editable
 * @param bool $escape_params
 * @param string $domain
 * @param null $locale
 *
 * @return null|string|\Symfony\Component\Translation\TranslatorInterface
 */
function translate($id, $parameters = [], $editable = true, $escape_params = true, $domain = 'messages', $locale = null)
{
    $translationService = app()->make(\Serff\Cms\Modules\Core\TranslationsModule\Services\TranslationService::class);

    $escaped_parameters = [];
    foreach ($parameters as $key => $parameter) {
        $escaped_parameters[ $key ] = e($parameter);
    }

    if ($escape_params === false) {
        $escaped_parameters = $parameters;
    }

    $translated_string = $translationService->translate($id, $locale, $escaped_parameters);

    if ($translated_string === null) {
        return trans($id, $escaped_parameters, $domain, $locale);
    }

    if ($editable === false) {
        return $translated_string;
    }

    $User = Auth::user();

    if ($User === null) {
        return $translated_string;
    }
    if ((userCanTranslate($User) === true) && (translateEnabled())) {
        $wrapper_div = "<trans class='translation-element' id='{$id}'>{$translated_string}</trans>";

        return $wrapper_div;
    } else {
        return $translated_string;
    }
}


/**
 * @param null $User
 *
 * @return bool
 */
function userCanTranslate($User = null)
{
    if ($User === null) {

        $User = \Auth::user();
    }

    if ($User !== null) {

        return true;
    }

    return false;
}

/**
 * @return bool
 */
function translateEnabled()
{
    return \Illuminate\Support\Facades\Request::session()->get('translationEnabled', false);
}

/**
 * @param $name
 * @param array $parameters
 * @param null $locale
 *
 * @return string
 */
function route_with_locale($name, $parameters = [], $locale = null)
{
    $prefix = '';
    if ($locale == null) {
        $locale = app()->getLocale();
    }
    if (get_option('primary_locale') !== $locale) {
        $prefix = app()->getLocale() . '.';
    }

    return route($prefix . $name, $parameters);
}


/**
 * @return array
 */
function get_countries_and_locales()
{
    $repo = app()->make(\Serff\Cms\Modules\Core\TranslationsModule\Domain\Repositories\TranslationsRepository::class);

    return $repo->getCountriesAndLocales(true);
}

/**
 * @return mixed|null
 */
function get_primary_locale()
{
    return get_option('primary_locale', 'nl');
}
