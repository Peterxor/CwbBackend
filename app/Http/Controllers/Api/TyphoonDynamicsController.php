<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use App\Models\TyphoonImage;
use App\Services\WFC\Exceptions\WFCException;
use App\Services\WFC\TyphoonDynamics;
use Illuminate\Http\JsonResponse;

class TyphoonDynamicsController extends Controller
{
    /**
     * 颱風動態
     *
     * @param Device $device 裝置
     * @return JsonResponse
     * @throws WFCException
     */
    public function index(Device $device): JsonResponse
    {
        /** @var TyphoonImage $typhoonImage */
        $typhoonImage = TyphoonImage::query()->where('name', 'typhoon_dynamics')->first(['content']);

        return response()->json(TyphoonDynamics::get($typhoonImage->content, preference($device)));
    }
}
