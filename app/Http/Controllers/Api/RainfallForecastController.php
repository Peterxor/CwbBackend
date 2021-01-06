<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\TyphoonImage;
use App\Services\WFC\Transformer;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Finder\Finder;

class RainfallForecastController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $content = json_decode(TyphoonImage::query()->where('name', '雨量預測')->first()->content);

        return response()->json([
            'all' => $this->format(storage_path($content->info->origin), $content->info->alert_value),
            '24h' => $this->format(storage_path($content->info->origin24), $content->info->alert_value_24)]);
    }

    private function format(string $path, $alert_value): array
    {
        // 以名稱排序(A-Z)取最後一個
        $files = iterator_to_array(Finder::create()->files()->in($path)->sortByName(), false);
        $rainfallForecast = simplexml_load_file($files[count($files) - 1]->getPathname());

        $data = ['alert_value' => (int)$alert_value,'location' =>  ['n' => [], 'm' => [], 's' => [], 'e' => []]];
        foreach ($rainfallForecast->PrecipitationInformation->AreaForecastData ?? [] as $areaForecastData) {
            if(((string) $areaForecastData->Precipitation->attributes()['region']) == 'flat'){
                $data['location'][Transformer::parseRainfallFcstCity((string) $areaForecastData->attributes()['area'])][(string) $areaForecastData->attributes()['area']]['flat'] =  (string) $areaForecastData->Precipitation->Value;
            } else {
                $data['location'][Transformer::parseRainfallFcstCity((string) $areaForecastData->attributes()['area'])][(string) $areaForecastData->attributes()['area']]['mountain'] =  (string) $areaForecastData->Precipitation->Value;
            }
        }

        return $data;
    }
}
