<?php

function get_username_by_id($id)
{
    $user = \Serff\Cms\Modules\Core\UsersModule\Domain\Models\User\User::find($id);

    if ($user !== null) {
        return $user->name;
    }

    return '';
}