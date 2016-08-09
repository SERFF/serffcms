<?php
namespace Serff\Cms\Modules\Core\TranslationsModule\Domain\Repositories;

use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Core\OptionsModule\OptionsModule;
use Serff\Cms\Modules\Core\TranslationsModule\Cache\TranslationCacheManager;
use Serff\Cms\Modules\Core\TranslationsModule\Domain\Models\Group;
use Serff\Cms\Modules\Core\TranslationsModule\Domain\Models\Translation;
use DB;

/**
 * Class TranslationsRepository
 *
 * @package Serff\Cms\Modules\Core\TranslationsModule\Domain\Repositories
 */
class TranslationsRepository extends Repository
{
    /**
     * @var Translation
     */
    protected $translation;
    /**
     * @var Group
     */
    protected $group;
    /**
     * @var MediaCacheManager
     */
    protected $cacheManager;

    /**
     * @var array
     */
    protected $countries_and_locales = [
        'nl' => [
            'label' => 'Nederlands',
        ],
        'en' => [
            'label' => 'English',
        ],
        'de' => [
            'label' => 'Deutsch',
        ],
    ];

    /**
     * TranslationsRepository constructor.
     *
     * @param Translation $translation
     * @param Group $group
     * @param TranslationCacheManager $cacheManager
     */
    public function __construct(Translation $translation, Group $group, TranslationCacheManager $cacheManager)
    {
        $this->model = $translation;
        $this->translation = $translation;
        $this->group = $group;
        $this->cacheManager = $cacheManager;
    }

    /**
     * @param $key
     * @param $locale
     *
     * @return null
     */
    public function getByKeyAndLocale($key, $locale)
    {
        $Translation = $this->cacheManager->rememberTranslation($key, $locale, function () use ($key, $locale) {
            return $this->translation->where('key', '=', $key)
                ->where('locale', '=', $locale)
                ->first();
        });


        if ($Translation === null) {
            return null;
        }

        return $Translation->value;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getGroup($name)
    {
        return $this->group->where('name', '=', $name)->first();
    }

    /**
     * @param $name
     *
     * @return static
     */
    public function createGroup($name)
    {
        return $this->group->create(['name' => $name]);
    }

    /**
     * @param $key
     * @param $locale
     *
     * @return bool
     */
    public function translationExists($key, $locale)
    {
        $Translation = $this->translation->where('key', '=', $key)
            ->where('locale', '=', $locale)
            ->first();
        if ($Translation === null) {
            return false;
        }

        return true;
    }

    /**
     * @param $translation_key
     * @param $value
     * @param $locale
     *
     * @return static
     */
    public function createTranslation($translation_key, $value, $locale)
    {
        //@todo: insert array values
        if (is_array($value)) {
            return null;
        }
        $Translation = $this->translation->create([
            'key'    => $translation_key,
            'value'  => $value,
            'locale' => $locale,
        ]);

        return $Translation;
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->group->orderBy('name')->lists('name', 'id')->all();
    }

    /**
     * @param string $key
     * @param string $value
     * @param string $locale
     */
    public function updateTranslation($key, $value, $locale)
    {
        $Translation = $this->translation->where('key', '=', $key)
            ->where('locale', '=', $locale)
            ->first();
        
        /**
         * @var Translation
         */
        if ($Translation !== null) {
            $Translation->update([
                'value' => $value,
            ]);
        }
    }

    /**
     * @param int $id
     *
     * @return Translation
     */
    public function findOrFail($id)
    {
        return $this->translation->findOrFail($id);
    }

    /**
     * @param array $locale_codes
     * @param array $groups
     *
     * @return mixed
     */
    public function getExportData($locale_codes, $groups)
    {
        $translations = $this->translation
            ->leftJoin('s_system.translation_groups as groups', 'groups.id', '=', 'group_id')
            ->select(['name', 'key', 'value', 'locale']);

        if (count($locale_codes) > 0) {
            $translations->whereIn('locale', $locale_codes);
        }
        if (count($groups) > 0) {
            $translations->whereIn('group_id', $groups);
        }

        return $translations->get();
    }

    /**
     * @param array $translations
     */
    public function importTranslation($translations)
    {
        foreach ($translations as $translation) {
            $Group = $this->getGroup($translation->name);
            if ($Group === null) {
                $Group = $this->createGroup($translation->name);
            }
            $Model = $this->translation->where('key', '=', $translation->key)
                ->where('locale', '=', $translation->locale_code)
                ->first();

            if ($Model === null) {
                $Model = $this->translation->create([
                    'key'    => $translation->key,
                    'value'  => $translation->value,
                    'locale' => $translation->locale_code,
                ]);
                $Group->translations()->save($Model);
            } else {
                $Model->update([
                    'value' => $translation->value,
                ]);
                $Model->save();
            }
        }
    }

    /**
     * @param bool $active
     *
     * @return array
     */
    public function getCountriesAndLocales($active = false)
    {
        if ($active) {
            $active_locales = unserialize(get_option('site_locales', []));
            $items = [];
            foreach ($this->countries_and_locales as $key => $value) {
                if (in_array($key, $active_locales)) {
                    $items[ $key ] = $value;
                }
            }

            return $items;
        }

        return $this->countries_and_locales;
    }

    public function getCountriesAndLocalesForSelect($active = false)
    {
        $active_locales = unserialize(get_option('site_locales', []));
        $items = [];
        foreach ($this->countries_and_locales as $key => $value) {
            if ($active) {
                if (in_array($key, $active_locales)) {
                    $items[ $key ] = array_get($value, 'label');
                }
            } else {
                $items[ $key ] = array_get($value, 'label');
            }
        }

        return $items;
    }

    /**
     * @return array
     */
    public function getLocales()
    {
        $locales = [];
        foreach ($this->countries_and_locales as $key => $value) {
            $locales[] = $key;
        }

        return $locales;
    }

    /**
     * @param $query
     * @param $locales
     * @param $group
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedByQueryAndLocalesAndGroup($query, $locales, $group)
    {
        $item = DB::table($this->translation->getTable());

        if (!is_null($query)) {

            $item->where(function ($builder) use ($query) {
                $builder->where('value', 'like', '%' . $query . '%');
                $builder->orWhere('key', 'like', '%' . $query . '%');
            });
        }
        if (count($locales) > 0) {
            $item->whereIn('locale', $locales);
        }
        if (count($group) > 0) {
            $item->whereIn('group_id', $group);
        }

        return $item->paginate(30);
    }
}