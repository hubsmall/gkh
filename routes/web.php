<?php

Route::redirect('/', 'bookkeeperhome', 301);
Route::get('bookkeeperhome','HomeController@index');


Route::get('streets','StreetController@index');
Route::post('streets/update','StreetController@update');
Route::post('streets/store','StreetController@store');
Route::post('streets/destroy','StreetController@destroy');
Route::post('streets/search','StreetController@search');

Route::get('blocks','BlockController@index');
Route::post('blocks/update','BlockController@update');
Route::post('blocks/store','BlockController@store');
Route::post('blocks/destroy','BlockController@destroy');
Route::post('blocks/search','BlockController@search');

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

