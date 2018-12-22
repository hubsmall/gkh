<?php

Route::redirect('/', 'bookkeeperhome', 301);
Route::get('bookkeeperhome','HomeController@index');


Route::get('streets','StreetController@index');
Route::post('streets/update','StreetController@update');
Route::post('streets/store','StreetController@store');
Route::post('streets/destroy','StreetController@destroy');

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

