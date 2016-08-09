<?php

/**
 * @param $key
 * @param string $default
 *
 * @return mixed|null
 */
function get_option($key, $default = '')
{
    return \Serff\Cms\Modules\Core\OptionsModule\OptionsModule::getOption($key, $default);
}

/**
 * @param $key
 * @param $value
 *
 * @return mixed|null
 */
function set_option($key, $value)
{
    return \Serff\Cms\Modules\Core\OptionsModule\OptionsModule::setOption($key, $value);
}

/**
 * @param $type_id
 * @param $type
 * @param $key
 * @param null $default
 *
 * @return mixed|null
 */
function get_meta_value($type_id, $type, $key, $default = null)
{
    $repository = app(\Serff\Cms\Modules\Core\OptionsModule\Domain\Repositories\MetaRepository::class);
    $meta = $repository->getByTypeAndKey($type_id, $type, $key);

    if ($meta === null) {
        return $default;
    }

    try {
        $value = unserialize($meta->value);
    } catch (\Exception $e) {
        $value = $meta->value;
    }

    return $value;
}

/**
 * @param $type_id
 * @param $type
 * @param $key
 * @param $value
 */
function set_meta_value($type_id, $type, $key, $value)
{
    $repository = app(\Serff\Cms\Modules\Core\OptionsModule\Domain\Repositories\MetaRepository::class);
    $meta = $repository->getByTypeAndKey($type_id, $type, $key);

    if (is_array($value)) {
        $value = serialize($value);
    }
    $data = [
        'type_id' => $type_id,
        'type'    => $type,
        'name'    => $key,
        'value'   => $value,
    ];

    if ($meta === null) {
        $repository->create($data);
    } else {
        $meta->update($data);
    }
}

/**
 * @param $key
 * @param string $default
 *
 * @return mixed|null
 */
function option_unserialize($key, $default = '')
{
    $data = get_option($key, $default);
    $result = null;
    try {
        $result = unserialize($data);
    } catch (\Exception $e) {
        $result = $data;
    }

    return $result;
}