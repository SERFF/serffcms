<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('admin/kabola-dealers/overview', ['as' => 'admin.kabola_dealers.overview', 'uses' => 'Admin\DealersController@getOverview']);
    Route::get('admin/kabola-dealers/create', ['as' => 'admin.kabola_dealers.create', 'uses' => 'Admin\DealersController@getCreate']);
    Route::get('admin/kabola-dealers/edit/{id}', ['as' => 'admin.kabola_dealers.edit', 'uses' => 'Admin\DealersController@getEdit']);
    Route::get('admin/kabola-dealers/delete/{id}', ['as' => 'admin.kabola_dealers.delete', 'uses' => 'Admin\DealersController@getDelete']);

    Route::get('admin/kabola-dealers/settings', ['as' => 'admin.kabola_dealers.settings', 'uses' => 'Admin\DealersController@getSettings']);

    Route::post('admin/kabola-dealer/store', ['as' => 'admin.kabola_dealers.store', 'uses' => 'Admin\DealersController@postStore']);
    Route::post('admin/kabola-dealers/settings/store', ['as' => 'admin.kabola_dealers.settings.store', 'uses' => 'Admin\DealersController@postStoreSettings']);
});


Route::get('dealers/ajax/location_result', ['as' => 'kabola_dealers.ajax.location_result', 'uses' => 'Ajax\DealersController@getDealers']);