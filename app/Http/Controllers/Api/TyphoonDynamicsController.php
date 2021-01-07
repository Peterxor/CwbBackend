<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\TyphoonImage;
use App\Services\WFC\Exceptions\WFCException;
use App\Services\WFC\TyphoonDynamics;
use Illuminate\Http\JsonResponse;

class TyphoonDynamicsController extends Controller
{
    /**
     * 颱風動態
     *
     * @param mixed $device_id 裝置ID
     * @return JsonResponse
     * @throws WFCException
     */
    public function index($device_id): JsonResponse
    {
        /** @var TyphoonImage $typhoonImage */
        $typhoonImage = TyphoonImage::query()->where('name', 'typhoon-dynamics')->first(['content']);

        return response()->json(TyphoonDynamics::get($typhoonImage->content, preference($device_id)));
    }
}
