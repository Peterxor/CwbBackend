<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\JsonResponse;

class WFCDataController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data = [
            'meta' => [],
            'typhoon' => [
                'information' => [],
                'typhoon-dynamics' => [],
                'typhoon-potential' => [],
                'wind-observation' => [],
                'wind-forecast' => [],
                'rainfall-observation' => [],
                'rainfall-forecast' => [],
            ],
            'weather' => [
                'information' => [
                    'scale' => 100,
                    "point" => [0, 0],
                    'data' => [
                        [
                            'mode' => 'gif',
                            'scale' => 150,
                            'point' => [0, 0],
                            'interval' => 2000,
                            'title' => "東亞VIS",
                            'description' => '11/30 11:50 ~ 11/30 12:00',
                            'images' => [
                                url('test/2020-11-10_1510.BVIS.jpg'),
                                url('test/2020-11-10_1520.BVIS.jpg'),
                                url('test/2020-11-10_1530.BVIS.jpg'),
                            ],
                            'thumbnail' => url('test/2020-11-10_1530.BVIS.jpg')
                        ], [
                            'mode' => 'abreast',
                            'scale' => 100,
                            'point' => [0, 0],
                            'title' => "雨量",
                            'description' => '11/30 11:50 ~ 11/30 12:00',
                            'image_l' => url('test/2020-11-08_0540.QZJ4.png'),
                            'image_r' => url('test/2020-11-10_1050.QZJ4.png'),
                            'thumbnail' => url('test/2020-11-10_1050.QZJ4.png')
                        ], [
                            'mode' => 'list',
                            'scale' => 100,
                            'point' => [20, 20],
                            'title' => "地面天氣圖",
                            'description' => '11/30 11:50 ~ 11/30 12:00',
                            'images' => [
                                url('test/2020-1110-0000_SFCcomboHD.jpg'),
                                url('test/2020-1109-1800_SFCcomboHD.jpg'),
                                url('test/2020-1109-0000_SFCcomboHD.jpg'),
                                url('test/2020-1108-1800_SFCcomboHD.jpg'),
                            ],
                            'thumbnail' => url('test/2020-1110-0000_SFCcomboHD.jpg')
                        ], [
                            'mode' => 'single',
                            'scale' => 100,
                            "point" => [0, 50],
                            "title" => "紫外線",
                            'description' => '11/30 11:50 ~ 11/30 12:00',
                            'image' => url('test/UVI_Max.png'),
                            'thumbnail' => url('test/UVI_Max.png')
                        ], [
                            'mode' => 'custom',
                            'scale' => 100,
                            "point" => [0, 0],
                            "title" => "小叮嚀",
                            'description' => '',
                            'image' => url('test/天氣警報.png'),
                            'thumbnail' => url('test/天氣警報.png')
                        ],
                    ]
                ]
            ]
        ];
        return response()->json($data);
    }
}
