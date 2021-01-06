<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use App\Models\HostPreference;
use App\Models\TyphoonImage;
use App\Services\WFC\TyphoonDynamics;
use Illuminate\Http\JsonResponse;

class TyphoonDynamicsController extends Controller
{
    /**
     * 颱風動態
     *
     * @param $device_id
     * @return JsonResponse
     */
    public function index($device_id): JsonResponse
    {
        $device = Device::query()->find($device_id);
        $preference = $device->preference_json;

        $hostPreference = HostPreference::query()->firstOrCreate([
            'user_id' => $device->user_id,
            'device_id' => $device_id
        ]);

        $preference = array_merge($preference, $hostPreference->preference_json ?? []);

        $content = json_decode(TyphoonImage::query()->where('name', '颱風動態圖')->first()->content);

        return response()->json(TyphoonDynamics::get($content, $preference));
    }
}
