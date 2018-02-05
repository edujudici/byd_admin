<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/',  ['as' => 'home.show',  'uses' => 'HomeController@show']);

Route::get('/banner',  ['as' => 'banner.show',  'uses' => 'BannerController@show']);
Route::post('/banner-save',  ['as' => 'banner.save',  'uses' => 'BannerController@save']);
Route::post('/banner-delete',  ['as' => 'banner.delete',  'uses' => 'BannerController@delete']);


Route::get('/test',  ['as' => 'test',  'uses' => 'HomeController@test']);


