<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Models\TyphoonImage;
use App\Models\GeneralImages;
use App\Events\MobileActionEvent;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Models\GeneralImagesCategory;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Finder;
use App\Models\HostPreference;

class MobileDeviceController extends Controller
{
    /**
     * 裝置列表
     * @return JsonResponse
     */
    public function deviceList(): JsonResponse
    {
        try {
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
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError('請求失敗');
        }

    }

    /**
     * 獲取裝置訊息
     * @param Request $request
     * @return JsonResponse
     */
    public function getDeviceData(Request $request): JsonResponse
    {
        try {
            $request->validate(['id' => 'required|numeric|digits_between:1,10']);
            $id = $request->id;
            $typhoonImgs = TyphoonImage::get();
            $generalImgs = GeneralImages::get();
            $users = User::query()->where(function ($query) {
                $query->role(2);
            })->get(['id', 'name']);

            $device = Device::with(['user'])->where('id', $id)->first();
            $res = [
                'room' => $device->name,
                'room_value' => $this->roomValue($device->name),
                'anchor_id' => $device->user->id ?? 0,
                'anchor' => $device->user->name ?? '',
                'typhoon' => [],
                'weather' => [],
                'anchor_list' => [],
            ];

            $res['anchor_list'] = $users->toArray();
            $typhoon = $device->typhoon_json;
            // 主播圖卡
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

                $tempWeather = [
                    'name' => $img->content['display_name'],
                    'value' => $img->name,
                    'pic_url' => env('APP_URL') . getWeatherImage($img->name),
                ];

                if (weatherType($img->name) === 3) {
                    $files = Storage::disk('data')->allFiles($img->content['origin']);
                    $tempWeather['list'] = [];
                    foreach ($files as $index => $file) {
                        if ($index > 5) {
                            break;
                        }
                        $tempWeather['list'][] = [
                            'name' => $index + 1,
                            'value' => $index
                        ];
                    }
                }
                $res['weather'][] = $tempWeather;
            }

            return response()->json($res);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError('請求失敗');
        }
    }

    /**
     * 一般天氣總覽圖
     * @return JsonResponse
     */
    public function weatherDetail(): JsonResponse
    {
        try {
            $generalCategory = GeneralImagesCategory::query()->with('generalImage')->orderBy('sort')->get();
            $res = [];
            foreach ($generalCategory as $category) {
                $temp = [
                    'category_name' => $category->name,
                    'list' => []
                ];
                foreach ($category->generalImage as $img) {
                    $temp['list'][] = [
                        'name' => $img->content['display_name'],
                        'value' => $img->name,
                        'pic_url' => env('APP_URL') . getWeatherImage($img->name),
                    ];
                }
                $res[] = $temp;
            }
            return response()->json($res);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError('請求失敗');
        }
    }

    /**
     * 行動請求
     * @param Request $request
     * @return JsonResponse
     */
    public function action(Request $request): JsonResponse
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

    /**
     * 更新主播
     * @param Request $request
     * @return JsonResponse
     */
    public function updateAnchor(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'device_id' => 'required|numeric',
                'anchor_id' => 'required|numeric',
            ]);
            $device_id = $request->get('device_id');
            $user_id = $request->get('anchor_id');
            $device = Device::find($device_id);
            $user = User::query()->where(function ($query) {
                $query->role(2);
            })->where('id', $user_id)->first();
            if ($device && $user) {
                $device->user_id = $user_id;
                $device->save();
            } else {
                throw new Exception('device_id or anchor_id wrong');
            }
            return $this->sendResponse('', '成功更新');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError('請求失敗');
        }
    }

    /** 獲取主播的元件座標
     * @param Request $request
     * @return JsonResponse
     */
    public function hostPreference(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'anchor_id' => 'numeric',
                'device_id' => 'required|numeric',
                'type' => 'required|string|max:255',
                'screen' => 'required|string|max:255',
            ]);
            $user_id = $request->get('anchor_id');
            $device_id = $request->get('device_id');
            $key = $request->get('screen');
            $type = $request->get('type');
            if ($user_id) {
                $host = HostPreference::query()->where([
                    'user_id' => $user_id,
                    'device_id' => $device_id
                ])->first();
            } else {
                $host = Device:: query()->where(['id' => $device_id])->first();
            }

            // 檢查是否為 一般天氣-圖資
            if (getWeatherImage($key)) {
                $json = $host->preference_json[$type]['images'][$key];
            } else {
                // 颱風所有圖資， 一般天氣-一般天氣預報， 一般天氣-通用設定
                $json = $host->preference_json[$type][$key];
            }
            return response()->json($json);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError('請求失敗');
        }
    }

    /** 更新主播的元件座標
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePreference(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'anchor_id' => 'numeric',
                'device_id' => 'required|numeric',
                'type' => 'required|string|max:255',
                'screen' => 'required|string|max:255',
                'preference' => 'required|array',
            ]);
            $user_id = $request->get('anchor_id');
            $device_id = $request->get('device_id');
            $key = $request->get('screen');
            $type = $request->get('type');

            $preference = $request->get('preference');

            if ($user_id) {
                $host = HostPreference::query()->where([
                    'user_id' => $user_id,
                    'device_id' => $device_id
                ])->first();
            } else {
                $host = Device:: query()->where(['id' => $device_id])->first();
            }

            $tempPreferenceJson = $host->preference_json;
            // 檢查是否為 一般天氣-圖資
            if (getWeatherImage($key) && $type === 'weather') {
                $tempPreferenceJson[$type]['images'][$key] = $preference;
            } else if ($this->checkKey($type, $key)) {
                // 颱風所有圖資， 一般天氣-一般天氣預報， 一般天氣-通用設定
                $tempPreferenceJson[$type][$key] = $preference;
            } else {
                throw new Exception('type,key,參數錯誤');
            }
            $host->preference_json = $tempPreferenceJson;
            $host->save();
            return $this->sendResponse('', '成功更新');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError('請求失敗');
        }
    }

    /** 檢查type,key對應是否正確
     * @param $type
     * @param $key
     * @return bool
     */
    public function checkKey($type, $key): bool
    {
        $typhoon = ['typhoon-dynamics', 'typhoon-dynamics', 'wind-observation', 'wind-forecast', 'rainfall-observation', 'rainfall-forecast'];
        $weather = ['general', 'weather-information'];
        if ($type === 'typhoon') {
            return in_array($key, $typhoon);

        } else if ($type === 'weather') {
            return in_array($key, $weather);
        }
        return false;
    }


    /** 獲取辦公室的value
     * @param $room
     * @return string
     */
    public function roomValue($room): string
    {
        $map = [
            '防災視訊室' => 'protect_disaster',
            '公關室' => 'pr'
        ];
        return $map[$room] ?? '';
    }

}
