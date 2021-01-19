<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use App\Models\GeneralImages;
use App\Models\GeneralImagesCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    /**
     * 一般天氣預報圖資管理
     * @return View
     */
    public function index(): View
    {
        if (!hasPermission('view_weather')) {
            abort(403);
        }
        return view("backend.pages.weather.index");
    }


    /**
     * 查詢一般天氣預報圖資
     *
     * @return JsonResponse
     */
    public function query(): JsonResponse
    {
        $generals = GeneralImages::with(['category'])->orderBy('sort');
        return DataTables::eloquent($generals)->setTransformer(function (GeneralImages $item) {
            return [
                'id' => $item->id,
                'name' => $item->content['display_name'] ?? '',
                'sort' => $item->sort,
                'category' => $item->category->name ?? '',
            ];
        })->toJson();
    }

    /**
     * 查詢一般天氣預報圖資分類
     *
     * @return JsonResponse
     */
    public function queryCategory(): JsonResponse
    {
        $generals = GeneralImagesCategory::query()->orderBy('sort');

        return DataTables::eloquent($generals)->setTransformer(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'sort' => $item->sort,
            ];
        })->toJson();
    }

    /**
     * 編輯一般天氣預報圖資分類
     *
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        if (!hasPermission('edit_weather')) {
            abort(403);
        }
        /** @var GeneralImages $general */
        $general = GeneralImages::with(['category'])->where('id', $id)->first();
        $categorys = GeneralImagesCategory::query()->pluck('name', 'id')->toArray();
        $json = $general->content;

        $type = weatherType($general->name ?? '');

        return view('backend.pages.weather.edit', compact('type', 'general', 'categorys', 'json'));
    }

    /**
     * 儲存一般天氣預報圖資分類
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeCategory(Request $request): JsonResponse
    {
        $data = $request->all();
        try {
            if (count($data['name'] ?? []) > 0) {
                DB::beginTransaction();
                foreach ($data['name'] as $index => $value) {
                    GeneralImagesCategory::query()->updateOrCreate(['name' => $value], ['sort' => $index]);
                }
                GeneralImagesCategory::query()->whereNotIn('name', $data['name'])->delete();
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return $this->sendError($e->getMessage(), []);
        }
        return $this->sendResponse('', 'ok');
    }

    /**
     * 更新一般天氣預報圖資
     *
     * @param Request $request
     * @param GeneralImages $weather
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, GeneralImages $weather)
    {
        if (!hasPermission('edit_weather')) {
            abort(403);
        }
        $data = $request->all();

        $weather->content = ['display_name' => $data['display_name']];

        $type = weatherType($weather->name ?? '');

        switch ($type) {
            case 1:
            case 3:
                $weather->content = array_merge($weather->content, [
                    'origin' => $data['origin'],
                ]);
                break;
            case 4:
                $weather->content = array_merge($weather->content, [
                    'origin_left' => $data['origin_left'],
                    'origin_right' => $data['origin_right'],
                ]);
                break;
            case 2:
                $weather->content = array_merge($weather->content, [
                    'origin' => $data['origin'],
                    'amount' => $data['amount'],
                    'interval' => $data['interval'],
                ]);
                break;
        }

        $weather->category_id = $request->get('category');
        $weather->save();
        return redirect(route('weather.index'));
    }

    // 一般天氣列表排序
    public function upper()
    {
        $id = request()->get('id', false);
        $data = GeneralIMages::find($id);
        $old_data = GeneralIMages::where('sort', '<', $data->sort)->orderBy('sort', 'desc')->limit(1)->first();

        if (empty($old_data)) {
            return response()->json(['success' => false, 'message' => '此為第一筆資料']);
        }

        $old_data->sort = $data->sort;
        $old_data->save();

        $data->sort = (int)$data->sort - 1;
        $data->save();

        return response()->json(['success' => true]);
    }

    public function lower()
    {
        $id = request()->get('id', false);
        $data = GeneralIMages::find($id);
        $old_data = GeneralIMages::where('sort', '>', $data->sort)->orderBy('sort', 'asc')->limit(1)->first();

        if (empty($old_data)) {
            return response()->json(['success' => false, 'message' => '此為最後一筆資料']);
        }

        $old_data->sort = $data->sort;
        $old_data->save();

        $data->sort = (int)$data->sort + 1;
        $data->save();

        return response()->json(['success' => true]);
    }
}
