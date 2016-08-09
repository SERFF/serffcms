<?php
namespace Serff\Cms\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Serff\Cms\Core\Common\Environment\Environment;

/**
 * Class Util
 *
 * @package Serff\Cms\Facades
 */
class Env extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Environment::class;
    }

}