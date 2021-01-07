<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\TyphoonImage;
use App\Services\WFC\Exceptions\WFCException;
use App\Services\WFC\RainfallForecast;
use Illuminate\Http\JsonResponse;

class RainfallForecastController extends Controller
{
    /**
     * 雨量觀測
     *
     * @param mixed $device_id 裝置ID
     * @return JsonResponse
     * @throws WFCException
     */
    public function index($device_id): JsonResponse
    {
        /** @var TyphoonImage $typhoonImage */
        $typhoonImage = TyphoonImage::query()->where('name', 'rainfall-forecast')->first(['content']);

        return response()->json(RainfallForecast::get($typhoonImage->content, preference($device_id)));
    }
}
