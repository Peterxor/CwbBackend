<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use App\Models\TyphoonImage;
use App\Services\WFC\AnchorInformation;
use App\Services\WFC\Dashboard;
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
     * @param Device $device 裝置
     * @return JsonResponse
     * @throws WFCException
     */
    public function index(Device $device): JsonResponse
    {
        $preference = preference($device);

        $typhoonImages = TyphoonImage::all(['name', 'content']);

        return response()->json([
            'meta' => [
                'theme' => '還沒想好',
                'color' => [
                    '#FF4B4B','#26D6FF', '#FF9046', '#88D904', '#FF9046', '#AF16E6'
                ]
            ],
            'dashboard' => Dashboard::get([], $preference),
            'typhoon' => [
                'information' => AnchorInformation::get([], $preference),
                'typhoon-dynamics' => TyphoonDynamics::get($typhoonImages->where('name', 'typhoon-dynamics')->first()->content, $preference),
                'typhoon-potential' => TyphoonPotential::get($typhoonImages->where('name', 'typhoon-potential')->first()->content, $preference),
                'wind-observation' => WindObservation::get($typhoonImages->where('name', 'wind-observation')->first()->content, $preference),
                'wind-forecast' => WindForecast::get($typhoonImages->where('name', 'wind-forecast')->first()->content, $preference),
                'rainfall-observation' => RainfallObservation::get($typhoonImages->where('name', 'rainfall-observation')->first()->content, $preference),
                'rainfall-forecast' => RainfallForecast::get($typhoonImages->where('name', 'rainfall-forecast')->first()->content, $preference),
            ],
            'weather' => [
                'information' => WeatherInformation::get([], $preference)
            ]
        ]);
    }
}
