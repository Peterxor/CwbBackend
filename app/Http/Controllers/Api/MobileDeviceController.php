<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Models\TyphoonImage;
use App\Models\GeneralImages;
use App\Events\MobileActionEvent;

class MobileDeviceController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $stationObs = simplexml_load_file(storage_path('data/wind/obs/WindObs.xml'));

        $data = [
            'startTime' => (string)$stationObs->dataset->datasetInfo->validTime->startTime,
            'endTime' => (string)$stationObs->dataset->datasetInfo->validTime->endTime,
        ];

        $location = [];
        foreach ($stationObs->dataset->location ?? [] as $loc) {
            $location[(string)$loc->locationName] = [
                "wind" => (string)$loc->weatherElement[1]->time->parameter[2]->parameterValue,
                "gust" => (string)$loc->weatherElement[2]->time->parameter[2]->parameterValue,
            ];
        }

        $data['location'] = $location;

        return response()->json($data);
    }


    public function deviceList()
    {
        $devices = Device::get();
        $devices = $devices->toArray();
        $data = [];
        foreach ($devices as $device) {
            $data[] = [
                'device_id' => $device['id'],
                'device_name' => $device['name']
            ];
        }
        return response()->json($data);
    }

    public function getDeviceData(Request $request)
    {
        $id = $request->id;
        $typhoonImgs = TyphoonImage::get();
        $generalImgs = GeneralImages::get();
//        dd($generalImgs->toArray());


        $device = Device::with(['user'])->where('id', $id)->first();
        $res = [
            'room' => $device->name,
            'anchor' => $device->user->name ?? '',
            'typhoon' => [],
            'weather' => [],
        ];

        foreach ($typhoonImgs as $img) {
            $res['typhoon'][] = [
                'name' => $img->name,
                'value' => $this->findValue($img->name),
                'pic_url' => Storage::disk('public')->url('wind_1.jpg'),
                'behavior' => $this->makeBehavior($img->name)
            ];
        }

        foreach ($generalImgs as $img) {
            $res['weather'][] = [
                'name' => $img->name,
                'value' => $this->findValue($img->name),
                'pic_url' => Storage::disk('public')->url('wind_1.jpg'),
            ];
        }

        return response()->json($res);
    }

    public function action(Request $request)
    {
        $screen = $request->screen;
        $behaviour = $request->behaviour;
        $res['success'] = true;
        $res['data'] = $request->all();
        broadcast(new MobileActionEvent($screen, $behaviour));
        return response()->json($res);

    }


    public function makeBehavior($name)
    {
        $default = [
            [
                'name' => '畫筆',
                'value' => 'draw_toggle'
            ],
            [
                'name' => '上一步',
                'value' => 'back'
            ],
            [
                'name' => '清空',
                'value' => 'clear',
            ],
            [
                'name' => 'H',
                'value' => 'high_pressure'
            ],
            [
                'name' => 'L',
                'value' => 'low_pressure'
            ],
            [
                'name' => '颱風',
                'value' => 'typhoon',
            ],
            [
                'name' => '季風',
                'value' => 'monsoon'
            ],
            [
                'name' => '冷鋒',
                'value' => 'cold_front'
            ],
            [
                'name' => '軟鋒',
                'value' => 'warm_front',
            ],
            [
                'name' => '滯留鋒',
                'value' => 'strand_front',
            ],
            [
                'name' => '上一步',
                'value' => 'back'
            ],
        ];
        $map = [
            '颱風動態圖' => [
                [
                    'name' => '畫筆',
                    'value' => 'draw_toggle'
                ],
                [
                    'name' => '上一步',
                    'value' => 'back'
                ],
                [
                    'name' => '清空',
                    'value' => 'clear',
                ],
                [
                    'name' => 'ORG',
                    'value' => 'org',
                ],
                [
                    'name' => 'IR',
                    'value' => 'ir',
                ],
                [
                    'name' => 'MB',
                    'value' => 'mb',
                ],
                [
                    'name' => 'VIS',
                    'value' => 'vis',
                ],
                [
                    'name' => '海',
                    'value' => 'sea'
                ],
                [
                    'name' => '陸',
                    'value' => 'land'
                ],
            ],
            '颱風潛勢圖' => [
                [
                    'name' => '畫筆',
                    'value' => 'draw_toggle'
                ],
                [
                    'name' => '上一步',
                    'value' => 'back'
                ],
                [
                    'name' => '清空',
                    'value' => 'clear',
                ]
            ],
            '風力觀測' => [
                [
                    'name' => '全',
                    'value' => 'total',
                ],
                [
                    'name' => '北',
                    'value' => 'north',
                ],
                [
                    'name' => '中',
                    'value' => 'center',
                ],
                [
                    'name' => '南',
                    'value' => 'south',
                ],
                [
                    'name' => '東',
                    'value' => 'east'
                ],
                [
                    'name' => '畫筆',
                    'value' => 'draw_toggle'
                ],
                [
                    'name' => '上一步',
                    'value' => 'back'
                ],
                [
                    'name' => '清空',
                    'value' => 'clear',
                ]
            ],
            '風力預測' => [
                [
                    'name' => '畫筆',
                    'value' => 'draw_toggle'
                ],
                [
                    'name' => '上一步',
                    'value' => 'back'
                ],
                [
                    'name' => '清空',
                    'value' => 'clear',
                ],
                [
                    'name' => '全',
                    'value' => 'total',
                ],
                [
                    'name' => '北',
                    'value' => 'north',
                ],
                [
                    'name' => '中',
                    'value' => 'center',
                ],
                [
                    'name' => '南',
                    'value' => 'south',
                ],
                [
                    'name' => '東',
                    'value' => 'east'
                ],
                [
                    'name' => '1',
                    'value' => 0
                ],
                [
                    'name' => '2',
                    'value' => 1,
                ],
                [
                    'name' => '3',
                    'value' => 2
                ]

            ],
            '雨量觀測' => [
                [
                    'name' => '畫筆',
                    'value' => 'draw_toggle'
                ],
                [
                    'name' => '上一步',
                    'value' => 'back'
                ],
                [
                    'name' => '清空',
                    'value' => 'clear',
                ],
                [
                    'name' => '全',
                    'value' => 'total',
                ],
                [
                    'name' => '北',
                    'value' => 'north',
                ],
                [
                    'name' => '中',
                    'value' => 'center',
                ],
                [
                    'name' => '南',
                    'value' => 'south',
                ],
                [
                    'name' => '宜',
                    'value' => 'yilan',
                ],
                [
                    'name' => '花',
                    'value' => 'flower'
                ],
                [
                    'name' => '東',
                    'value' => 'east'
                ],
                [
                    'name' => '今',
                    'value' => 'today',
                ],
                [
                    'name' => '1',
                    'value' => 0
                ],
                [
                    'name' => '2',
                    'value' => 1,
                ],
                [
                    'name' => '3',
                    'value' => 2
                ],
                [
                    'name' => '表',
                    'value' => 'surface'
                ]

            ],
            '雨量預測' => [
                [
                    'name' => '畫筆',
                    'value' => 'draw_toggle'
                ],
                [
                    'name' => '上一步',
                    'value' => 'back'
                ],
                [
                    'name' => '清空',
                    'value' => 'clear',
                ],
                [
                    'name' => '全',
                    'value' => 'total',
                ],
                [
                    'name' => '北',
                    'value' => 'north',
                ],
                [
                    'name' => '中',
                    'value' => 'center',
                ],
                [
                    'name' => '南',
                    'value' => 'south',
                ],
                [
                    'name' => '宜',
                    'value' => 'yilan',
                ],
                [
                    'name' => '花',
                    'value' => 'flower'
                ],
                [
                    'name' => '東',
                    'value' => 'east'
                ],
                [
                    'name' => 'all',
                    'value' => 'all',
                ],
                [
                    'name' => '24',
                    'value' => 24
                ],
            ],
        ];
        return $map[$name] ?? $default;
    }

    public function findValue($name)
    {
        $map = [
            '颱風動態圖' => 'typhoon_story',
            '颱風潛勢圖' => 'typhoon_potential',
            '風力觀測' => 'wind_observe',
            '風力預測' => 'wind_forecast',
            '雨量觀測' => 'rain_observe',
            '雨量預測' => 'rain_forecast',
            "東亞VIS" => 'east_asia_vis',
            '東亞MB' => 'east_asia_mb',
            '東亞IR' => 'east_asia_ir',
            '地面天氣圖' => 'ground_weather',
            '全球IR' => 'global_ir',
            '紫外線' => 'ultraviolet',
            '雷達回波' => 'radar_back',
            '溫度' => 'temperature',
            '雨量' => 'rain_amount',
            '數值預報' => 'value_forecast',
            '定量降水預報12小時' => 'rain_12',
            '定量降水預報6小時' => 'rain_6',
            '24H預測' => '24h_forecast',
            '天氣預測' => 'weather_forecast',
            '波浪分析圖' => 'wave_analyze',
            '天氣警報' => 'weather_alert',
        ];
        return $map[$name] ?? '';
    }
}
