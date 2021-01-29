<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use App\Models\TyphoonImage;
use App\Services\WFC\Exceptions\WFCException;
use App\Services\WFC\WindObservation;
use Illuminate\Http\JsonResponse;

class WindObservationController extends Controller
{
    /**
     * 風力觀測
     *
     * @param Device $device 裝置
     * @return JsonResponse
     * @throws WFCException
     */
    public function index(Device $device): JsonResponse
    {
        /** @var TyphoonImage $typhoonImage */
        $typhoonImage = TyphoonImage::query()->where('name', 'wind_observation')->first(['content']);

        return response()->json(WindObservation::get($typhoonImage->content, preference($device)));
    }
}
