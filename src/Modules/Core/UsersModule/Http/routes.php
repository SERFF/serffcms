<?php

Route::get('admin/login', ['as' => 'admin.login', 'uses' => 'App\Http\Controllers\Auth\LoginController@showLoginForm']);
