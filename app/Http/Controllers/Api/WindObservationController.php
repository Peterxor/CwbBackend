<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\JsonResponse;
use SimpleXMLElement;

class WindObservationController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $stationObs = simplexml_load_file(storage_path('xml/WindObs.xml'));

        $data = [
            'startTime' => (string)$stationObs->dataset->datasetInfo->validTime->startTime,
            'endTime' => (string)$stationObs->dataset->datasetInfo->validTime->endTime,
        ];

        $location = [];
        foreach ($stationObs->dataset->location ?? [] as $loc) {
            $location[(string)$loc->locationName] = [
                "wind" => (string)$loc->weatherElement[1]->time->parameter[2]->parameterValue,
                "gust" => (string)$loc->weatherElement[2]->time->parameter[2]->parameterValue,
            ];
        }

        $data['location'] = $location;

        return response()->json($data);
    }
}
