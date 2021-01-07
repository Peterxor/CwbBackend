<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use App\Models\TyphoonImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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

        return DataTables::eloquent($query)->setTransformer(function (TyphoonImage $item) {
            return [
                'id' => $item->id,
                'name' => $item->content['display_name'] ?? '',
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
        return view('backend.pages.typhoon.edit', ['data' => TyphoonImage::query()->find($id)]);
    }


    /**
     * 更新颱風預報圖資
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        /** @var TyphoonImage $image */
        $image = TyphoonImage::query()->find($id);

        $data = $request->all();

        switch ($image->name ?? '') {
            case('typhoon-dynamics'):
                $image->content = array_merge($image->content, [
                    'typhoon-dynamics' => [
                        'origin' => $data['typhoon-dynamics']['origin']
                    ],
                    'typhoon-ir' => [
                        'origin' => $data['typhoon-ir']['origin'],
                        'amount' => $data['typhoon-ir']['amount'],
                        'interval' => $data['typhoon-ir']['interval']
                    ],
                    'typhoon-mb' => [
                        'origin' => $data['typhoon-mb']['origin'],
                        'amount' => $data['typhoon-mb']['amount'],
                        'interval' => $data['typhoon-mb']['interval']
                    ],
                    'typhoon-vis' => [
                        'origin' => $data['typhoon-vis']['origin'],
                        'amount' => $data['typhoon-vis']['amount'],
                        'interval' => $data['typhoon-vis']['interval']
                    ]
                ]);
                break;
            case('typhoon-potential'):
                $image->content = array_merge($image->content, [
                    'typhoon-potential' => [
                        'origin' => $data['typhoon-potential']['origin']
                    ],
                ]);
                break;
            case('wind-observation'):
                $image->content = array_merge($image->content, [
                    'wind-observation' => [
                        'origin' => $data['wind-observation']['origin']
                    ],
                ]);
                break;
            case('wind-forecast'):
                $image->content = array_merge($image->content, [
                    'wind-forecast' => [
                        'origin' => $data['wind-forecast']['origin']
                    ],
                ]);
                break;
            case('rainfall-observation'):
                $image->content = array_merge($image->content, [
                    'amount' => $data['amount'],
                    'interval' => $data['interval'],
                    'today' => [
                        'status' => 1,
                        'data-origin' => $data['today']['data-origin'],
                        'image-origin' => $data['today']['image-origin']
                    ],
                    'before1nd' => [
                        'status' => $data['before1nd']['status'],
                        'data-origin' => $data['before1nd']['data-origin'],
                        'image-origin' => $data['before1nd']['image-origin']
                    ],
                    'before2nd' => [
                        'status' => $data['before2nd']['status'],
                        'data-origin' => $data['before2nd']['data-origin'],
                        'image-origin' => $data['before2nd']['image-origin']
                    ],
                    'before3nd' => [
                        'status' => $data['before3nd']['status'],
                        'data-origin' => $data['before3nd']['data-origin'],
                        'image-origin' => $data['before3nd']['image-origin']
                    ],
                    'before4nd' => [
                        'status' => $data['before4nd']['status'],
                        'data-origin' => $data['before4nd']['data-origin'],
                        'image-origin' => $data['before4nd']['image-origin']
                    ]
                ]);
                break;
            case('rainfall-forecast'):
                $image->content = array_merge($image->content, [
                    'all-rainfall' => [
                        'origin' => $data['all-rainfall']['origin'],
                        'alert_value' => $data['all-rainfall']['alert_value'],
                    ],
                    '24-rainfall' => [
                        'origin' => $data['24-rainfall']['origin'],
                        'alert_value' => $data['24-rainfall']['alert_value'],
                    ],
                ]);
                break;
            default:
        }
        $image->save();
        return redirect(route('typhoon.index'));
    }
}
