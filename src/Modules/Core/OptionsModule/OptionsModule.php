<?php
namespace Serff\Cms\Modules\Core\OptionsModule;

use Serff\Cms\Contracts\ModuleContract;
use Serff\Cms\Core\Modules\Module;
use Serff\Cms\Modules\Core\OptionsModule\Cache\OptionCacheManager;
use Serff\Cms\Modules\Core\OptionsModule\Domain\Repositories\OptionsRepository;

/**
 * Class OptionsModule
 *
 * @package Serff\Cms\Modules\Core\OptionsModule
 */
class OptionsModule extends Module implements ModuleContract
{
    /**
     * Options constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->path = __DIR__;
        $this->namespace = __NAMESPACE__;
    }

    /**
     *
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * @return bool
     */
    public function installed()
    {
        return true;
    }

    /**
     *
     */
    public function update()
    {
        // TODO: Implement update() method.
    }

    /**
     * @param $key
     * @param string $default
     *
     * @return mixed|null
     */
    public static function getOption($key, $default = '')
    {
    	if(env('INSTALLED', false) == false) {
    		return $default;
	    }
        $cacheManager = app(OptionCacheManager::class);

        return $cacheManager->rememberOption($key, function () use ($key, $default) {
            try {
                /**
                 * @var OptionsRepository $repository
                 */
                $repository = app()->make(OptionsRepository::class);
                $option = $repository->getOption($key);
                if ($option !== null) {
                    return $option->value;
                }

                return $default;
            } catch (\Exception $e) {
                return $default;
            }
        });
    }

    /**
     * @param $key
     *
     * @return array
     */
    public static function getOptionGroup($key)
    {
        /**
         * @var OptionsRepository $repository
         */
        $repository = app()->make(OptionsRepository::class);
        $options = $repository->getOptionGroup($key);
        $options_data = [];
        foreach ($options as $option) {
            $options_data[ $option->name ] = self::getOptionUnserialized($option->value);
        }

        return $options_data;

    }

    /**
     * @param $value
     *
     * @return mixed
     */
    protected static function getOptionUnserialized($value)
    {
        try {
            return unserialize($value);
        } catch (\Exception $e) {
            return $value;
        }

    }

    /**
     * @param $key
     * @param $value
     *
     * @return mixed|null
     */
    public static function setOption($key, $value)
    {
        /**
         * @var OptionsRepository $repository
         */
        $repository = app()->make(OptionsRepository::class);
        $option = $repository->setOption($key, $value);
        $cacheManager = app(OptionCacheManager::class);
        $cacheManager->forgetOption($key);
        if ($option !== null) {
            return $option->value;
        }

        return null;
    }
}