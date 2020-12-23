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

        $StationObs = $this->simpleXmlToArray(simplexml_load_file(public_path('StationObs.xml')));

        $data = [
            'startTime' => $StationObs['dataset'][0]['datasetInfo'][0]['validTime'][0]['startTime'],
            'endTime' => $StationObs['dataset'][0]['datasetInfo'][0]['validTime'][0]['endTime'],
        ];

        $location = [];
        foreach ($StationObs['dataset'][0]['location'] ?? [] as $loc){
            $location[$loc['locationName']] = [
                "wind" => $loc['weatherElement'][1]['time'][0]['parameter'][2]['parameterValue'],
                "gust" => $loc['weatherElement'][2]['time'][0]['parameter'][2]['parameterValue'],
            ];
        }

        $data['location'] = $location;

        return response()->json($data);
    }

    function simpleXmlToArray(SimpleXMLElement $xmlObject)
    {
        $object = [];

        foreach ($xmlObject as $node) {
            if ($node->count()) {
                $object[$node->getName()][] = $this->simpleXmlToArray($node);
            } else
                $object[$node->getName()] = (string)$node;
        }

        return $object;
    }
}
