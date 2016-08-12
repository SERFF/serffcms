<?php
namespace Serff\Cms\Theme\Core\Nano;

use Serff\Cms\Modules\Core\ThemesModule\Contracts\ThemeContract;
use Serff\Cms\Modules\Core\ThemesModule\Core\Theme;

class Nano extends Theme implements ThemeContract
{
    public function __construct()
    {
        $this->name = 'Nano';
        $this->author = 'SERFF';
        $this->viewPath = __DIR__ . '/views';
        $this->description = 'Standaard thema van het SERFF CMS';
        $this->hidden = env('NANO_HIDDEN', true);
        $this->viewPath = __DIR__ . '/views';
        $this->assetsPath = __DIR__ . '/assets/nano';
    }

    public function boot()
    {
        parent::boot();
    }
}