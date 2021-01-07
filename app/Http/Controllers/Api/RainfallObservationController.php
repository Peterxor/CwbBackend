<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use App\Models\TyphoonImage;
use App\Services\WFC\Exceptions\WFCException;
use App\Services\WFC\RainfallObservation;
use Illuminate\Http\JsonResponse;

class RainfallObservationController extends Controller
{
    /**
     * 雨量觀測
     *
     * @param Device $device 裝置
     * @return JsonResponse
     * @throws WFCException
     */
    public function index(Device $device): JsonResponse
    {
        /** @var TyphoonImage $typhoonImage */
        $typhoonImage = TyphoonImage::query()->where('name', 'rainfall-observation')->first(['content']);

        return response()->json(RainfallObservation::get($typhoonImage->content, preference($device)));
    }
}
