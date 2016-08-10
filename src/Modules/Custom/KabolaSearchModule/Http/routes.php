<?php

Route::get('search', ['as' => 'kabola.search', 'uses' => 'SearchController@getSearch']);