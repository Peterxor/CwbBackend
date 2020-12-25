<?php

use Illuminate\Support\Facades\Route;

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

Route::get('probe', function () {
    return "ok";
});


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index')->name('index');

    Route::group(['prefix' => 'anchor', 'as' => 'anchor.'], function () {
        Route::get('query', ['as' => 'query', 'uses' => 'AnchorController@query']);
    });
    Route::resource('anchor', 'AnchorController')->except(['show']);

    Route::group(['prefix' => 'device', 'as' => 'device.'], function () {
        Route::get('query', ['as' => 'query', 'uses' => 'DeviceController@query']);
        Route::get('/', ['as' => 'index', 'uses' => 'DeviceController@index']);
        Route::get('/info', ['as' => 'info', 'uses' => 'Devicecontroller@info']);
    });

    Route::resource('weather', 'WeatherController')->except(['show']);
    Route::group(['prefix' => 'weather', 'as' => 'weather.'], function () {
        Route::get('/query', ['as' => 'query', 'uses' => 'WeatherController@query']);
        Route::get('/queryCategory', ['as' => 'queryCategory', 'uses' => 'WeatherController@queryCategory']);
        Route::post('/storeCategory', ['as' => 'storeCategory', 'uses' => 'WeatherController@storeCategory']);
    });


    Route::resource('typhoon', 'TyphoonController')->except(['show']);
    Route::group(['prefix' => 'typhoon', 'as' => 'typhoon.'], function () {
        Route::get('/query', ['as' => 'query', 'uses' => 'TyphoonController@query']);
    });


    Route::resource('users', 'UserController')->except(['show']);
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('query', ['as' => 'query', 'uses' => 'UserController@query']);
    });
});


Route::get('test-broadcast', function () {
    broadcast(new \App\Events\ExampleEvent);
});
