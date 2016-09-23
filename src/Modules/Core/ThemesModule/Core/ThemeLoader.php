<?php
namespace Serff\Cms\Modules\Core\ThemesModule\Core;

use Illuminate\Contracts\Logging\Log;
use ReflectionClass;
use Serff\Cms\Core\Cms\Loader\Loader;
use Serff\Cms\Modules\Core\ThemesModule\Contracts\ThemeContract;

/**
 * Class ThemeLoader
 *
 * @package Serff\Cms\Modules\Core\ThemesModule\Core
 */
class ThemeLoader
{
    /**
     * @var Loader
     */
    protected $loader;

    /**
     * @var string
     */
    protected $selected_theme;

    /**
     * Boot the ThemeLoader
     *
     * @param $selected_theme
     */
    public function boot($selected_theme)
    {
        $this->loader = app()->make(Loader::class);
        $this->selected_theme = $selected_theme;
        $this->registerThemes();
    }

    /**
     * Register all themes to the container
     */
    protected function registerThemes()
    {
    	if(env('INSTALLED', false) == false) {
    		return;
	    }
        $reflector = new ReflectionClass(get_class($this));
        $themePath = str_replace('Modules/Core/ThemesModule/Core/ThemeLoader.php', 'Theme/', $reflector->getFileName());
        $items = array_merge(
            $this->getCmsThemes($themePath),
            $this->getLocalThemes(app_path('Themes'))
        );
        
        foreach ($items as $item) {
            $this->registerTheme($item);
        }

        if ((app('Container')->getActiveTheme() === null) && (count($items) > 0)) {
            $theme = $this->getFirstActiveThemeFromArray($items);
            
            if($theme !== null) {
                $this->registerTheme($theme, true);
            }
        }

    }

    /**
     * @param $items
     *
     * @return null|ReflectionClass
     */
    protected function getFirstActiveThemeFromArray($items)
    {
        foreach ($items as $class) {
            /**
             * @var Theme $Theme
             * @var \ReflectionClass $class
             */
            if($class === null) {
                return null;
            }
            
            if ($class->implementsInterface(ThemeContract::class)) {
                $Theme = $class->newInstance();
                if ($Theme->getHidden() === false) {
                    return $class;
                }
            }
        }

        return null;
    }

    /**
     * @param $path
     *
     * @return array
     */
    protected function getLocalThemes($path)
    {
        if (\File::exists($path)) {
            return $this->loader->find('App\\Themes', $path);
        }

        return [];
    }

    /**
     * @param $path
     *
     * @return array
     */
    protected function getCmsThemes($path)
    {
        if (\File::exists($path)) {
            return $this->loader->find('Serff\\Cms\\Theme', $path);
        }

        return [];
    }

    /**
     * @param \ReflectionClass $class
     * @param bool $overrule
     */
    protected function registerTheme(\ReflectionClass $class, $overrule = false)
    {
        if ($class->implementsInterface(ThemeContract::class)) {
            /**
             * @var ThemeContract $Theme
             */
            $Theme = $class->newInstance();
            app('Container')->addTheme($Theme);

            /**
             * Load the theme which is selected
             */
            if (($class->getName() === $this->selected_theme)) {
                $Theme->boot();
            }

            if ($overrule) {
                $Theme->boot();
                set_option('selected_theme', get_class($Theme));
            }

        }
    }

}