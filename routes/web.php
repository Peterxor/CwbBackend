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

    // Dashboard
    Route::get('/', 'DashboardController@index')->name('index');

    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::get('query', ['as' => 'query', 'uses' => 'DashboardController@query']);
        Route::put('updateDeviceHost', ['as' => 'updateDeviceHost', 'uses' => 'DashboardController@updateDeviceHost']);
        Route::put('updateDeviceTheme', ['as' => 'updateDeviceTheme', 'uses' => 'DashboardController@updateDeviceTheme']);
        Route::post('updateBoard', ['as' => 'updateBoard', 'uses' => 'DashboardController@updateBoard']);
    });
    Route::resource('dashboard', 'DashboardController')->except(['show']);

    // 人員簡介管理
    Route::group(['prefix' => 'personnel', 'as' => 'personnel.'], function () {
        Route::get('query', ['as' => 'query', 'uses' => 'PersonnelController@query']);
    });
    Route::resource('personnel', 'PersonnelController')->except(['show']);

    // 主播偏好設定
    Route::group(['prefix' => 'anchor', 'as' => 'anchor.'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'AnchorController@index']);
        Route::get('query', ['as' => 'query', 'uses' => 'AnchorController@query']);
        Route::put('{id}/update', ['as' => 'update', 'uses' => 'AnchorController@update']);
        Route::get('{id}/{device_id}/edit', ['as' => 'show', 'uses' => 'AnchorController@edit']);
    });

    // 裝置排版管理
    Route::group(['prefix' => 'device', 'as' => 'device.'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'DeviceController@index']);
        Route::get('query', ['as' => 'query', 'uses' => 'DeviceController@query']);
        Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'DeviceController@edit']);
        Route::put('{id}/update', ['as' => 'update', 'uses' => 'DeviceController@update']);
    });

    // 一般天氣預報
    Route::group(['prefix' => 'weather', 'as' => 'weather.'], function () {
        Route::get('/query', ['as' => 'query', 'uses' => 'WeatherController@query']);
        Route::get('/queryCategory', ['as' => 'queryCategory', 'uses' => 'WeatherController@queryCategory']);
        Route::post('/storeCategory', ['as' => 'storeCategory', 'uses' => 'WeatherController@storeCategory']);
        Route::get('/upper', ['as' => 'upper', 'uses' => 'WeatherController@upper']);
        Route::get('/lower', ['as' => 'lower', 'uses' => 'WeatherController@lower']);
    });
    Route::resource('weather', 'WeatherController')->except(['show']);

    // 颱風預報
    Route::group(['prefix' => 'typhoon', 'as' => 'typhoon.'], function () {
        Route::get('/query', ['as' => 'query', 'uses' => 'TyphoonController@query']);
        Route::get('/upper', ['as' => 'upper', 'uses' => 'TyphoonController@upper']);
        Route::get('/lower', ['as' => 'lower', 'uses' => 'TyphoonController@lower']);
    });
    Route::resource('typhoon', 'TyphoonController')->except(['show']);

    // 使用者管理
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('query', ['as' => 'query', 'uses' => 'UserController@query']);
    });
    Route::resource('users', 'UserController')->except(['show']);

    // 事件紀錄
    Route::group(['prefix' => 'active', 'as' => 'active.'], function () {
        Route::get('/query', ['as' => 'query', 'uses' => 'ActiveController@query']);
    });
    Route::resource('active', 'ActiveController')->except(['show']);

    Route::group(['prefix' => 'media', 'as' => 'media.'], function () {
        Route::post('upload', ['as' => 'upload', 'uses' => 'MediaController@upload']);
    });
});
