<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Services;

/**
 * Class FilterAdapter
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Services
 */
class FilterAdapter
{

    /**
     * @param array $product_options
     *
     * @return array
     */
    public static function transformProductOptions(array $product_options)
    {
        if ((count($product_options) == 0) || (count($product_options) >= 2)) {
            return ['CV', 'BOILER', 'COMBI'];
        }

        if (array_get($product_options, 0) == 'thermostat') {
            return ['CV', 'COMBI'];
        }

        if (array_get($product_options, 0) == 'kettel') {
            return ['BOILER', 'COMBI'];
        }

        return [];
    }

    /**
     * @param array $appliance
     *
     * @return array
     */
    public static function transformAppliciance(array $appliance)
    {
        if ((count($appliance) == 0)) {
            return ['CV', 'BOILER', 'COMBI'];
        }

        if ((count($appliance) == 2)) {
            return ['COMBI'];
        }

        $types = ['COMBI'];

        foreach ($appliance as $item) {
            if ($item == 'a') {
                $types[] = 'CV';
            } elseif ($item == 'b') {
                $types[] = 'BOILER';
            }
        }

        return $types;
    }

    /**
     * @param $water_cb
     *
     * @return array
     */
    public static function transformWaterCb($water_cb)
    {
        if ((count($water_cb) == 0) || (count($water_cb) >= 4)) {
            return ['min' => 0, 'max' => 999];
        }
        $min = 999;
        $max = 0;

        foreach ($water_cb as $item) {
            switch ($item) {
                case 'a':
                    $min = array_get(self::getMinMax($min, $max, 8, 10), 'min');
                    $max = array_get(self::getMinMax($min, $max, 8, 10), 'max');
                    break;
                case 'b':
                    $min = array_get(self::getMinMax($min, $max, 11, 15), 'min');
                    $max = array_get(self::getMinMax($min, $max, 11, 15), 'max');
                    break;
                case 'c':
                    $min = array_get(self::getMinMax($min, $max, 16, 20), 'min');
                    $max = array_get(self::getMinMax($min, $max, 16, 20), 'max');
                    break;
                case 'd':
                    $min = array_get(self::getMinMax($min, $max, 20, 9999), 'min');
                    $max = array_get(self::getMinMax($min, $max, 20, 9999), 'max');
                    break;
            }
        }

        return [
            'min' => $min,
            'max' => $max,
        ];
    }

    /**
     * @param $min
     * @param $max
     * @param $min_val
     * @param $max_val
     *
     * @return array
     */
    public static function getMinMax($min, $max, $min_val, $max_val)
    {
        if ($min > $min_val) {
            $min = $min_val;
        }
        if ($max < $max_val) {
            $max = $max_val;
        }

        return [
            'min' => $min,
            'max' => $max,
        ];
    }

    /**
     * @param $capacity
     *
     * @return array
     */
    public static function transformCapacity($capacity)
    {
        if ((count($capacity) == 0) || (count($capacity) >= 4)) {
            return ['min' => 0, 'max' => 999];
        }
        $min = 999;
        $max = 0;

        foreach ($capacity as $item) {
            switch ($item) {
                case 'a':
                    $min = array_get(self::getMinMax($min, $max, 4, 10), 'min');
                    $max = array_get(self::getMinMax($min, $max, 4, 10), 'max');
                    break;
                case 'b':
                    $min = array_get(self::getMinMax($min, $max, 11, 19), 'min');
                    $max = array_get(self::getMinMax($min, $max, 11, 19), 'max');
                    break;
                case 'c':
                    $min = array_get(self::getMinMax($min, $max, 20, 29), 'min');
                    $max = array_get(self::getMinMax($min, $max, 20, 29), 'max');
                    break;
                case 'd':
                    $min = array_get(self::getMinMax($min, $max, 30, 116), 'min');
                    $max = array_get(self::getMinMax($min, $max, 30, 116), 'max');
                    break;
            }
        }

        return [
            'min' => $min,
            'max' => $max,
        ];
    }

    /**
     * @param $efficiency
     *
     * @return array
     */
    public static function transformEfficiency($efficiency)
    {
        if ((count($efficiency) == 0) || (count($efficiency) >= 2)) {
            return [90, 94];
        }
        $items = [];

        foreach ($efficiency as $item) {
            switch ($item) {
                case 'a':
                    $items[] = 90;
                    break;
                case 'b':
                default:
                    $items[] = 94;
                    break;
            }
        }

        return $items;
    }

}