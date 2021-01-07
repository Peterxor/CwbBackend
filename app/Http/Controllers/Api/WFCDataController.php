<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use App\Models\HostPreference;
use App\Models\TyphoonImage;
use App\Services\WFC\Exceptions\WFCException;
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
                'typhoon-dynamics' => TyphoonDynamics::get($typhoonImages->where('name', 'typhoon-dynamics')->first(['content'])->content, $preference),
                'typhoon-potential' => TyphoonPotential::get($typhoonImages->where('name', 'typhoon-potential')->first(['content'])->content, $preference),
                'wind-observation' => WindObservation::get($typhoonImages->where('name', 'wind-observation')->first(['content'])->content, $preference),
                'wind-forecast' => WindForecast::get(),
                'rainfall-observation' => [],
                'rainfall-forecast' => [],
            ],
            'weather' => [
                'information' => WeatherInformation::get()
            ]
        ]);
    }
}
