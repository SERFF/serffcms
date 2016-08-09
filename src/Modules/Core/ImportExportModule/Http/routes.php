<?php
Route::group(['middleware' => 'auth'], function () {
    Route::get('admin/import-export/export', ['as' => 'admin.import-export.export', 'uses' => 'Admin\ExportController@getExport']);
    Route::get('admin/import-export/export/create', ['as' => 'admin.import-export.export.create', 'uses' => 'Admin\ExportController@getCreate']);
    Route::get('admin/import-export/export/delete/{id}', ['as' => 'admin.import-export.export.delete', 'uses' => 'Admin\ExportController@getDelete']);
    Route::get('admin/import-export/export/download/{id}', ['as' => 'admin.import-export.export.download', 'uses' => 'Admin\ExportController@getDownload']);
});
