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

Route::get('probe', 'DashboardController@probe');


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index')->name('index');

    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::get('query', ['as' => 'query', 'uses' => 'DashboardController@query']);
    });
    Route::resource('dashboard', 'DashboardController')->except(['show']);

    Route::group(['prefix' => 'anchor', 'as' => 'anchor.'], function () {
        Route::get('query', ['as' => 'query', 'uses' => 'AnchorController@query']);
    });
    Route::resource('anchor', 'AnchorController')->except(['show']);

    Route::group(['prefix' => 'device', 'as' => 'device.'], function () {
        Route::get('query', ['as' => 'query', 'uses' => 'DeviceController@query']);
        Route::get('/', ['as' => 'index', 'uses' => 'DeviceController@index']);
        Route::get('/info', ['as' => 'info', 'uses' => 'DeviceController@info']);
        Route::put('/updateDeviceHost', ['as' => 'updateDeviceHost', 'uses' => 'DeviceController@updateDeviceHost']);
    });

    Route::group(['prefix' => 'weather', 'as' => 'weather.'], function () {
        Route::get('/query', ['as' => 'query', 'uses' => 'WeatherController@query']);
        Route::get('/queryCategory', ['as' => 'queryCategory', 'uses' => 'WeatherController@queryCategory']);
        Route::post('/storeCategory', ['as' => 'storeCategory', 'uses' => 'WeatherController@storeCategory']);
        Route::get('/upper', ['as' => 'upper', 'uses' => 'WeatherController@upper']);
        Route::get('/lower', ['as' => 'lower', 'uses' => 'WeatherController@lower']);
    });
    Route::resource('weather', 'WeatherController')->except(['show']);

    Route::group(['prefix' => 'typhoon', 'as' => 'typhoon.'], function () {
        Route::get('/query', ['as' => 'query', 'uses' => 'TyphoonController@query']);
        Route::get('/upper', ['as' => 'upper', 'uses' => 'TyphoonController@upper']);
        Route::get('/lower', ['as' => 'lower', 'uses' => 'TyphoonController@lower']);
    });
    Route::resource('typhoon', 'TyphoonController')->except(['show']);

    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('query', ['as' => 'query', 'uses' => 'UserController@query']);
    });
    Route::resource('users', 'UserController')->except(['show']);

    Route::group(['prefix' => 'active', 'as' => 'active.'], function () {
        Route::get('/query', ['as' => 'query', 'uses' => 'ActiveController@query']);
    });
    Route::resource('active', 'ActiveController')->except(['show']);
});
