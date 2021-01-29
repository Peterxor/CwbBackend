<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use App\Models\TyphoonImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
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
        if (!hasPermission('view_typhoon')) {
            abort(403);
        }
        return view("backend.pages.typhoon.index");
    }

    /**
     * 查詢颱風預報圖資
     *
     * @return JsonResponse
     */
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
        $item = '更新颱風預報圖資升序[' . ($data1->content['display_name'] ?? '') . ']';
        activity()
            ->performedOn($data1)
            ->causedBy(Auth::user()->id)
            ->withProperties([
                'ip' => request()->getClientIp(),
                'item' => $item,
            ])
            ->log('修改');

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
        $item = '更新颱風預報圖資降序[' . ($data1->content['display_name'] ?? '') . ']';
        activity()
            ->performedOn($data1)
            ->causedBy(Auth::user()->id)
            ->withProperties([
                'ip' => request()->getClientIp(),
                'item' => $item,
            ])
            ->log('修改');

        return response()->json(['success' => true]);
    }

    /**
     * 編輯颱風預報圖資
     *
     * @param TyphoonImage $typhoon
     * @return View
     */
    public function edit(TyphoonImage $typhoon): View
    {
        if (!hasPermission('edit_typhoon')) {
            abort(403);
        }
        return view('backend.pages.typhoon.edit', ['data' => $typhoon]);
    }


    /**
     * 更新颱風預報圖資
     *
     * @param Request $request
     * @param TyphoonImage $typhoon
     * @return RedirectResponse
     */
    public function update(Request $request, TyphoonImage $typhoon): RedirectResponse
    {
        if (!hasPermission('edit_typhoon')) {
            abort(403);
        }
        $data = $request->all();

        switch ($typhoon->name ?? '') {
            case('typhoon_dynamics'):
                $typhoon->content = array_merge($typhoon->content, [
                    'typhoon_dynamics' => [
                        'origin' => $data['typhoon_dynamics']['origin']
                    ],
                    'typhoon_ir' => [
                        'origin' => $data['typhoon_ir']['origin'],
                        'amount' => $data['typhoon_ir']['amount'],
                        'interval' => $data['typhoon_ir']['interval']
                    ],
                    'typhoon_mb' => [
                        'origin' => $data['typhoon_mb']['origin'],
                        'amount' => $data['typhoon_mb']['amount'],
                        'interval' => $data['typhoon_mb']['interval']
                    ],
                    'typhoon_vis' => [
                        'origin' => $data['typhoon_vis']['origin'],
                        'amount' => $data['typhoon_vis']['amount'],
                        'interval' => $data['typhoon_vis']['interval']
                    ]
                ]);
                break;
            case('typhoon_potential'):
                $typhoon->content = array_merge($typhoon->content, [
                    'typhoon_potential' => [
                        'origin' => $data['typhoon_potential']['origin']
                    ],
                ]);
                break;
            case('wind_observation'):
                $typhoon->content = array_merge($typhoon->content, [
                    'wind_observation' => [
                        'origin' => $data['wind_observation']['origin']
                    ],
                ]);
                break;
            case('wind_forecast'):
                $typhoon->content = array_merge($typhoon->content, [
                    'wind_forecast' => [
                        'origin' => $data['wind_forecast']['origin']
                    ],
                ]);
                break;
            case('rainfall_observation'):
                $typhoon->content = array_merge($typhoon->content, [
                    'amount' => $data['amount'],
                    'interval' => $data['interval'],
                    'today' => [
                        'status' => 1,
                        'data_origin' => $data['today']['data_origin'],
                        'image_origin' => $data['today']['image_origin']
                    ],
                    'before1nd' => [
                        'status' => $data['before1nd']['status'],
                        'data_origin' => $data['before1nd']['data_origin'],
                        'image_origin' => $data['before1nd']['image_origin']
                    ],
                    'before2nd' => [
                        'status' => $data['before2nd']['status'],
                        'data_origin' => $data['before2nd']['data_origin'],
                        'image_origin' => $data['before2nd']['image_origin']
                    ],
                    'before3nd' => [
                        'status' => $data['before3nd']['status'],
                        'data_origin' => $data['before3nd']['data_origin'],
                        'image_origin' => $data['before3nd']['image_origin']
                    ],
                    'before4nd' => [
                        'status' => $data['before4nd']['status'],
                        'data_origin' => $data['before4nd']['data_origin'],
                        'image_origin' => $data['before4nd']['image_origin']
                    ]
                ]);
                break;
            case('rainfall_forecast'):
                $typhoon->content = array_merge($typhoon->content, [
                    'all_rainfall' => [
                        'origin' => $data['all_rainfall']['origin'],
                        'alert_value' => $data['all_rainfall']['alert_value'],
                    ],
                    '24h-rainfall' => [
                        'origin' => $data['24h_rainfall']['origin'],
                        'alert_value' => $data['24h_rainfall']['alert_value'],
                    ],
                ]);
                break;
            default:
        }
        $typhoon->save();
        $item = '更新颱風預報圖資[' . ($typhoon->content['display_name'] ?? '') . ']';
        activity()
            ->performedOn($typhoon)
            ->causedBy(Auth::user()->id)
            ->withProperties([
                'ip' => $request->getClientIp(),
                'item' => $item,
            ])
            ->log('修改');
        return redirect(route('typhoon.index'));
    }
}
