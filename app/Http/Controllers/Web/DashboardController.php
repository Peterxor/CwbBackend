<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use App\Models\Device;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\GeneralImages;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Dashboard
     *
     * @return View
     */
    public function index(): View
    {
        $devices = Device::with(['user'])->get();
        $themes = getTheme(0);

        return view("backend.pages.dashboard.index", compact('devices', 'themes'));
    }

    /**
     * 編輯颱風主播圖卡或天氣預報排程
     *
     * @param Request $request
     * @param Device $device
     * @return View
     */
    public function edit(Request $request, Device $device): View
    {
        $pic_type = $request->pic_type ?? 'typhoon';
        $data = $pic_type === 'typhoon' ? $device->typhoon_json : $device->forecast_json;
        $images = GeneralImages::all();
        $loop_times = 9;

        return view('backend.pages.dashboard.edit', compact('device', 'pic_type', 'data', 'loop_times', 'images'));
    }

    /**
     * 更新颱風主播圖卡或天氣預報排程
     *
     * @param Request $request
     * @param Device $device
     * @return RedirectResponse
     */
    public function update(Request $request, Device $device)
    {
        $origin_ids = $request->get('origin_img_id');
        $image_types = $request->get('image_type');
        $upload_ids = $request->get('img_id');
        $upload_name = $request->get('img_name');
        $upload_url = $request->get('img_url');
        $json_type = $request->get('pic_type');
        $db_origin_img = [];
        $generals = GeneralImages::all();
        foreach ($generals as $g) {
            $db_origin_img[$g->id] = $g->name;
        }

        $data = [];

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
            $data[] = $temp;
        }
        $update = $json_type == 'typhoon' ? ['typhoon_json' => $data] : ['forecast_json' => $data];

        $device->update($update);
        return redirect(route('dashboard.index'));
    }

    public function updateDeviceHost(Request $request)
    {
        Device::query()->where('id', $request->get('device_id'))->update(['user_id' => $request->get('user_id')]);

        return $this->sendResponse('', 'success');
    }

    public function updateDeviceTheme(Request $request)
    {
        Device::query()->where('id', $request->get('device_id'))->update(['theme' => $request->get('theme')]);

        return $this->sendResponse('', 'success');
    }

    /**
     * 取得範例圖
     *
     * @param $name
     * @return string
     */
    private function getWeatherImage($name): string
    {
        $map = [
            'east-asia-vis' => '/images/weather/東亞VIS.jpg',
            'east-asia-mb' => '/images/weather/東亞MB.jpg',
            'east-asia-ir' => '/images/weather/東亞IR.jpg',
            'surface-weather-map' => '/images/weather/地面天氣圖.jpg',
            'global-ir' => '/images/weather/全球IR.jpg',
            'ultraviolet-light' => '/images/weather/紫外線.png',
            'radar-echo' => '/images/weather/雷達回波圖.png',
            'temperature' => '/images/weather/溫度.jpg',
            'rainfall' => '/images/weather/雨量.jpg',
            'numerical-forecast' => '/images/weather/數值預報.png',
            'precipitation-forecast-12h' => '/images/weather/定量降水預報12小時.png',
            'precipitation-forecast-6h' => '/images/weather/定量降水預報6小時.png',
            'forecast-24h' => '/images/weather/24H預測.png',
            'weather-forecast' => '/images/weather/天氣預測.png',
            'wave-analysis-chart' => '/images/weather/波浪分析圖.jpg',
            'weather-alert' => '/images/weather/天氣警報.png'
        ];
        return $map[$name];
    }

    /**
     * keepalive
     *
     * @return string
     */
    public function probe(): string
    {
        return 'ok';
    }
}
