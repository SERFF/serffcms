<?php
namespace Serff\Cms\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Serff\Cms\Core\Macros\Html\NavigationMacro;

/**
 * Class AdminServiceProvider
 *
 * @package Serff\Cms\Core\Providers
 */
class AdminServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    /**
     *
     */
    public function boot()
    {
        \Html::macro('navigation', function()
        {
            return new NavigationMacro(\Auth::user());
        });
    }
}