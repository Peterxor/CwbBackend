<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use App\Services\WFC\Dashboard;
use App\Services\WFC\Exceptions\WFCException;
use Illuminate\Http\JsonResponse;
use App\Models\Board;

class DashboardController extends Controller
{
    /**
     * 一般天氣預報資料
     *
     * @param Device $device 裝置
     * @return JsonResponse
     * @throws WFCException
     */
    public function index(Device $device): JsonResponse
    {
        $board = Board::query()->with(['media', 'personnel_a', 'personnel_b'])->where('device_id', $device->id)->first()->toArray();
        $theme_urls = $device->theme_url ?? [];
        $board['themes'] = $theme_urls;
        return response()->json(Dashboard::get($board, preference($device)));
    }
}
