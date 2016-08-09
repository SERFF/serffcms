<?php
namespace Serff\Cms\Contracts;

interface ModuleContract
{

    public function boot();

    public function install();

    /**
     * @return bool
     */
    public function installed();
    
    public function update();
}