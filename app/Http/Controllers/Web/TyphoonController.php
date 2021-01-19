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
            case('typhoon-dynamics'):
                $typhoon->content = array_merge($typhoon->content, [
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
                $typhoon->content = array_merge($typhoon->content, [
                    'typhoon-potential' => [
                        'origin' => $data['typhoon-potential']['origin']
                    ],
                ]);
                break;
            case('wind-observation'):
                $typhoon->content = array_merge($typhoon->content, [
                    'wind-observation' => [
                        'origin' => $data['wind-observation']['origin']
                    ],
                ]);
                break;
            case('wind-forecast'):
                $typhoon->content = array_merge($typhoon->content, [
                    'wind-forecast' => [
                        'origin' => $data['wind-forecast']['origin']
                    ],
                ]);
                break;
            case('rainfall-observation'):
                $typhoon->content = array_merge($typhoon->content, [
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
                $typhoon->content = array_merge($typhoon->content, [
                    'all-rainfall' => [
                        'origin' => $data['all-rainfall']['origin'],
                        'alert_value' => $data['all-rainfall']['alert_value'],
                    ],
                    '24h-rainfall' => [
                        'origin' => $data['24h-rainfall']['origin'],
                        'alert_value' => $data['24h-rainfall']['alert_value'],
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
