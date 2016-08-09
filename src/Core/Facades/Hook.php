<?php
namespace Serff\Cms\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Hook extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Serff\Cms\Core\Cms\Hook\Hook::class;
    }
}