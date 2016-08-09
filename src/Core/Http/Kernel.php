<?php
namespace Serff\Cms\Core\Http;

/**
 * Class Kernel
 *
 * @package Serff\Cms\Core\Http
 */
class Kernel extends \App\Http\Kernel
{
    /**
     * @var bool
     */
    protected $prefixed = false;

    /**
     * @param $prefixed
     */
    public function setPrefixed($prefixed)
    {
        $this->prefixed = $prefixed;
    }

    /**
     * @return bool
     */
    public function prefixed()
    {
        return $this->prefixed;
    }
}