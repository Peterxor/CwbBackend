<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use App\Models\TyphoonImage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class TyphoonController extends Controller
{
    public function index()
    {
        return view("backend.pages.typhoon.index");
    }

    public function query()
    {
        $query = TyphoonImage::orderBy('sort');
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'sort' => $item->sort,
            ];
        })->toJson();
    }

    public function updateOrder()
    {

    }

    public function edit(Request $request, $id)
    {
        $data = TyphoonImage::find($id);
        $json = json_decode($data->content);
        $type = $json->type;

        return view('backend.pages.typhoon.edit', compact('json', 'type', 'data'));
    }


    public function update(Request $request, $id)
    {
        $json = $this->makeJson($request->all());
        $image = TyphoonImage::find($id);
        $image->content = $json;
        $image->save();
        return redirect(route('typhoon.index'));
    }


    public function makeJson($data)
    {
        $temp = [];
        switch ($data['type']) {
            case '1':
                $temp = [
                    'type' => 1,
                    'info' => [
                        'origin' => $data['info-origin'],
                        'move_pages' => $data['info-move_pages'],
                        'change_rate_second' => $data['info-change_rate_second'],
                    ],
                    'show_info' => [
                        'ir' => [
                            'origin' => $data['ir-origin'],
                            'move_pages' => $data['ir-move_pages'],
                            'change_rate_page' => $data['ir-change_rate_page'],
                        ],
                        'mb' => [
                            'origin' => $data['mb-origin'],
                            'move_pages' => $data['mb-move_pages'],
                            'change_rate_page' => $data['mb-change_rate_page'],
                        ],
                        'vis' => [
                            'origin' => $data['vis-origin'],
                            'move_pages' => $data['vis-move_pages'],
                            'change_rate_page' => $data['vis-change_rate_page'],
                        ]
                    ]
                ];
                break;
            case '2':
                $temp = [
                    'type' => 2,
                    'info' => [
                        'origin' => $data['info-origin'],
                        'move_pages' => $data['info-move_pages'],
                        'change_rate_second' => $data['info-change_rate_second'],
                    ]
                ];
                break;
            case '3':
                $temp = [
                    'type' => 3,
                    'info' => [
                        'origin' => $data['info-origin'],
                    ]
                ];
                break;
            case '4':
                $temp = [
                    'type' => 4,
                    'info' => [
                        'origin' => $data['info-origin'],
                    ]
                ];
                break;
            case '5':
                $temp = [
                    'type' => 5,
                    'info' => [
                        'origin_word' => $data['info-origin_word'],
                        'origin_pic' => $data['info-origin_pic'],
                        'move_pages' => $data['info-origin_pic'],
                        'change_rate_second' => $data['info-change_rate_second'],
                    ],
                    'timezone_rain' => [
                        'one_day_before' => [
                            'status' => $data['time_one_status'], // 1: 啟用 2: 停用
                            'word' => $data['time_one_word'],
                            'pic' => $data['time_one_pic'],
                        ],
                        'two_day_before' => [
                            'status' => $data['time_two_status'], // 1: 啟用 2: 停用
                            'word' => $data['time_two_word'],
                            'pic' => $data['time_two_pic'],
                        ],
                        'three_day_before' => [
                            'status' => $data['time_three_status'], // 1: 啟用 2: 停用
                            'word' => $data['time_three_word'],
                            'pic' => $data['time_three_pic'],
                        ],
                        'four_day_before' => [
                            'status' => $data['time_four_status'], // 1: 啟用 2: 停用
                            'word' => $data['time_four_word'],
                            'pic' => $data['time_four_pic'],
                        ]
                    ],
                    'location_rain' => [
                        'one_day_before' => [
                            'status' => $data['location_one_status'], // 1: 啟用 2: 停用
                            'word' => $data['location_one_word'],
                        ],
                        'two_day_before' => [
                            'status' => $data['location_two_status'], // 1: 啟用 2: 停用
                            'word' => $data['location_two_word'],
                        ],
                        'three_day_before' => [
                            'status' => $data['location_three_status'], // 1: 啟用 2: 停用
                            'word' => $data['location_three_word'],
                        ],
                        'four_day_before' => [
                            'status' => $data['location_four_status'], // 1: 啟用 2: 停用
                            'word' => $data['location_four_word'],
                        ]
                    ]
                ];
                break;
            case '6':
                $temp = [
                    'type' => 6,
                    'info' => [
                        'origin' => $data['info-origin'],
                        'alert_value' => $data['info-alert_value'],
                        'origin24' => $data['info-origin24'],
                        'alert_value_24' => $data['info-alert_value_24'],
                    ]
                ];
                break;
        }
        return json_encode($temp);
    }
}
