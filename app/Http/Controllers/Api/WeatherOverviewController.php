<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use App\Services\WFC\Exceptions\WFCException;
use App\Services\WFC\WeatherOverview;
use Illuminate\Http\JsonResponse;

class WeatherOverviewController extends Controller
{
    /**
     * 一般天氣總攬資料
     *
     * @param Device $device 裝置
     * @return JsonResponse
     * @throws WFCException
     */
    public function index(Device $device): JsonResponse
    {
        return response()->json(WeatherOverview::get(preference($device)));
    }
}
