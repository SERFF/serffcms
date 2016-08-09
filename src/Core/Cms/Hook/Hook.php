<?php
namespace Serff\Cms\Core\Cms\Hook;

use Closure;

/**
 * Class Hook
 *
 * @package Serff\Cms\Core\Cms\Hook
 */
class Hook
{
    /**
     * @var array
     */
    protected $formHooks = [];
    /**
     * @var array
     */
    protected $formValidationRules = [];
    /**
     * @var array
     */
    protected $formSubmit = [];
    /**
     * @var array
     */
    protected $formValidationAttributes;
    /**
     * @var array
     */
    protected $displayFields = [];
    /**
     * @var array
     */
    protected $formatters = [];
    /**
     * @var array
     */
    protected $data_manipulator = [];

    /**
     * @param string $key
     * @param Closure $function
     */
    public function registerFormHook($key, $function)
    {
        $this->formHooks[ $key ][] = $function;
    }

    /**
     * @param string $key
     * @param array $rules
     * @param array $attributes
     */
    public function registerFormValidation($key, $rules, $attributes = [])
    {
        $this->formValidationRules[ $key ][] = $rules;
        $this->formValidationAttributes[ $key ][] = $attributes;
    }

    /**
     * @param string $key
     * @param Closure $closure
     */
    public function registerFormSubmit($key, Closure $closure)
    {
        $this->formSubmit[ $key ][] = $closure;
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public function getFormHook($key)
    {
        return array_get($this->formHooks, $key, []);
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public function getFormValidation($key)
    {
        return array_get($this->formValidationRules, $key, []);
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public function getFormValidationAttributes($key)
    {
        return array_get($this->formValidationAttributes, $key, []);
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public function getFormSubmit($key)
    {
        return array_get($this->formSubmit, $key, []);
    }

    /**
     * @param $key
     * @param $formatters
     */
    public function addFormatters($key, $formatters)
    {
        $this->formatters[ $key ] = array_merge(array_get($this->formatters, $key, []), $formatters);
    }

    /**
     * @param $key
     * @param $fields
     */
    public function addDisplayFields($key, $fields)
    {
        $this->displayFields[ $key ] = array_merge(array_get($this->displayFields, $key, []), $fields);
    }

    /**
     * @param $key
     * @param $function
     */
    public function addDataManipulation($key, $function)
    {
        $this->data_manipulator[ $key ][] = $function;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getDataManipulators($key)
    {
        return array_get($this->data_manipulator, $key );
    }

    /**
     * @param $key
     * @param $fields
     *
     * @return array
     */
    public function getDisplayFields($key, $fields = [])
    {
        $this->addDisplayFields($key, $fields);

        return array_sort($this->displayFields[ $key ], function ($item) {
            return array_get($item, 'order', 1);
        });
    }

    /**
     * @param $key
     * @param array $formatters
     *
     * @return array
     */
    public function getFormatters($key, $formatters = [])
    {
        $this->addFormatters($key, $formatters);

        return $this->formatters[ $key ];
    }


}