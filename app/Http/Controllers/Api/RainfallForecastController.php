<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\JsonResponse;

class RainfallForecastController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $rainfallAllForecast = simplexml_load_file(storage_path('data/rainfall/forecast/RainfallAllForecast.xml'));

        $allData = [];

        foreach ($rainfallAllForecast->PrecipitationInformation->AreaForecastData ?? [] as $areaForecastData) {
            if(((string) $areaForecastData->Precipitation->attributes()['region']) == 'flat'){
                $allData['location'][(string) $areaForecastData->attributes()['area']]['flat'] =  (string) $areaForecastData->Precipitation->Value;
            } else {
                $allData['location'][(string) $areaForecastData->attributes()['area']]['mountain'] =  (string) $areaForecastData->Precipitation->Value;
            }
        }


        $rainfall24HForecast = simplexml_load_file(storage_path('data/rainfall/forecast/Rainfall24HForecast.xml'));

        $twentyFourData = [];

        foreach ($rainfall24HForecast->PrecipitationInformation->AreaForecastData ?? [] as $areaForecastData) {
            if(((string) $areaForecastData->Precipitation->attributes()['region']) == 'flat'){
                $twentyFourData['location'][(string) $areaForecastData->attributes()['area']]['flat'] =  (string) $areaForecastData->Precipitation->Value;
            } else {
                $twentyFourData['location'][(string) $areaForecastData->attributes()['area']]['mountain'] =  (string) $areaForecastData->Precipitation->Value;
            }
        }


        return response()->json(['all' => $allData, '24h' => $twentyFourData]);
    }
}
