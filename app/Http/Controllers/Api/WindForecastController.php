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
        $StationObs = $this->simpleXmlToArray(simplexml_load_file(public_path('WPPS_WWW_FcstWindTable_201609130943.xml')));

        return response()->json();
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
