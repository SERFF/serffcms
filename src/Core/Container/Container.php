<?php
namespace Serff\Cms\Core\Container;

use Serff\Cms\Modules\Core\ThemesModule\Core\Theme;

/**
 * Class Container
 *
 * @package Serff\Cms\Core\Container
 */
class Container
{
    /**
     * @var array
     */
    protected $available_themes = [];

    /**
     * @var Theme
     */
    protected $active_theme;

    /**
     * @var array
     */
    protected $middlewares = [];

    /**
     * @param Theme $theme
     */
    public function addTheme($theme)
    {
        $this->available_themes[] = $theme;
    }

    /**
     * @return array
     */
    public function getThemes()
    {
        return $this->available_themes;
    }

    /**
     * @param $themes
     */
    public function setThemes($themes)
    {
        $this->available_themes = $themes;
    }

    /**
     * @param Theme $theme
     */
    public function setActiveTheme(Theme $theme)
    {
        $this->active_theme = $theme;
    }

    /**
     * @return Theme
     */
    public function getActiveTheme()
    {
        return $this->active_theme;
    }

    /**
     * @param $middleware
     */
    public function addMiddleware($middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return array
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }

}