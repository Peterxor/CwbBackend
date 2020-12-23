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


// TODO: 風力-觀
Route::get('wind-observation', 'WindObservationController@index');

// TODO: 風力-預
Route::get('wind-forecast', 'WindForecastController@index');

// TODO: 雨量-觀
Route::get('rainfall-observation', 'RainfallObservationController@index');

// TODO: 雨量-預
Route::get('rainfall-forecast', 'RainfallForecastController@index');

// TODO: 颱風動態
Route::get('typhoon-dynamics', 'TyphoonDynamicsController@index');

// TODO: 颱風潛勢
Route::get('typhoon-potential', 'TyphoonPotentialController@index');

// TODO: 主播圖卡
Route::get('anchor-information', 'AnchorInformationController@index');
