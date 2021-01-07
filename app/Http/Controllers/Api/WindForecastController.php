<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\TyphoonImage;
use App\Services\WFC\Exceptions\WFCException;
use App\Services\WFC\WindForecast;
use Illuminate\Http\JsonResponse;

class WindForecastController extends Controller
{
    /**
     * 風力預測
     *
     * @param mixed $device_id 裝置ID
     * @return JsonResponse
     * @throws WFCException
     */
    public function index($device_id): JsonResponse
    {
        /** @var TyphoonImage $typhoonImage */
        $typhoonImage = TyphoonImage::query()->where('name', 'wind-forecast')->first(['content']);

        return response()->json(WindForecast::get($typhoonImage->content, preference($device_id)));
    }
}
