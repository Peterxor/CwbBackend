<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\JsonResponse;

class RainfallForecastController extends Controller
{
    private $countyToTaiwan = [
        '臺北市' => 'n',
        '新北市' => 'n',
        '基隆市' => 'n',
        '桃園市' => 'n',
        '新竹市' => 'n',
        '新竹縣' => 'n',
        '宜蘭縣' => 'y',
        '苗栗縣' => 'm',
        '臺中市' => 'm',
        '彰化縣' => 'm',
        '南投縣' => 'm',
        '雲林縣' => 'm',
        '嘉義市' => 's',
        '嘉義縣' => 's',
        '臺南市' => 's',
        '高雄市' => 's',
        '屏東縣' => 's',
        '恆春半島' => 's',
        '澎湖縣' => 's',
        '花蓮縣' => 'h',
        '臺東縣' => 'e',
        '蘭嶼綠島' => 'e',
        '金門縣' => 'e',
        '連江縣' => 'e'
    ];

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'all' => $this->format(storage_path('data/rainfall/forecast/RainfallAllForecast.xml')),
            '24h' => $this->format(storage_path('data/rainfall/forecast/Rainfall24HForecast.xml'))]);
    }

    private function format(string $path): array
    {
        $data = ['location' =>  ['n' => [], 'm' => [], 's' => [], 'y' => [], 'h' => [], 'e' => []]];

        $rainfallForecast = simplexml_load_file($path);

        foreach ($rainfallForecast->PrecipitationInformation->AreaForecastData ?? [] as $areaForecastData) {
            if(((string) $areaForecastData->Precipitation->attributes()['region']) == 'flat'){
                $data['location'][$this->countyToTaiwan[(string) $areaForecastData->attributes()['area']]][(string) $areaForecastData->attributes()['area']]['flat'] =  (string) $areaForecastData->Precipitation->Value;
            } else {
                $data['location'][$this->countyToTaiwan[(string) $areaForecastData->attributes()['area']]][(string) $areaForecastData->attributes()['area']]['mountain'] =  (string) $areaForecastData->Precipitation->Value;
            }
        }

        return $data;
    }
}
