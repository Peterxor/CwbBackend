<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use App\Models\TyphoonImage;
use App\Services\WFC\Exceptions\WFCException;
use App\Services\WFC\WindForecast;
use Illuminate\Http\JsonResponse;

class WindForecastController extends Controller
{
    /**
     * 風力預測
     *
     * @param Device $device 裝置
     * @return JsonResponse
     * @throws WFCException
     */
    public function index(Device $device): JsonResponse
    {
        /** @var TyphoonImage $typhoonImage */
        $typhoonImage = TyphoonImage::query()->where('name', 'wind_forecast')->first(['content']);

        return response()->json(WindForecast::get($typhoonImage->content, preference($device)));
    }
}
