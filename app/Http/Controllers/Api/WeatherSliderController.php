<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use App\Services\WFC\Exceptions\WFCException;
use App\Services\WFC\WeatherSlider;
use Illuminate\Http\JsonResponse;

class WeatherSliderController extends Controller
{
    /**
     * 一般天氣預報資料
     *
     * @param Device $device 裝置
     * @return JsonResponse
     * @throws WFCException
     */
    public function index(Device $device): JsonResponse
    {
        $hostPreference = $device->hostPreference()->where('user_id', $device->user_id)->first();
        $forecast_json = $hostPreference->forecast_json ?? $device->forecast_json;
        return response()->json(WeatherSlider::get($forecast_json, preference($device)));
    }
}
