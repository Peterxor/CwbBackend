<?php

use Illuminate\Http\Request;
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

Route::get('wfc-data', 'WFCDataController@index');

Route::get('wind-observation', 'WindObservationController@index');

Route::get('wind-forecast', 'WindForecastController@index');

Route::get('rainfall-observation', 'RainfallObservationController@index');

Route::get('rainfall-forecast', 'RainfallForecastController@index');

Route::get('typhoon-dynamics', 'TyphoonDynamicsController@index');

Route::get('typhoon-potential', 'TyphoonPotentialController@index');

Route::get('anchor-information', 'AnchorInformationController@index');



Route::group(['prefix' => 'mobileDevice', 'as' => 'mobileDevice.'], function () {
    Route::get('deviceList', ['as' => 'deviceList', 'uses' => 'MobileDeviceController@deviceList']);
    Route::get('data', ['as' => 'data', 'uses' => 'MobileDeviceController@getDeviceData']);
    Route::get('action', ['as' => 'action', 'uses' => 'MobileDeviceController@action']);
});
