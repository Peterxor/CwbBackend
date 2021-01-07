<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use App\Models\TyphoonImage;
use App\Services\WFC\Exceptions\WFCException;
use App\Services\WFC\TyphoonPotential;
use Illuminate\Http\JsonResponse;

class TyphoonPotentialController extends Controller
{
    /**
     * 颱風潛勢
     *
     * @param Device $device 裝置
     * @return JsonResponse
     * @throws WFCException
     */
    public function index(Device $device): JsonResponse
    {
        /** @var TyphoonImage $typhoonImage */
        $typhoonImage = TyphoonImage::query()->where('name', 'typhoon-potential')->first(['content']);

        return response()->json(TyphoonPotential::get($typhoonImage->content, preference($device)));
    }
}
