<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\JsonResponse;
use SimpleXMLElement;

class WindForecastController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $windForecast = simplexml_load_file(storage_path('xml/WindForecast.xml'));

        $data = [];

        foreach ($windForecast->WindForecastInformation->AreaForecastData ?? [] as $areaForecastData) {
            $key = (string) $areaForecastData->StartValidTime->Time;
            if(!array_key_exists($key, $data)){
                $data[$key]['startTime'] = (string) $areaForecastData->StartValidTime->Time;
                $data[$key]['endTime'] = (string) $areaForecastData->EndValidTime->Time;
                $data[$key]['location'] = [];
            }

            if(((string) $areaForecastData->WindData->attributes()['type']) == 'average'){
                $data[$key]['location'][(string) $areaForecastData->attributes()['area']]['wind'] =  (string) $areaForecastData->WindData->Level;
            } else {
                $data[$key]['location'][(string) $areaForecastData->attributes()['area']]['gust'] =  (string) $areaForecastData->WindData->Level;
            }
        }

        return response()->json($data);
    }
}
