<?php
namespace Serff\Cms\Modules\Core\OptionsModule\Domain\Repositories;

use Serff\Cms\Core\Repositories\Repository;
use Serff\Cms\Modules\Core\OptionsModule\Domain\Models\Option;

/**
 * Class OptionsRepository
 *
 * @package Serff\Cms\Modules\Core\OptionsModule\Domain\Repositories
 */
class OptionsRepository extends Repository
{
    /**
     * OptionsRepository constructor.
     *
     * @param Option $option
     */
    public function __construct(Option $option)
    {
        $this->model = $option;
    }

    /**
     * @param $key
     *
     * @return Option
     */
    public function getOption($key)
    {
        return $this->getFirstBy('name', $key, []);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return Option
     */
    public function setOption($key, $value)
    {
    	if(env('INSTALLED', false) == false) {
    		return null;
    	}
        $option = $this->getOption($key);
        if ($option !== null) {
            $option->update(['value' => $value]);
        } else {
            $option = $this->model->create(['name' => $key, 'value' => $value]);
        }

        return $option;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getOptionGroup($key)
    {
        return $this->model
            ->where('name', 'like', $key . '.%')
            ->get();
    }
}