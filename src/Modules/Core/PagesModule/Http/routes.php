<?php

use Serff\Cms\Modules\Core\PagesModule\Domain\Models\Pages\Page;

Route::group(['middleware' => 'auth'], function () {

    Route::get('admin/pages/overview', ['as' => 'admin.pages.overview', 'uses' => 'Admin\PagesController@getOverview']);
    Route::get('admin/pages/create', ['as' => 'admin.pages.create', 'uses' => 'Admin\PagesController@getCreate']);
    Route::get('admin/pages/edit/{id}', ['as' => 'admin.pages.edit', 'uses' => 'Admin\PagesController@getEdit']);
    Route::get('admin/pages/delete/{id}', ['as' => 'admin.pages.delete', 'uses' => 'Admin\PagesController@getDelete']);

    Route::post('admin/pages/store', ['as' => 'admin.pages.store', 'uses' => 'Admin\PagesController@postStore']);
    
    Route::get('admin/pages/ajax/get-content', ['as' => 'admin.pages.ajax.getContent', 'uses' => 'Ajax\PagesController@getContent']);
    Route::get('admin/pages/ajax/update-content', ['as' => 'admin.pages.ajax.updateContent', 'uses' => 'Ajax\PagesController@updateContent']);
});

Route::group(['prefix' => $route_prefix], function () use ($prefix, $locale) {
    /**
     * Route for /{slug}
     */
    if (env('INSTALLED', false) == true) { //@todo move to middleware

        Route::get('/', ['as' => $prefix . 'home', 'uses' => 'PagesController@getIndex']);
        //Route::get(translate('general.page', [], true, true, 'messages', $locale).'/{slug}', ['as' => $prefix . 'page', 'uses' => 'PagesController@getPage'])->where('{slug}', Page::getSlugsInPipeFormat('nl'));
	    Route::get('/{slug}', ['as' => $prefix . 'page', 'uses' => 'PagesController@getPage'])->where('{slug}', Page::getSlugsInPipeFormat('nl'));
    } else {
        Route::get('/', function () {
            return 'Installed / migrated';
        });
    }
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
});