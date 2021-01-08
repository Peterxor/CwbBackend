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
    public function deviceList():JsonResponse
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

    public function getDeviceData(Request $request):JsonResponse
    {
        $id = $request->id;
        $typhoonImgs = TyphoonImage::get();
        $generalImgs = GeneralImages::get();


        $device = Device::with(['user'])->where('id', $id)->first();
        $res = [
            'room' => $device->name,
            'room_value' => $this->roomValue($device->name),
            'anchor' => $device->user->name ?? '',
            'typhoon' => [],
            'weather' => [],
        ];
        $typhoon = $device->typhoon_json;

//        主播圖卡
        $host_pics = [];
        foreach ($typhoon as $index => $value) {
            $host_pics[] = [
                'name' => transformWeatherName($value['img_url']),
                'value' => $index,
                'pic_url' => env('APP_URL') . $value['img_url'],
            ];
        }

        foreach ($typhoonImgs as $img) {
            $res['typhoon'][] = [
                'name' => $img->content['display_name'],
                'value' => $img->name,
            ];
        }
        $res['typhoon'][] = [
            'name' => '主播圖卡',
            'value' => 'anchor_slide',
            'list' => $host_pics,
        ];

        foreach ($generalImgs as $img) {
            $res['weather'][] = [
                'name' => $img->content['display_name'],
                'value' => $img->name,
                'pic_url' => env('APP_URL') . getWeatherImage($img->name),
            ];
        }

        return response()->json($res);
    }

    public function action(Request $request):JsonResponse
    {
        $room = $request->room ?? '';
        $screen = $request->screen ?? '';
        $sub = $request->sub ?? '';
        $behaviour = $request->behaviour ?? '';
        $res['success'] = true;
        $res['data'] = $request->all();
        broadcast(new MobileActionEvent($room, $screen, $sub, $behaviour));
        return response()->json($res);
    }


    public function roomValue($room)
    {
        $map = [
            '防災視訊室' => 'protect_disaster',
            '公關室' => 'pr'
        ];
        return $map[$room] ?? '';
    }

}
