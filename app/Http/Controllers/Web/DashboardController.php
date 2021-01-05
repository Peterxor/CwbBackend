<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\TyphoonImage;
use App\Models\GeneralImages;

class DashboardController extends Controller
{
    public function index()
    {
        $devices = Device::with(['user'])->get();
        $themes = getTheme(0);

        return view("backend.pages.dashboard.index", compact('devices', 'themes'));
    }


    public function edit(Request $request, $id)
    {
        $pic_type = $request->pic_type ?? 'typhoon';
        $query = Device::where('id', $id)->first();
        $data = $pic_type === 'typhoon' ? $query->typhoon_json : $query->forecast_json;
        $images = GeneralImages::get();
        $data = json_decode($data);
        $loop_times = 9;

        return view('backend.pages.dashboard.edit', compact('id', 'pic_type', 'data', 'loop_times', 'images'));
    }

    public function update(Request $request, $id)
    {
        $origin_ids = $request->origin_img_id;
        $image_types = $request->image_type;
        $upload_ids = $request->img_id;
        $upload_name = $request->img_name;
        $upload_url = $request->img_url;
        $json_type = $request->pic_type;
        $db_origin_img = [];
        $generals = GeneralImages::get();
        foreach ($generals as $g) {
            $db_origin_img[$g->id] = $g->name;
        }

        $datas = [];

        foreach ($image_types as $index => $type) {
            $temp = $type == 'origin' ? [
                'type' => $type,
                'img_id' => $origin_ids[$index],
                'img_name' => $db_origin_img[$origin_ids[$index]],
                'img_url' => $this->getWeatherImage($db_origin_img[$origin_ids[$index]])
            ] : [
                'type' => $type,
                'img_id' => $upload_ids[$index],
                'img_name' => $upload_name[$index],
                'img_url' => $upload_url[$index]
            ];
            $datas[] = $temp;
        }

        $json_data = json_encode($datas);
        $update = $json_type == 'typhoon' ? ['typhoon_json' => $json_data] : ['forecast_json' => $json_data];

        Device::where('id', $id)->update($update);
        return redirect(route('dashboard.index'));


    }

    public function probe()
    {
        return 'ok';
    }

    public function updateDeviceHost(Request $request)
    {
        Device::where('id', $request->device_id)->update(['user_id' => $request->user_id]);

        return $this->sendResponse('', 'success');
    }

    public function updateDeviceTheme(Request $request)
    {
        Device::where('id', $request->device_id)->update(['theme' => $request->theme]);

        return $this->sendResponse('', 'success');
    }

    public function getWeatherImage($name)
    {
        $map = [
            '東亞VIS' => '/images/weather/東亞VIS.jpg',
            '東亞MB' => '/images/weather/東亞MB.jpg',
            '東亞IR' => '/images/weather/東亞IR.jpg',
            '地面天氣圖' => '/images/weather/地面天氣圖.jpg',
            '全球IR' => '/images/weather/全球IR.jpg',
            '紫外線' => '/images/weather/紫外線.png',
            '雷達回波' => '/images/weather/雷達回波圖.png',
            '溫度' => '/images/weather/溫度.jpg',
            '雨量' => '/images/weather/雨量.jpg',
            '數值預報' => '/images/weather/數值預報.png',
            '定量降水預報12小時' => '/images/weather/定量降水預報12小時.png',
            '定量降水預報6小時' => '/images/weather/定量降水預報6小時.png',
            '24H預測' => '/images/weather/24H預測.png',
            '天氣預測' => '/images/weather/天氣預測.png',
            '波浪分析圖' => '/images/weather/波浪分析圖.jpg',
            '天氣警報' => '/images/weather/天氣警報.png'

        ];
        return $map[$name];
    }

}
