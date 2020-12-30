<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\TyphoonImage;
use App\Services\CWB\Transformer;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Finder\Finder;

class WindForecastController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $path = storage_path(json_decode(TyphoonImage::query()->where('name', '風力預測')->first()->content)->info->origin);

        // 以名稱排序(A-Z)取最後一個
        $files = iterator_to_array(Finder::create()->files()->in($path)->sortByName(), false);
        $windForecast = simplexml_load_file($files[count($files) - 1]->getPathname());

        $data = [];
        foreach ($windForecast->WindForecastInformation->AreaForecastData ?? [] as $areaForecastData) {
            $key = (string)$areaForecastData->StartValidTime->Time;
            if (!array_key_exists($key, $data)) {
                $data[$key]['startTime'] = (string)$areaForecastData->StartValidTime->Time;
                $data[$key]['endTime'] = (string)$areaForecastData->EndValidTime->Time;
                $data[$key]['location'] = ['n' => [], 'm' => [], 's' => [], 'e' => []];
            }

            if (((string)$areaForecastData->WindData->attributes()['type']) == 'average') {
                $data[$key]['location'][Transformer::parseWindCity((string)$areaForecastData->attributes()['area'])][(string)$areaForecastData->attributes()['area']]['wind'] = (string)$areaForecastData->WindData->Level;
            } else {
                $data[$key]['location'][Transformer::parseWindCity((string)$areaForecastData->attributes()['area'])][(string)$areaForecastData->attributes()['area']]['gust'] = (string)$areaForecastData->WindData->Level;
            }
        }

        return response()->json($data);
    }
}
