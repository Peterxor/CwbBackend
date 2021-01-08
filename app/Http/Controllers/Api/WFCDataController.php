<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use App\Models\TyphoonImage;
use App\Services\WFC\AnchorInformation;
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
                ],
                'dashboard' => [
                    'type' => 'default',
                    'background' => '還沒想好',
                    'user-1' => [
                        'name' => '伍婉華',
                        'nick-name' => '簡任技正',
                        'career' => '秘書室簡任技正',
                        'education' => '中央大學大氣物理研究所碩士',
                        'experience' => [
                            '第一組第二科科長',
                            '氣象預報中心技正',
                            '氣象預報中心資深預報員'
                        ]
                    ],
                    'user-2' => null,
                    'press-conference' => [
                        'enable' => true,
                        'time' => '11 : 40 AM',
                    ],
                    'next-press-conference' => [
                        'enable' => true,
                        'time' => '14 : 40 AM'
                    ]
                ]
            ],
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
