<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use App\Models\TyphoonImage;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class TyphoonController extends Controller
{
    /**
     * 颱風預報圖資管理
     *
     * @return View
     */
    public function index(): View
    {
        return view("backend.pages.typhoon.index");
    }

    public function query(): JsonResponse
    {
        $query = TyphoonImage::query()->orderBy('sort');

        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'sort' => $item->sort,
            ];
        })->toJson();
    }

    /**
     * 排序位置向上
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function upper(Request $request): JsonResponse
    {
        /**
         * @var TyphoonImage $data1
         * @var TyphoonImage $data2
         */
        $id = $request->get('id', false);
        $data1 = TyphoonImage::query()->find($id);
        $data2 = TyphoonImage::query()->where('sort', '<', $data1->sort)->orderBy('sort', 'desc')->first();

        if (empty($data2))
            return response()->json(['success' => false, 'message' => '此為第一筆資料']);

        $tmp_sort = $data2->sort;
        $data2->sort = $data1->sort;
        $data1->sort = $tmp_sort;
        $data1->save();
        $data2->save();

        return response()->json(['success' => true]);
    }

    /**
     * 排序位置向下
     *
     * @return JsonResponse
     */
    public function lower(): JsonResponse
    {
        /**
         * @var TyphoonImage $data1
         * @var TyphoonImage $data2
         */
        $id = request()->get('id', false);
        $data1 = TyphoonImage::query()->find($id);
        $data2 = TyphoonImage::query()->where('sort', '>', $data1->sort)->orderBy('sort')->first();

        if (empty($data2)) {
            return response()->json(['success' => false, 'message' => '此為最後一筆資料']);
        }

        $tmp_sort = $data2->sort;
        $data2->sort = $data1->sort;
        $data1->sort = $tmp_sort;
        $data1->save();
        $data2->save();

        return response()->json(['success' => true]);
    }

    /**
     * 編輯颱風預報圖資
     *
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        /** @var TyphoonImage $data */
        $data = TyphoonImage::query()->find($id);
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
                        'origin' => $data['info-origin']
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
                        'origin' => $data['info-origin']
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
                        'move_pages' => $data['info-move_pages'],
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
