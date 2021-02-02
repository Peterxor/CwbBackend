<?php

use App\Models\GeneralImages;
use App\Models\Media;
use App\Models\TyphoonImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Device;
use App\Models\HostPreference;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getBackground')) {
    function getBackground($background)
    {
        switch ($background) {
            default:
            case 0:
                return [
                    [
                        'name' => '多雲',
                        'value' => 1,
                    ],
                    [
                        'name' => '晴天',
                        'value' => 2,
                    ],
                    [
                        'name' => '資訊',
                        'value' => 3,
                    ],
                    [
                        'name' => '颱風眼',
                        'value' => 4,
                    ]
                ];
            case 1:
                return '多雲';
            case 2:
                return '晴天';
            case 3:
                return '資訊';
            case 4:
                return '颱風眼';
        }
    }
}

if (!function_exists('getTheme')) {
    function getTheme($theme)
    {
        switch ($theme) {
            case 0:
                return [
                    [
                        'name' => '自然',
                        'value' => 1,
                    ],
                    [
                        'name' => '科技藍',
                        'value' => 2,
                    ],
                    [
                        'name' => '工業橘',
                        'value' => 3,
                    ],
                    [
                        'name' => '現代紅',
                        'value' => 4,
                    ]
                ];
            default:
            case 1:
                return '自然';
            case 2:
                return '科技藍';
            case 3:
                return '工業橘';
            case 4:
                return '現代紅';
        }
    }
}

if (!function_exists('uploadMedia')) {
    function uploadMedia($file)
    {
        $filesystem = 'media';
        if (env('MEDIA_TYPE', 'media') == 's3') {
            $filesystem = 's3';
        }
        DB::beginTransaction();
        $extension = $file->getClientOriginalExtension();
        $origin_name = $file->getClientOriginalName();
        $name = Str::replaceLast('.' . $extension, '', $origin_name);
        $file_name = $name . '.' . $extension;
        $path = '/cwb';

        $new_media = new Media([
            'disk' => $filesystem,
            'file_name' => $name,
            'mime_type' => $extension,
            'path' => $path . '/' . $file_name,
            'size' => $file->getSize(),
        ]);
        $new_media->save();
        if (env('MEDIA_TYPE', 'media') == 's3') {
            $s3_path = Storage::disk($filesystem)->put($path . '/' . $file_name, file_get_contents($file));
            Log::info('save to s3: ' . $s3_path);
        } else {
            $file->storeAs($path, $file_name, $filesystem);
        }

        DB::commit();
        return [
            'new_media' => $new_media,
            'filesystem' => $filesystem,
            'path' => $path,
            'file_name' => $file_name,
        ];
    }
}

if (!function_exists('preference')) {
    /**
     * 取得個人裝置設定檔
     *
     * @param Device $device
     * @return array
     */
    function preference(Device $device): array
    {
        /** @var HostPreference $hostPreference */
        $hostPreference = HostPreference::query()->firstOrNew(['user_id' => $device->user_id, 'device_id' => $device->id]);

        return depthArrayMerge($device->preference_json ?? [], $hostPreference->preference_json ?? []);
    }
}

if (!function_exists('depthArrayMerge')) {
    /**
     * 深度合併Array
     *
     * @param array $arr1
     * @param array $arr2
     * @return array
     */
    function depthArrayMerge(array $arr1, array $arr2): array
    {
        foreach ($arr2 as $key => $value) {
            $arr1[$key] = (array_key_exists($key, $arr1) && is_array($value)) ? depthArrayMerge($arr1[$key], $value) : $value;
        }
        return $arr1;
    }
}


if (!function_exists('getWeatherImage')) {
    function getWeatherImage($name): string
    {
        $map = [
            'east_asia_vis' => '/images/weather/東亞VIS.jpg',
            'east_asia_mb' => '/images/weather/東亞MB.jpg',
            'east_asia_ir' => '/images/weather/東亞IR.jpg',
            'surface_weather_map' => '/images/weather/地面天氣圖.jpg',
            'global_ir' => '/images/weather/全球IR.jpg',
            'ultraviolet_light' => '/images/weather/紫外線.png',
            'radar_echo' => '/images/weather/雷達回波圖.png',
            'temperature' => '/images/weather/溫度.jpg',
            'rainfall' => '/images/weather/雨量.jpg',
            'numerical_forecast' => '/images/weather/數值預報.png',
            'precipitation_forecast_12h' => '/images/weather/定量降水預報12小時.png',
            'precipitation_forecast_6h' => '/images/weather/定量降水預報6小時.png',
            'forecast_24h' => '/images/weather/24H預測.png',
            'weather_forecast' => '/images/weather/天氣預測.png',
            'wave_analysis_chart' => '/images/weather/波浪分析圖.jpg',
            'weather_alert' => '/images/weather/天氣警報.png'
        ];
        return $map[$name] ?? '';
    }
}

if (!function_exists('trasformWeatherName')) {
    function transformWeatherName($img_url): string
    {
        return explode('.', explode('/', $img_url)[count(explode('/', $img_url)) - 1])[0];
    }
}


if (!function_exists('weatherType')) {
    /**
     * 取得天氣圖資類型
     *
     * @param string $weatherName
     * @return int
     */
    function weatherType(string $weatherName): int
    {
        // 1:單圖
        // 2:動態組圖
        // 3:圖片列表
        // 4:雙圖並列
        switch ($weatherName) {
            case 'surface_weather_map':
            case 'ultraviolet_light':
            case 'rainfall':
            case 'wave_analysis_chart':
            case 'weather_alert':
                return 1;
            case 'east_asia_vis':
            case 'east_asia_mb':
            case 'east_asia_ir':
            case 'global_ir':
            case 'radar_echo':
                return 2;
            case 'temperature':
            case 'numerical_forecast':
            case 'forecast_24h':
            case 'weather_forecast':
                return 3;
            case 'precipitation_forecast_12h':
            case 'precipitation_forecast_6h':
                return 4;
            default:
                return 5;
        }
    }
}

if (!function_exists('imageUrl')) {
    function imageUrl(string $path): string
    {
        $files = iterator_to_array(Finder::create()->files()->in(Storage::disk('data')->path($path))->sortByName(), false);

        return Storage::disk('data')->url($path . '/' . $files[count($files) - 1]->getBasename());
    }
}

if (!function_exists('imagesUrl')) {
    function imagesUrl(string $path, int $amount): array
    {
        $path = rtrim($path, '/');
        $files = array_reverse(iterator_to_array(Finder::create()->files()->in(Storage::disk('data')->path($path))->sortByName(), false));
        $images = [];
        foreach ($files as $key => $file) {
            if ($key >= $amount)
                continue;
            $images[] = Storage::disk('data')->url($path . '/' . $file->getBasename());
        }
        return array_reverse($images);
    }
}

if (!function_exists('hasPermission')) {
    function hasPermission(string $permission_name): bool
    {
        if (!$permission_name) {
            return false;
        }
        return Auth::user()->can($permission_name);
    }
}

if (!function_exists('savePreferenceLog')) {
    function savePreferenceLog($key, $model, $itemKeys, $request, $beforeJson, $item)
    {
        $elements = [];
        $logData = TyphoonImage::query()->whereIn('name', $itemKeys)->get();
        if (count($logData) > 0) {
            foreach ($logData as $l) {
                $elements[] = $l->content['display_name'];
            }
        } else {
            foreach ($itemKeys as $ik) {
                switch ($ik) {
                    case 'anchor_information':
                        $elements[] = '主播圖卡';
                        break;
                    case 'colors':
                        $elements[] = '畫筆';
                        break;
                    case 'images':
                        $elements[] = '圖資';
                        break;
                    case 'general':
                        $elements[] = '通用';
                        break;
                    case 'weather_information':
                        $elements[] = '一般天氣預報';
                        break;
                    default:
                        $elements[] = '';
                        break;
                }
            }
        }

        activity()
            ->performedOn($model)
            ->causedBy(Auth::user()->id)
            ->withProperties([
                'ip' => $request->getClientIp(),
                'item' => $item . implode(',', $elements),
                'before_json' => $beforeJson
            ])
            ->log('修改');
    }
}

