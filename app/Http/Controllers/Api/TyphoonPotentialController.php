<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\TyphoonImage;
use App\Services\WFC\Exceptions\WFCException;
use App\Services\WFC\TyphoonPotential;
use Illuminate\Http\JsonResponse;

class TyphoonPotentialController extends Controller
{
    /**
     * 颱風潛勢
     *
     * @param mixed $device_id 裝置ID
     * @return JsonResponse
     * @throws WFCException
     */
    public function index($device_id): JsonResponse
    {
        /** @var TyphoonImage $typhoonImage */
        $typhoonImage = TyphoonImage::query()->where('name', 'typhoon-potential')->first(['content']);

        return response()->json(TyphoonPotential::get($typhoonImage->content, preference($device_id)));
    }
}
