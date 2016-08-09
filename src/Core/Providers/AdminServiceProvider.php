<?php
namespace Serff\Cms\Core\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Serff\Cms\Core\Macros\Html\NavigationMacro;

class AdminServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }
    
    public function boot()
    {
        \Html::macro('navigation', function()
        {
            return new NavigationMacro(\Auth::user());
        });
    }
}