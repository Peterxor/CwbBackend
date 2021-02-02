<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Models\TyphoonImage;
use App\Events\MobileActionEvent;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\GeneralImagesCategory;
use App\Models\HostPreference;

class MobileDeviceController extends Controller
{
    private $toolItem = ['title', 'tool_middle', 'image_tool', 'tool_left', 'tool_right', 'image_label_left', 'image_label_right'];

    /**
     * 裝置列表
     * @return JsonResponse
     */
    public function deviceList(): JsonResponse
    {
        try {
            $devices = Device::all();
            $data = [];
            foreach ($devices as $device) {
                $data[] = [
                    'device_id' => $device->id,
                    'device_name' => $device->name
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
            $typhoonImgs = TyphoonImage::all();
            $users = User::query()->where(function ($query) {
                $query->role(2);
            })->get(['id', 'name']);

            /** @var Device $device */
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
            $res['anchor_list'][] = [
                'id' => 0,
                'name' => '不指定主播'
            ];
            // 颱風主播圖卡 & 天氣預報排程
            $typhoon = $device->typhoon_json;
            $weather = $device->forecast_json;
            // 主播圖卡
            $host_pics = [];
            foreach ($typhoon as $index => $value) {
                $host_pics[] = [
                    'mode' => $value['type'],
                    'name' => transformWeatherName($value['img_url']),
                    'screen' => $value['img_name'],
                    'sub' => 'anchor_slider',
                    'pic_url' => env('APP_URL') . $value['img_url'],
                ];
            }

            foreach ($weather as $index => $value) {
                $res['weather'][] = [
                    'mode' => $value['type'],
                    'name' => transformWeatherName($value['img_url']),
                    'screen' => $value['img_name'],
                    'sub' => 'weather_slider',
                    'pic_url' => env('APP_URL') . $value['img_url'],
                ];
            }

            foreach ($typhoonImgs as $img) {
                $res['typhoon'][] = [
                    'mode' => 'origin',
                    'name' => $img->content['display_name'],
                    'screen' => $img->name,
                ];
            }
            $res['typhoon'][] = [
                'name' => '主播圖卡',
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

            $res = [];
            foreach ($generalCategory as $category) {
                $temp = [
                    'category_name' => $category->name,
                    'list' => []
                ];
                foreach ($category->generalImage as $img) {
                    $temp['list'][] = [
                        'mode' => 'origin',
                        'name' => $img->content['display_name'],
                        'screen' => $img->name,
                        'sub' => 'weather_overview',
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
     * 平板對網頁的行動請求
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
        broadcast(new MobileActionEvent($room, $screen, $sub, $behaviour, '', '', '', ''));
        return response()->json($res);
    }

    public function setCoordinate(Request $request): JsonResponse
    {
        $room = $request->room ?? '';
        $screen = $request->screen ?? '';
        $sub = $request->sub ?? '';
        $target = $request->target ?? '';
        $point_x = $request->point_x ?? '';
        $point_y = $request->point_y ?? '';
        $scale = $request->scale ?? '';
        $res['success'] = true;
        $res['data'] = $request->all();
        broadcast(new MobileActionEvent($room, $screen, $sub, '', $point_x, $point_y, $scale, $target));
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
                'anchor_id' => 'numeric',
            ]);
            $device_id = $request->get('device_id');
            $user_id = $request->get('anchor_id');
            /** @var Device $device */
            $device = Device::query()->find($device_id);
            $user = User::query()->where(function ($query) {
                $query->role(2);
            })->where('id', $user_id)->first();
            if (($user || $user_id == 0) && $device) {
                $device->user_id = $user_id;
                $device->save();
            } else {
                throw new Exception('device_id or user_id 錯誤');
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
        //todo anchor_id 作廢
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
                $weather_information = $host->preference_json[$type]['weather_information'];
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
                foreach ($preference as $obj) {
                    $middleKey = 'images';
                    if (in_array($obj['target'], $this->toolItem)) {
                        $middleKey = 'general';
                    } else if ($obj['target'] === 'block') {
                        $middleKey = 'weather_information';
                    }
                    if (isset($tempPreferenceJson[$type][$middleKey][$obj['target']])) {
                        $tempPreferenceJson = $this->changeXyAndScale($tempPreferenceJson, $type, $middleKey, $obj);
                    }
                }
            } else if ($type === 'typhoon') {
                // 颱風所有圖資
                foreach ($preference as $obj) {
                    if (isset($tempPreferenceJson[$type][$key][$obj['target']])) {
                        $tempPreferenceJson = $this->changeXyAndScale($tempPreferenceJson, $type, $key, $obj);
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

    /**
     * 更新元件x, y, scale座標與縮放
     * @param $tempPreferenceJson
     * @param $type
     * @param $key
     * @param $obj
     * @return mixed
     */
    public function changeXyAndScale($tempPreferenceJson, $type, $key, $obj)
    {
        $tempPreferenceJson[$type][$key][$obj['target']]['point'] = [$obj['point_x'], $obj['point_y']];
        if (isset($obj['scale'])) {
            $tempPreferenceJson[$type][$key][$obj['target']]['scale'] = $obj['scale'];
        }
        return $tempPreferenceJson;
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
            'typhoon_ir' => '颱風IR',
            'typhoon_mb' => '颱風MB',
            'typhoon_vis' => '颱風VIS',
            'title' => '標題',
            'tool_middle' => '工具列 (中間)',
            'taiwan_all' => '台灣 (全)',
            'taiwan_n' => '台灣 (北)',
            'taiwan_m' => '台灣 (中)',
            'taiwan_s' => '台灣 (南)',
            'taiwan_e' => '台灣 (東)',
            'image_tool' => '圖例',
            'tool_left' => '工具列 (左)',
            'tool_right' => '工具列 (右)',
            'taiwan_y' => '台灣 (宜)',
            'taiwan_h' => '台灣 (花)',
            'block' => '圖卡區塊',
            'weather_information' => '一般天氣預報',
            'general' => '通用設定',
            'image_label_left' => '圖片列表 (左)',
            'image_label_right' => '圖片列表 (右)',
            'images' => '圖資',
            'east_asia_vis' => '東亞VIS',
            'east_asia_mb' => '東亞MB',
            'east_asia_ir' => '東亞IR',
            'surface_weather_map' => '地面天氣圖',
            'global_ir' => '全球IR',
            'ultraviolet_light' => '紫外線',
            'radar_echo' => '雷達回波',
            'temperature' => '溫度',
            'rainfall' => '雨量',
            'numerical_forecast' => '數值預報',
            'precipitation_forecast_12h' => '定量降水預報12小時',
            'precipitation_forecast_6h' => '定量降水預報6小時',
            'forecast_24h' => '24H預測',
            'weather_forecast' => '天氣預測',
            'wave_analysis_chart' => '波浪分析圖',
            'weather_alert' => '天氣警報',
        ];
        return $map[$englishName];
    }

    /**
     * 將元件座標調整為array格式
     * @param $json
     * @param null $inputKey
     * @return array
     */
    public function jsonToArray($json, $inputKey = null): array
    {
        $tool = [];
        $images = [];

        foreach ($json as $key => $value) {
            if ($inputKey && $key !== $inputKey) {
                continue;
            }
            $temp = [];
            $temp['name'] = $this->elementName($key) ?? '';
            $temp['target'] = $key;
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
        return array_merge($images, $tool);
    }


}
