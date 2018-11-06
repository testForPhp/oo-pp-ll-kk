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


Route::get('/okdsdkjhjkmn','IndexController@index');
Route::get('/create/html/s','IndexController@html');

Route::get('/s/auto/s/update/status','IndexController@autoUpdateFeeLog');

Route::get('/s/auto/check/link','Api\CheckLink@auto');
Route::get('/s/auto/check/link/check','Api\CheckLink@check');


Auth::routes();

Route::group(['middleware'=>'auth','prefix'=>'member'],function (){

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/links','LinksController@index');
    Route::post('/link','LinksController@store');
    Route::get('/link/{id}','LinksController@edit')->where(['0-9']);
    Route::put('/link','LinksController@update');
    Route::delete('/link/{id}','LinksController@destroy')->where(['0-9']);
    Route::put('/link/recommend','LinksController@recommend');
    Route::put('/link/rank','LinksController@rank');
    Route::put('/link/color','LinksController@color');
    Route::put('/link/color/renew','LinksController@renewColor');
    Route::get('/link/added/log','HomeController@linkLog');


    Route::get('/ad','AdsController@index');
    Route::post('/ad','AdsController@store');
    Route::put('/ad/renew','AdsController@renew');
    Route::get('/ad/{id}','AdsController@edit')->where(['0-9']);
    Route::delete('/ad/{id}','AdsController@destroy')->where(['0-9']);

    Route::get('/recharge','RechargeController@index');
    Route::post('/recharge','RechargeController@activeCode');


});


Route::group(['prefix'=>'fileStore','namespace'=>'Admin'],function (){
    Route::get('/login','LoginController@index');
    Route::post('/login','LoginController@login');
    Route::get('/logout','LoginController@logout');

    Route::group(['middleware'=>'auth:admin'],function (){

        Route::get('/index','HomeController@index');
        Route::get('/welcome','HomeController@welcome');

        Route::get('/user/index','UsersController@index');
        Route::get('/user/create','UsersController@create');
        Route::post('/user/create','UsersController@store');
        Route::get('/user/{id}/edit/','UsersController@edit');
        Route::post('/user/edit','UsersController@update');
        Route::delete('/user/{id}/delete','UsersController@destroy');

        Route::get('/sort/index','SortController@index');
        Route::get('/sort/create','SortController@create');
        Route::post('/sort/create','SortController@store');
        Route::get('/sort/{id}/edit','SortController@edit');
        Route::post('/sort/edit','SortController@update');
        Route::delete('/sort/{id}/delete','SortController@destroy');

        Route::get('/link/search','LinksController@search');
        Route::get('/link/pending','LinksController@pending');
        Route::get('/link/close','LinksController@chileError');
        Route::get('/link/{id}','LinksController@index');
        Route::get('/link/{id}/create','LinksController@create');
        Route::post('/link/create','LinksController@store');
        Route::get('/link/{id}/edit','LinksController@edit');
        Route::post('/link/edit','LinksController@update');
        Route::delete('/link/{id}/delete','LinksController@destroy');
        Route::put('/link/{id}','LinksController@active');

        Route::get('/system/index','SystemController@index');
        Route::post('/system','SystemController@store');

        Route::get('/system/fee','FeeController@index');
        Route::post('/system/fee','FeeController@store');

        Route::get('/system/color','ColorController@index');
        Route::get('/system/color/create','ColorController@create');
        Route::post('/system/color/create','ColorController@store');
        Route::get('/system/color/{id}/edit','ColorController@edit');
        Route::post('/system/color/edit','ColorController@update');
        Route::delete('/system/color/{id}/delete','ColorController@destroy');

        Route::get('/ad/index','AdsController@index');
        Route::get('/ad/create','AdsController@create');
        Route::post('/ad/create','AdsController@store');
        Route::get('/ad/{id}/edit','AdsController@edit');
        Route::post('/ad/edit','AdsController@update');
        Route::delete('/ad/{id}/delete','AdsController@destroy');

        Route::get('/point/index','PointController@index');
        Route::get('/point/used','PointController@used');
        Route::get('/point/create','PointController@create');
        Route::post('/point/create','PointController@store');
        Route::get('/point/{id}/create/code','PointController@createCodeView');
        Route::post('/point/code/create','PointController@storeCode');
        Route::get('/point/{id}/code','PointController@sort');
        Route::get('/point/{id}/edit','PointController@edit');
        Route::post('/point/edit','PointController@update');
        Route::delete('/point/{id}/destroy','PointController@destroy');
        Route::delete('/point/{id}/delete','PointController@delete');
        Route::get('/point/log','PointLogController@index');



    });


});

