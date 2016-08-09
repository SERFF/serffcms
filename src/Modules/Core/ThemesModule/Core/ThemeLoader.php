<?php
namespace Serff\Cms\Modules\Core\ThemesModule\Core;

use ReflectionClass;
use Serff\Cms\Core\Cms\Loader\Loader;
use Serff\Cms\Modules\Core\ThemesModule\Contracts\ThemeContract;

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
        $reflector = new ReflectionClass(get_class($this));
        $themePath = str_replace('Modules/Core/ThemesModule/Core/ThemeLoader.php', 'Theme/', $reflector->getFileName());
        $items = $this->loader->find('Serff\\Cms\\Theme', $themePath);
        foreach ($items as $item) {
            $this->registerTheme($item);
        }
    }

    /**
     * @param \ReflectionClass $class
     */
    protected function registerTheme(\ReflectionClass $class)
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
            if ($class->getName() === $this->selected_theme) {
                $Theme->boot();
            }

        }
    }

}