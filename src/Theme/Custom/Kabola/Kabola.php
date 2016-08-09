<?php
namespace Serff\Cms\Theme\Custom\Kabola;

use Serff\Cms\Modules\Core\ThemesModule\Contracts\ThemeContract;
use Serff\Cms\Modules\Core\ThemesModule\Core\Theme;

class Kabola extends Theme implements ThemeContract
{
    public function __construct()
    {
        $this->name = 'Kabola';
        $this->author = 'Van Schaik GrafiMedia';
        $this->viewPath = __DIR__ . '/views';
        $this->description = 'Thema voor Kabola, design van VSGM';
        $this->author_image_path = '/themes/kabola/images/logo_vsgm.png';
        $this->screen_shot = '/themes/kabola/images/screenshot.png';
        $this->admin_wysiwyg_css = '/themes/kabola/assets/css/global.css';
    }

    public function boot()
    {

        parent::boot();
        $this->registerTemplates();
    }

    /**
     * Register all the templates for the theme
     */
    protected function registerTemplates()
    {
        $this->registerTemplate('Home', 'home');
        $this->registerTemplate('Regular', 'regular');
        $this->registerTemplate('Contact', 'contact');
        $this->registerTemplate('Find A Dealer', 'findadealer');
        $this->registerTemplate('Product Overview', 'product_overview');
    }
}