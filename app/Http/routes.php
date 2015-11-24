<?php

Route::get('/', 'MpkController@index');
Route::get('/getstops/{city}', 'MpkController@getStops');
Route::get('/getdeps/{stop}/{dateint}', 'MpkController@getDeps');
Route::get('/getcities', 'MpkController@getCities');