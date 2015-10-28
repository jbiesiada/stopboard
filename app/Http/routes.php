<?php

Route::get('/', 'MpkController@index');
Route::get('/import/{cityID}', 'MpkController@import');
Route::get('/getline/{LineID}', 'MpkController@importLine');
Route::get('/getlines/{cityID}', 'MpkController@getLines');
Route::get('/getstops/{cityID}', 'MpkController@getStops');
Route::get('/getdeps/{stopID}/{dateint}', 'MpkController@getDeps');
Route::get('/getcities', 'MpkController@getCities');
