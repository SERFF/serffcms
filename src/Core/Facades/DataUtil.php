<?php
namespace Serff\Cms\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Serff\Cms\Core\Common\DataHandler\DataHandler;

/**
 * Class DataUtil
 *
 * @package Serff\Cms\Facades
 */
class DataUtil extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return DataHandler::class;
    }

}