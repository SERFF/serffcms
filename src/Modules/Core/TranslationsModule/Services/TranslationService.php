<?php
namespace Serff\Cms\Modules\Core\TranslationsModule\Services;

use Serff\Cms\Modules\Core\TranslationsModule\Domain\Models\Group;
use Serff\Cms\Modules\Core\TranslationsModule\Domain\Models\Translation;
use Serff\Cms\Modules\Core\TranslationsModule\Domain\Repositories\TranslationsRepository;
use Storage;
use Symfony\Component\Finder\Finder;

/**
 * Class TranslationService
 *
 * @package Serff\Cms\Modules\Core\TranslationsModule\Services
 */
class TranslationService
{
    /**
     * @var TranslationsRepository
     */
    protected $repository;

    /**
     * @var array
     */
    protected $locales = ['nl', 'en'];

    /**
     * TranslationService constructor.
     *
     * @param TranslationsRepository $repository
     */
    public function __construct(TranslationsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $key
     * @param string|null $locale
     * @param array $parameters
     *
     * @return string|null
     */
    public function translate($key, $locale = null, $parameters = [])
    {
        if ($locale === null) {
            $locale = app()->getLocale();
        }

        $translation = $this->repository->getByKeyAndLocale($key, $locale);
        if ($translation === null) {
            return null;
        }

        return $this->replace_values($translation, $parameters);
    }

    /**
     * @param string $text
     * @param array $parameters
     *
     * @return string
     */
    protected function replace_values($text, $parameters)
    {
        foreach ($parameters as $key => $value) {
            $text = str_replace(':' . $key, $value, $text);
        }

        return $text;
    }

    /**
     * @param null $folder_locale
     * @param null $destination_locale
     */
    public function updateRecordsWithLangFiles($folder_locale = null, $destination_locale = null)
    {
        if (is_null($folder_locale)) {
            $files = \File::allFiles(resource_path('lang'));
        } else {
            if (!\File::exists(resource_path('lang/' . $folder_locale))) {
                return;
            }
            $files = \File::allFiles(resource_path('lang/' . $folder_locale));
        }

        foreach ($files as $file) {

            if (ends_with($file, '.php')) {
                $translations = [];
                $name = '';
                $locale = '';
                $lang_path = base_path('resources/lang') . '/' . $file;
                // @todo: find issue with include on some files
                try {
                    $translations = include $lang_path;
                    $name = substr($file, 3, strlen($file) - 7);
                    $locale = substr($file, 0, 2);
                } catch (\Exception $e) {

                }
                $locale = (isset($destination_locale) ? $destination_locale : $locale);

                $this->updateGroup($name, $locale, $translations);
            }
        }
    }

    /**
     *
     */
    public function updateRecordsWithMissingKeys()
    {
        $missing_data = $this->findTranslations();
        foreach ($this->locales as $locale) {
            foreach ($missing_data as $key => $items) {
                $this->updateGroup($key, $locale, $items);
            }
            $this->updateRecordsWithLangFiles('nl', $locale);
        }
    }

    /**
     * @param $key
     * @param $value
     * @param $locale_code
     *
     * @return null|Translation
     */
    public function createTranslation($key, $value, $locale_code)
    {
        if (count(explode('.', $key)) < 2) {
            return null;
        }
        list($group, $item) = explode('.', $key, 2);
        /**
         * @var Group
         */
        $Group = $this->repository->getGroup($group);
        if ($Group === null) {
            $Group = $this->repository->createGroup($group);
        }

        if ($this->repository->translationExists($key, $locale_code)) {
            return null;
        }

        $Translation = $this->repository->createTranslation($key, $value, $locale_code);
        if ($Translation !== null) {
            $Group->translations()->save($Translation);
        }

        return $Translation;
    }

    /**
     * @param $name
     * @param $locale
     * @param $translations
     */
    public function updateGroup($name, $locale, $translations)
    {
        if ((count($translations) === 0) || (trim($name) === '')) {
            return;
        }

        /**
         * @var Group
         */
        $Group = $this->repository->getGroup($name);
        if ($Group === null) {
            $Group = $this->repository->createGroup($name);
        }

        foreach ($translations as $key => $value) {
            $translation_key = $name . '.' . $key;

            if ($this->repository->translationExists($translation_key, $locale)) {
                continue;
            }

            $Translation = $this->repository->createTranslation($translation_key, $value, $locale);
            if ($Translation !== null) {
                $Group->translations()->save($Translation);
            }
        }
    }

    /**
     * @param null $path
     *
     * @return array
     */
    public function findTranslations($path = null)
    {
        $path = $path ?: base_path();
        $keys = [];
        $functions = ['translate'];
        $pattern =                              // See http://regexr.com/392hu
            "(" . implode('|', $functions) . ")" .  // Must start with one of the functions
            "\(" .                               // Match opening parenthese
            "[\'\"]" .                           // Match " or '
            "(" .                                // Start a new group to match:
            "[a-zA-Z0-9_-]+\/" .               // Must start with group
            "[a-zA-Z0-9_-]+" .               // Must start with group
            "([.][^\1)]+)+" .                // Be followed by one or more items/keys
            ")" .                                // Close group
            "[\'\"]" .                           // Closing quote
            "[\),]";                            // Close parentheses or new parameter
        $pattern2 =                              // See http://regexr.com/392hu
            "(" . implode('|', $functions) . ")" .  // Must start with one of the functions
            "\(" .                               // Match opening parenthese
            "[\'\"]" .                           // Match " or '
            "(" .                                // Start a new group to match:
            "[a-zA-Z0-9_-]+" .               // Must start with group
            "([.][^\1)]+)+" .                // Be followed by one or more items/keys
            ")" .                                // Close group
            "[\'\"]" .                           // Closing quote
            "[\),]";                            // Close parentheses or new parameter

        // Find all PHP files in the app folder, except for storage
        $finder = new Finder();
        $finder->in($path)->exclude(['storage', 'vendor', 'node_modules', 'images', 'bootstrap', 'tests', 'spec', 'public'])->name('*.php')->files();
        /** @var \Symfony\Component\Finder\SplFileInfo $file */
        foreach ($finder as $file) {
            // Search the current file for the pattern
            if (preg_match_all("/$pattern/siU", $file->getContents(), $matches)) {
                // Get all matches
                foreach ($matches[2] as $key) {
                    $keys[] = $key;
                }
            }

            if (preg_match_all("/$pattern2/siU", $file->getContents(), $matches)) {
                // Get all matches
                foreach ($matches[2] as $key) {
                    $keys[] = $key;
                }
            }
        }
        // Remove duplicates
        $keys = array_unique($keys);
        $result_data = [];
        // Add the translations to the database, if not existing.
        foreach ($keys as $key) {
            // Split the group and item
            list($group, $item) = explode('.', $key, 2);
            $result_data[ $group ][ $item ] = $item;
        }

        // Return the number of found translations
        return $result_data;
    }
}