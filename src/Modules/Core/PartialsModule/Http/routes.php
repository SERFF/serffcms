<?php
Route::group(['middleware' => 'auth'], function () {
    Route::get('admin/partials/overview', ['as' => 'admin.partials.overview', 'uses' => 'Admin\PartialsController@getOverview']);
    Route::get('admin/partials/create', ['as' => 'admin.partials.create', 'uses' => 'Admin\PartialsController@getCreate']);
    Route::get('admin/partials/edit/{id}', ['as' => 'admin.partials.edit', 'uses' => 'Admin\PartialsController@getEdit']);
    Route::get('admin/partials/delete/{id}', ['as' => 'admin.partials.delete', 'uses' => 'Admin\PartialsController@getDelete']);
    
    Route::post('admin/partials/store', ['as' => 'admin.partials.store', 'uses' => 'Admin\PartialsController@postStore']);
});