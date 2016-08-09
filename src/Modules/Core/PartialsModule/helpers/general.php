<?php

/**
 * @param $locale
 *
 * @return array
 */
function get_all_partials_for_select_by_locale($locale)
{
    $repo = app(\Serff\Cms\Modules\Core\PartialsModule\Domain\Repositories\PartialsRepository::class);
    $items = $repo->getByLocale($locale);

    return array_pluck($items, 'name', 'id');
}

/**
 * @param $id
 * @param $default
 *
 * @return \Illuminate\Database\Eloquent\Model
 */
function get_partial_by_id($id, $default)
{
    $repo = app(\Serff\Cms\Modules\Core\PartialsModule\Domain\Repositories\PartialsRepository::class);
    $partial = $repo->getById($id);
    if ($partial === null) {
        return $default;
    }

    return $partial;
}