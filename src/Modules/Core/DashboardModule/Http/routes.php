<?php

Route::group(['middleware' => 'auth'], function () {
   Route::get('dashboard', ['as' => 'dashboard', 'uses' => function() {
       return redirect()->route('admin.pages.overview');
   }]); 
});