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

Route::get('typhoon-dynamics/{device}', 'TyphoonDynamicsController@index');

Route::get('typhoon-potential/{device}', 'TyphoonPotentialController@index');

Route::get('wind-observation/{device}', 'WindObservationController@index');

Route::get('wind-forecast/{device}', 'WindForecastController@index');

Route::get('rainfall-observation/{device}', 'RainfallObservationController@index');

Route::get('rainfall-forecast/{device}', 'RainfallForecastController@index');

Route::get('anchor-information/{device}', 'AnchorInformationController@index');

Route::get('weather-information/{device}', 'WeatherInformationController@index');


Route::group(['prefix' => 'mobileDevice', 'as' => 'mobileDevice.'], function () {
    Route::get('deviceList', ['as' => 'deviceList', 'uses' => 'MobileDeviceController@deviceList']);
    Route::get('data', ['as' => 'data', 'uses' => 'MobileDeviceController@getDeviceData']);
    Route::get('action', ['as' => 'action', 'uses' => 'MobileDeviceController@action']);
    Route::get('weatherDetail', ['as' => 'weatherDetail', 'uses' => 'MobileDeviceController@weatherDetail']);
    Route::put('updateAnchor', ['as' => 'updateAnchor', 'uses' => 'MobileDeviceController@updateAnchor']);
});
