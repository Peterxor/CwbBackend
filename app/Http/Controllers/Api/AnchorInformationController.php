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
        $hostPreference = $device->hostPreference()->where('user_id', $device->user_id)->first();
        $typhoon_json = $hostPreference->typhoon_json ?? $device->typhoon_json;
        return response()->json(AnchorInformation::get($typhoon_json, preference($device)));
    }
}
