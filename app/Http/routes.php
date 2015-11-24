<?php

Route::get('/', 'MpkController@index');
Route::get('/import/{city}', 'MpkController@import');
Route::get('/getline/{line}', 'MpkController@importLine');
Route::get('/getlines/{city}', 'MpkController@getLines');
Route::get('/getstops/{city}', 'MpkController@getStops');
Route::get('/getdeps/{stop}/{dateint}', 'MpkController@getDeps');
Route::get('/getcities', 'MpkController@getCities');
Route::get('/getcreated', 'MpkController@getcreated');
Route::get('/truncatetables', 'MpkController@truncateTables');