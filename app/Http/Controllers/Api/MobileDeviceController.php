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
    private $toolItem = ['title', 'tool-middle', 'image-tool', 'tool-left', 'tool-right', 'image-label-left', 'image-label-right'];

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
            // 颱風主播圖卡 & 天氣預報排程
            $typhoon = $device->typhoon_json;
            $weather = $device->forecast_json;
            // 主播圖卡
            $host_pics = [];
            foreach ($typhoon as $index => $value) {
                $host_pics[] = [
                    'name' => transformWeatherName($value['img_url']),
                    'value' => $index,
                    'pic_url' => env('APP_URL') . $value['img_url'],
                ];
            }

            foreach ($weather as $index => $value) {
                $res['weather'][] = [
                    'name' => transformWeatherName($value['img_url']),
                    'screen' => 'weather-slider',
                    'key' => $value['img_name'],
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
            $generalImages = GeneralImages::query()->orderBy('sort')->get();
            $imageIndexes = [];
            foreach ($generalImages as $index => $image) {
                $imageIndexes[$image->name] = $index;
            }
            $res = [];
            foreach ($generalCategory as $category) {
                $temp = [
                    'category_name' => $category->name,
                    'list' => []
                ];
                foreach ($category->generalImage as $img) {
                    $temp['list'][] = [
                        'name' => $img->content['display_name'],
                        'screen' => 'weather-overview',
                        'key' => $img->name,
                        'value' => $imageIndexes[$img->name],
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
        $point_x = $request->point_x ?? '';
        $point_y = $request->point_y ?? '';
        $scale = $request->scale ?? '';
        $res['success'] = true;
        $res['data'] = $request->all();
        broadcast(new MobileActionEvent($room, $screen, $sub, $behaviour, $point_x, $point_y, $scale));
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
            $arr = [];
            if ($type === 'weather') {
                $json = $host->preference_json[$type]['images'];
                $general = $host->preference_json[$type]['general'];
                $weather_information = $host->preference_json[$type]['weather-information'];
                $arr = array_merge($arr, $this->jsonToArray($general));
                $arr = array_merge($arr, $this->jsonToArray($weather_information));
                $arr = array_merge($arr, $this->jsonToArray($json, $key));
            } else {
                // 颱風所有圖資
                $json = $host->preference_json[$type][$key];
                $arr = $this->jsonToArray($json);
            }
            return response()->json($arr);
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
            if ($type === 'weather') {
                $tempPreferenceJson[$type]['images'][$key] = $preference;
                foreach ($preference as $obj) {
                    $middleKey = 'images';
                    if (in_array($obj['key'], $this->toolItem)) {
                        $middleKey = 'general';
                    } else if ($obj['key'] === 'block') {
                        $middleKey = 'weather-information';
                    }
                    if (isset($tempPreferenceJson[$type][$middleKey][$obj['key']])) {
                        $tempPreferenceJson[$type][$middleKey][$obj['key']]['point'] = [$obj['point_x'], $obj['point_y']];
                        if ( isset($obj['scale'])) {
                            $tempPreferenceJson[$type][$middleKey][$obj['key']]['scale'] = $obj['scale'];
                        }
                    }
                }
            } else if ($type === 'typhoon') {
                // 颱風所有圖資
                foreach ($preference as $obj) {
                    if (isset($tempPreferenceJson[$type][$key][$obj['key']])) {
                        $tempPreferenceJson[$type][$key][$obj['key']]['point'] = [$obj['point_x'], $obj['point_y']];
                        if(isset($obj['scale'])) {
                            $tempPreferenceJson[$type][$key][$obj['key']]['scale'] = $obj['scale'];
                        }
                    }
                }

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

    public function elementName($englishName): string
    {
        $map = [
            'typhoon-ir' => '颱風IR',
            'typhoon-mb' => '颱風MB',
            'typhoon-vis' => '颱風VIS',
            'title' => '標題',
            'tool-middle' => '工具列 (中間)',
            'taiwan-all' => '台灣 (全)',
            'taiwan-n' => '台灣 (北)',
            'taiwan-m' => '台灣 (中)',
            'taiwan-s' => '台灣 (南)',
            'taiwan-e' => '台灣 (東)',
            'image-tool' => '圖例',
            'tool-left' => '工具列 (左)',
            'tool-right' => '工具列 (右)',
            'taiwan-y' => '台灣 (宜)',
            'taiwan-h' => '台灣 (花)',
            'block' => '圖卡區塊',
            'weather-information' => '一般天氣預報',
            'general' => '通用設定',
            'image-label-left' => '圖片列表 (左)',
            'image-label-right' => '圖片列表 (右)',
            'images' => '圖資',
            'east-asia-vis' => '東亞VIS',
            'east-asia-mb' => '東亞MB',
            'east-asia-ir' => '東亞IR',
            'surface-weather-map' => '地面天氣圖',
            'global-ir' => '全球IR',
            'ultraviolet-light' => '紫外線',
            'radar-echo' => '雷達回波',
            'temperature' => '溫度',
            'rainfall' => '雨量',
            'numerical-forecast' => '數值預報',
            'precipitation-forecast-12h' => '定量降水預報12小時',
            'precipitation-forecast-6h' => '定量降水預報6小時',
            'forecast-24h' => '24H預測',
            'weather-forecast' => '天氣預測',
            'wave-analysis-chart' => '波浪分析圖',
            'weather-alert' => '天氣警報',
        ];
        return $map[$englishName];
    }

    public function jsonToArray($json, $inputKey = null): array
    {
        $arr = [];
        $tool = [];
        $images = [];

        foreach ($json as $key => $value) {
            if ($inputKey && $key !== $inputKey) {
                continue;
            }
            $temp = [];
            $temp['name'] = $this->elementName($key) ?? '';
            $temp['key'] = $key;
            if (isset($value['scale'])) {
                $temp['scale'] = $value['scale'];
            }
            $temp['point_x'] = $value['point'][0];
            $temp['point_y'] = $value['point'][1];
            if (in_array($key, $this->toolItem)) {
                $tool[] = $temp;
            } else {
                $images[] = $temp;
            }
        }
        $arr = array_merge($images, $tool);
        return $arr;
    }


}
