<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\TyphoonImage;
use App\Services\WFC\Exceptions\WFCException;
use App\Services\WFC\RainfallForecast;
use App\Services\WFC\RainfallObservation;
use App\Services\WFC\TyphoonDynamics;
use App\Services\WFC\TyphoonPotential;
use App\Services\WFC\WeatherInformation;
use App\Services\WFC\WindForecast;
use App\Services\WFC\WindObservation;
use Illuminate\Http\JsonResponse;

class WFCDataController extends Controller
{
    /**
     * @param mixed $device_id 裝置ID
     * @return JsonResponse
     * @throws WFCException
     */
    public function index($device_id): JsonResponse
    {
        $preference = preference($device_id);

        $typhoonImages = TyphoonImage::all(['name', 'content']);

        return response()->json([
            'meta' => [],
            'typhoon' => [
                'information' => [],
                'typhoon-dynamics' => TyphoonDynamics::get($typhoonImages->where('name', 'typhoon-dynamics')->first()->content, $preference),
                'typhoon-potential' => TyphoonPotential::get($typhoonImages->where('name', 'typhoon-potential')->first()->content, $preference),
                'wind-observation' => WindObservation::get($typhoonImages->where('name', 'wind-observation')->first()->content, $preference),
                'wind-forecast' => WindForecast::get($typhoonImages->where('name', 'wind-forecast')->first()->content, $preference),
                'rainfall-observation' => RainfallObservation::get($typhoonImages->where('name', 'rainfall-observation')->first()->content, $preference),
                'rainfall-forecast' => RainfallForecast::get($typhoonImages->where('name', 'rainfall-forecast')->first()->content, $preference),
            ],
            'weather' => [
                'information' => WeatherInformation::get()
            ]
        ]);
    }
}
