<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('translation/update', ['as' => 'translation.ajax.update', 'uses' => 'Admin\TranslationController@ajaxUpdate']);
    Route::get('translation/toggle', ['as' => 'translation.toggle', 'uses' => 'Admin\TranslationController@toggleTranslate']);
    Route::get('translation/get-value', ['as' => 'translation.get_value', 'uses' => 'Admin\TranslationController@getValue']);

    Route::get('admin/translations/settings', ['as' => 'admin.translation.settings', 'uses' => 'Admin\TranslationController@getSettings']);
    Route::get('admin/translations/overview', ['as' => 'admin.translation.overview', 'uses' => 'Admin\TranslationController@getOverview']);
    Route::post('admin/translations/settings/save', ['as' => 'admin.translations.settings.save', 'uses' => 'Admin\TranslationController@postSaveSettings']);
    Route::get('admin/translations/edit/{id}', ['as' => 'admin.translations.edit', 'uses' => 'Admin\TranslationController@getEdit']);
    Route::post('admin/translations/store', ['as' => 'admin.translations.store', 'uses' => 'Admin\TranslationController@postStore']);
});