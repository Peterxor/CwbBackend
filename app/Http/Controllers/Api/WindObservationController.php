<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\TyphoonImage;
use App\Services\CWB\Transformer;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Finder\Finder;

class WindObservationController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $path = storage_path(json_decode(TyphoonImage::query()->where('name', '風力觀測')->first()->content)->info->origin);

        // 以名稱排序(A-Z)取最後一個
        $files = iterator_to_array(Finder::create()->files()->in($path)->sortByName(), false);
        $windObs = simplexml_load_file($files[count($files) - 1]->getPathname());

        $data = [
            'startTime' => (string)$windObs->dataset->datasetInfo->validTime->startTime,
            'endTime' => (string)$windObs->dataset->datasetInfo->validTime->endTime,
        ];

        $location = ['n' => [], 'm' => [], 's' => [], 'e' => []];
        foreach ($windObs->dataset->location ?? [] as $loc) {
            if (empty($county = Transformer::parseLocation((string)$loc->locationName)))
                continue;

            $location[Transformer::parseWindCounty($county)][$county] = [
                "wind" => (string)$loc->weatherElement[1]->time->parameter[2]->parameterValue,
                "gust" => (string)$loc->weatherElement[2]->time->parameter[2]->parameterValue,
            ];
        }

        $data['location'] = $location;

        return response()->json($data);
    }
}
