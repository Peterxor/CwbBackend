<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use App\Services\WFC\AnchorInformation;
use App\Services\WFC\Exceptions\WFCException;
use Illuminate\Http\JsonResponse;

class AnchorInformationController extends Controller
{
    /**
     * 主播圖卡
     *
     * @param Device $device 裝置
     * @return JsonResponse
     * @throws WFCException
     */
    public function index(Device $device): JsonResponse
    {
        return response()->json(AnchorInformation::get($device->typhoon_json, preference($device)));
    }
}
