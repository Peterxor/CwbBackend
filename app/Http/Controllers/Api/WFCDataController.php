<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use App\Models\HostPreference;
use App\Models\TyphoonImage;
use App\Services\WFC\TyphoonDynamics;
use App\Services\WFC\WeatherInformation;
use App\Services\WFC\WindForecast;
use App\Services\WFC\WindObservation;
use Illuminate\Http\JsonResponse;

class WFCDataController extends Controller
{
    /**
     * @param $device_id
     * @return JsonResponse
     */
    public function index($device_id): JsonResponse
    {
        $device = Device::query()->find($device_id);
        $preference = $device->preference_json;

        $hostPreference = HostPreference::query()->firstOrCreate([
            'user_id' => $device->user_id,
            'device_id' => $device_id
        ]);

        $preference = array_merge($preference, $hostPreference->preference_json ?? []);

        $typhoonImages = TyphoonImage::all();

        return response()->json([
            'meta' => [],
            'typhoon' => [
                'information' => [],
                'typhoon-dynamics' => TyphoonDynamics::get(json_decode($typhoonImages->where('name', '颱風動態圖')->first()->content), $preference),
                'typhoon-potential' => [],
                'wind-observation' => WindObservation::get(),
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
