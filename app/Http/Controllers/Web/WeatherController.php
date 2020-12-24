<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use App\Models\GeneralImages;
use App\Models\GeneralImagesCategory;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    public function index()
    {
        // todo https://pl70hd.axshare.com/#id=6fribl&p=e_1_%E4%B8%BB%E6%92%AD%E5%88%97%E8%A1%A8&g=1
        return view("backend.pages.weather.index");
    }


    public function query()
    {

        $generals = GeneralIMages::with(['category'])->orderBy('sort');
//        dd($generals->get()->toArray());
        return DataTables::eloquent($generals)->setTransformer(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'sort' => $item->sort,
                'category' => $item->category->name ?? '',
            ];
        })->toJson();
    }

    public function queryCategory()
    {
        $generals = GeneralImagesCategory::orderBy('sort');

        return DataTables::eloquent($generals)->setTransformer(function ($item) {
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
        $general = GeneralIMages::with(['category'])->where('id', $id)->first();
        $categorys = GeneralImagesCategory::pluck('name', 'id')->toArray();
        $json = json_decode($general->content ?? '');
//        dd($general->toArray());
//        dd($categorys);

//        dd($json);

        return view('backend.pages.weather.edit', compact('general', 'categorys', 'json'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->all();
        try {
            if (count($data['name'] ?? []) > 0) {
                DB::beginTransaction();
                $insertData = [];
                foreach ($data['name'] as $index => $value) {
                    GeneralImagesCategory::updateOrCreate(['name' => $value], ['sort' => $index]);
                }
                GeneralImagesCategory::whereNotIn('name', $data['name'])->delete();
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return $this->sendError($e->getMessage(), []);
        }
        return $this->sendResponse('', 'ok');
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $json = $this->weatherJson($data['display_type'], $data);
        $image = GeneralImages::where('id', $id)->first();
        $image->name = $request->name;
        $image->category_id = $request->category;
        $image->content = $json;
        $image->save();
        return redirect(route('weather.index'));

    }

    public function destroy()
    {

    }


    public function weatherJson($type, $data)
    {
        $temp = [];
        $temp['type'] = $type;
        switch ($type) {
            case 1:
            case 4:
                $temp['data_origin'] = $data['data_origin'] ?? '';
                break;
            case 2:
                $temp['data_left'] = $data['data_left'] ?? '';
                $temp['data_right'] = $data['data_right'] ?? '';
                break;
            case 3:
                $temp['data_origin'] = $data['data_origin'] ?? '';
                $temp['move_pic_number'] = $data['move_pic_number'] ?? '';
                $temp['pic_change_rate'] = $data['pic_change_rate'] ?? '';
                break;
        }
        return json_encode($temp);
    }
}
