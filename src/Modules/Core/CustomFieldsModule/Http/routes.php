<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('admin/customfields/groups', ['as' => 'admin.customfields.groups', 'uses' => 'Admin\CustomFieldsController@getGroups']);
    Route::get('admin/customfields/new-group', ['as' => 'admin.customfields.new_group', 'uses' => 'Admin\CustomFieldsController@getNewGroup']);

    Route::get('admin/customfields/edit-group/{id}', ['as' => 'admin.customfields.edit_group', 'uses' => 'Admin\CustomFieldsController@getEditGroup']);
    Route::post('admin/customfields/store', ['as' => 'admin.customfields.store', 'uses' => 'Admin\CustomFieldsController@postStore']);
    
    
    /**
     * Ajax Routes
     */
    Route::get('admin/customfields/ajax/rules_values', ['as' => 'admin.customerfields.ajax.rules_values', 'uses' => 'Ajax\CustomFieldsController@getRulesValues']);
    Route::get('admin/customfields/ajax/gallery_modal', ['as' => 'admin.customfields.ajax.gallery_modal', 'uses' => 'Ajax\CustomFieldsController@getGalleryModal']);
});