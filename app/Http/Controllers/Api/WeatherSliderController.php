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
        return response()->json(WeatherSlider::get($device->forecast_json, preference($device)));
    }
}
