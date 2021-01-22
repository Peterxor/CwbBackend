<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('wfc-data/{device}', 'WFCDataController@index');

Route::get('dashboard/{device}', 'DashboardController@index');

Route::get('typhoon-dynamics/{device}', 'TyphoonDynamicsController@index');

Route::get('typhoon-potential/{device}', 'TyphoonPotentialController@index');

Route::get('wind-observation/{device}', 'WindObservationController@index');

Route::get('wind-forecast/{device}', 'WindForecastController@index');

Route::get('rainfall-observation/{device}', 'RainfallObservationController@index');

Route::get('rainfall-forecast/{device}', 'RainfallForecastController@index');

Route::get('anchor-information/{device}', 'AnchorInformationController@index');

Route::get('weather-slider/{device}', 'WeatherSliderController@index');

Route::get('weather-overview/{device}', 'WeatherOverviewController@index');


Route::group(['prefix' => 'mobileDevice', 'as' => 'mobileDevice.'], function () {
    // 裝置列表
    Route::get('device-list', ['as' => 'device-list', 'uses' => 'MobileDeviceController@deviceList']);

    // 裝置資料
    Route::get('data', ['as' => 'data', 'uses' => 'MobileDeviceController@getDeviceData']);

    // 打websocket
    Route::get('action', ['as' => 'action', 'uses' => 'MobileDeviceController@action']);

    // 天氣總覽
    Route::get('weather-detail', ['as' => 'weather-detail', 'uses' => 'MobileDeviceController@weatherDetail']);

    // 更新主播
    Route::put('update-anchor', ['as' => 'update-anchor', 'uses' => 'MobileDeviceController@updateAnchor']);

    // 獲取元件座標
    Route::get('host-preference', ['as' => 'host-preference', 'uses' => 'MobileDeviceController@hostPreference']);

    // 更新元件座標
    Route::put('update-preference', ['as' => 'update-preference', 'uses' => 'MobileDeviceController@updatePreference']);

});
