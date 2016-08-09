<?php
namespace Serff\Cms\Core\Common\DataHandler;

use Closure;

/**
 * Class DataHandler
 *
 * @package Serff\Cms\Core\Common\DataHandler
 */
class DataHandler
{
    /**
     * @param $data
     * @param $formatters
     *
     * @return array
     */
    public function formatData($data, $formatters)
    {
        return array_map(function ($record) use ($formatters) {
            foreach ($formatters as $key => $formatter) {
                /**
                 * @var Closure $formatter
                 */
                array_set($record, $key, $formatter($record));
            }

            return $record;
        }, $data);
    }

    /**
     * @param $data
     * @param $manipulators
     *
     * @return mixed
     */
    public function manipulateData($data, $manipulators)
    {
        if (!is_array($manipulators)) {
            return $data;
        }
        foreach ($manipulators as $manipulator) {
            /**
             * @var Closure $manipulator
             */
            if (get_class($manipulator) == Closure::class) {
                $data = $manipulator($data);
            }
        }

        return $data;
    }

    /**
     * @param $hooks
     * @param null|string $type
     * @param array $record
     *
     * @return string
     */
    public function handleFormHooks($hooks, $type = null, $record = [])
    {
        $return_data = '';

        foreach ($hooks as $hook) {
            /**
             * @var Closure $hook
             */
            $result = $hook($record, $type);
            if (is_array($result)) {
                foreach ($result as $item) {
                    $return_data .= $item;
                }
            } else {
                $return_data .= $result;
            }
        }

        return $return_data;
    }

    /**
     * @param $request
     * @param $record
     * @param array $closures
     */
    public function handleSubmit($request, $record, array $closures)
    {
        foreach ($closures as $closure) {
            /**
             * @var Closure $closure
             */
            $closure($request, $record);
        }
    }

}