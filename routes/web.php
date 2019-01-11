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

Route::get('flats','FlatController@index');
Route::post('flats/update','FlatController@update');
Route::post('flats/store','FlatController@store');
Route::post('flats/destroy','FlatController@destroy');
Route::post('flats/search','FlatController@search');

Route::get('tenants','TenantController@index');
Route::post('tenants/update','TenantController@update');
Route::post('tenants/store','TenantController@store');
Route::post('tenants/destroy','TenantController@destroy');
Route::post('tenants/search','TenantController@search');

Route::get('serves','ServeController@index');
Route::post('serves/update','ServeController@update');
Route::post('serves/store','ServeController@store');
Route::post('serves/destroy','ServeController@destroy');
Route::post('serves/search','ServeController@search');

Route::get('advantages','AdvantageController@index');
Route::post('advantages/update','AdvantageController@update');
Route::post('advantages/store','AdvantageController@store');
Route::post('advantages/destroy','AdvantageController@destroy');
Route::post('advantages/search','AdvantageController@search');

Route::get('indications','IndicationController@index');
Route::post('indications/update','IndicationController@update');
Route::post('indications/store','IndicationController@store');
Route::post('indications/destroy','IndicationController@destroy');
Route::post('indications/search','IndicationController@search');


//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

