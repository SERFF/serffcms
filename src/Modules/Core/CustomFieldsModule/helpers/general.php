<?php

function get_cf_form_option($key, $type, $type_id, $input_type, $default)
{
    $value = get_meta_value($type_id, $type, $key, null);
    
    if ($value === null) {
        return $default;
    }
    switch ($input_type) {
        case 'image':
            return array_get($value, 'id', null);
            break;
        case 'galery':
            $value = (collect($value));
            $result = array_map(function ($item) {
                return array_get($item, 'id');
            }, $value->toArray());

            return (implode('|', $result));
            break;
        default:
            return $value;
            break;
    }

    return $value;
}


function get_cf_image_url($type_id, $type, $key, $width = null, $height = null)
{
    $value = get_meta_value($type_id, $type, $key);

    if ($value === null) {
        $width = ($width === null) ? 1200 : $width;
        $height = ($height === null) ? 500 : $height;

        return sprintf('http://placehold.it/%sx%s', $width, $height);
    }

    return route('media.view', [
        'id'     => array_get($value, 'id'),
        'name'   => array_get($value, 'title'),
        'width'  => $width,
        'height' => $height,
    ]);
}
