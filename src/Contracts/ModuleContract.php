<?php
namespace Serff\Cms\Contracts;

interface ModuleContract
{
    /**
     * @return void
     */
    public function boot();

    /**
     * @return void
     */
    public function install();

    /**
     * @return bool
     */
    public function installed();

    /**
     * @return void
     */
    public function update();
}