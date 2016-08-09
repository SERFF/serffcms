<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('admin/theme/settings', ['as' => 'admin.theme.settings', 'uses' => 'Admin\ThemeController@getSettings']);
    Route::post('admin/theme/activate', ['as' => 'admin.theme.activate', 'uses' => 'Admin\ThemeController@postActivate']);

    Route::get('admin/theme/navigation', ['as' => 'admin.theme.navigation', 'uses' => 'Admin\ThemeController@getNavigation']);
    Route::post('admin/theme/navigation-store', ['as' => 'admin.theme.store_navigation', 'uses' => 'Admin\ThemeController@postStoreNavigation']);
});