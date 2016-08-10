<?php
Route::group(['middleware' => 'auth'], function () {
    Route::get('admin/products/create', ['as' => 'admin.products.create', 'uses' => 'Admin\ProductsController@getCreate']);
    Route::get('admin/products/edit/{id}', ['as' => 'admin.products.edit', 'uses' => 'Admin\ProductsController@getEdit']);
    Route::get('admin/products/delete/{id}', ['as' => 'admin.products.delete', 'uses' => 'Admin\ProductsController@getDelete']);
    Route::get('admin/products/overview', ['as' => 'admin.products.overview', 'uses' => 'Admin\ProductsController@getOverview']);

    Route::get('admin/products/attributes/create', ['as' => 'admin.products.attributes.create', 'uses' => 'Admin\AttributesController@getCreate']);
    Route::get('admin/products/attributes/edit/{id}', ['as' => 'admin.products.attributes.edit', 'uses' => 'Admin\AttributesController@getEdit']);
    Route::get('admin/products/attributes/overview', ['as' => 'admin.products.attributes.overview', 'uses' => 'Admin\AttributesController@getOverview']);

    Route::get('admin/products/attributes/groups/create', ['as' => 'admin.products.attributes.groups.create', 'uses' => 'Admin\AttributeGroupsController@getCreate']);
    Route::get('admin/products/attributes/groups/edit/{id}', ['as' => 'admin.products.attributes.groups.edit', 'uses' => 'Admin\AttributeGroupsController@getEdit']);
    Route::get('admin/products/attributes/groups/overview', ['as' => 'admin.products.attributes.groups.overview', 'uses' => 'Admin\AttributeGroupsController@getOverview']);
    
    Route::get('admin/products/categories/overview', ['as' => 'admin.products.categories.overview', 'uses' => 'Admin\CategoryController@getOverview']);
    Route::get('admin/products/categories/create', ['as' => 'admin.products.categories.create', 'uses' => 'Admin\CategoryController@getCreate']);
    Route::get('admin/products/categories/edit/{id}', ['as' => 'admin.products.categories.edit', 'uses' => 'Admin\CategoryController@getEdit']);
    Route::get('admin/products/categories/delete/{id}', ['as' => 'admin.products.categories.delete', 'uses' => 'Admin\CategoryController@getDelete']);

    Route::post('admin/products/store', ['as' => 'admin.products.store', 'uses' => 'Admin\ProductsController@postStore']);
    Route::post('admin/products/attributes/store', ['as' => 'admin.products.attributes.store', 'uses' => 'Admin\AttributesController@postStore']);
    Route::post('admin/products/attributes/groups/store', ['as' => 'admin.products.attributes.groups.store', 'uses' => 'Admin\AttributeGroupsController@postStore']);
    Route::post('admin/products/categories/store', ['as' => 'admin.products.categories.store', 'uses' => 'Admin\CategoryController@postStore']);
    
    Route::get('admin/tailormade/requests', ['as' => 'admin.tailormade.requests', 'uses' => 'Admin\TailorMadeRequestController@getIndex']);
    Route::get('admin/tailormade/requests/view/{id}', ['as' => 'admin.tailormade.requests.view', 'uses' => 'Admin\TailorMadeRequestController@getView']);
    Route::get('admin/tailormade/requests/handle/{id}', ['as' => 'admin.tailormade.requests.handle', 'uses' => 'Admin\TailorMadeRequestController@getHandle']);

});

Route::get('product/{id}', ['as' => 'product.single.view', 'uses' => 'ProductsController@getView']);
Route::get('groep/{id}', ['as' => 'product.category.view', 'uses' => 'ProductsController@getCategoryView']);

Route::post('products/filtered', ['as' => 'products.filtered', 'uses' => 'ProductsController@postFiltered']);
Route::post('products/tailor-made', ['as' => 'products.tailer_made', 'uses' => 'ProductsController@postTailorMade']);

Route::post('configurator/calculate', ['as' => 'configurator.calculate', 'uses' => 'ConfiguratorController@postCalculate']);
Route::get('configurator/overview', ['as' => 'configurator.overview', 'uses' => 'ConfiguratorController@getOverview']);
Route::post('configurator/filtered', ['as' => 'configurator.filtered', 'uses' => 'ConfiguratorController@postFiltered']);