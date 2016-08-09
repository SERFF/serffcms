<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('admin/media/library', ['as' => 'admin.media.library', 'uses' => 'Admin\MediaController@getLibrary']);
    Route::get('admin/media/add', ['as' => 'admin.media.new', 'uses' => 'Admin\MediaController@getAdd']);

    Route::post('admin/media/upload', ['as' => 'admin.media.upload', 'uses' => 'Admin\MediaController@postUpload']);

    Route::get('admin/media/delete/{id}', ['as' => 'admin.media.delete', 'uses' => 'Admin\MediaController@getDelete']);
    
    Route::get('admin/media/images/json', ['as' => 'admin.media.images.json', 'uses' => 'Admin\MediaController@getImagesJson']);
});

Route::get('images/{id}/{name}/{width?}/{height?}', ['as' => 'media.view', 'uses' => 'MediaController@getImage']);
