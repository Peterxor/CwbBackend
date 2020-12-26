<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\JsonResponse;

class AnchorInformationController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {

        return response()->json([
            [
                'title' => '雷達波紋',
                'image' => url('test/preci_radar.png')
            ],
            [
                'title' => '天氣雲圖',
                'image' => url('test/sat_weather_IR.gif')
            ],
            [
                'title' => '氣壓圖',
                'image' => url('test/2020-1108-1200_A012HD.png')
            ],
            [
                'title' => '小叮嚀',
                'image' => url('test/note.png')
            ],
        ]);
    }
}
