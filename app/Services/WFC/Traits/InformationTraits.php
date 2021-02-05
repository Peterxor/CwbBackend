<?php

namespace App\Services\WFC\Traits;

use App\Models\GeneralImages;
use App\Services\WFC\Exceptions\WFCException;
use Carbon\Carbon;
use Exception;

trait InformationTraits
{
    /**
     * 圖資格式整理
     *
     * @param string $title
     * @param array $setting
     * @param array $preference
     * @return array
     * @throws WFCException
     */
    static private function format(string $title, array $setting, array $preference): array
    {
        $count = 1;
        $informationList = [];
        $generalImages = GeneralImages::all();
        foreach ($setting ?? [] as $index => $settingImage) {
            $generalImage = $generalImages->where('name', $settingImage['img_name'] ?? '')->first();
            try {
                if ($settingImage['type'] == 'origin') {
                    $type = weatherType($settingImage['img_name']);
                    $imagePreference = $preference['weather']['images'][$settingImage['img_name']] ?? [];
                    $information = [
                        'key' => ($generalImage->name ?? $settingImage['img_name']) . '_' . $index,
                        'mode' => GeneralImages::$mode[$type],
                        'scale' => $imagePreference['scale'] ?? 100,
                        'point_x' => $imagePreference['point_x'] ?? 0,
                        'point_y' => $imagePreference['point_y'] ?? 0,
                        'title' => $generalImage->content['display_name'] ?? ('小叮嚀' . $count)
                    ];

                    switch ($type) {
                        case 1:
                            $image = imageUrl($generalImage->content['origin']);
                            $informationList[] = array_merge($information, [
                                'description' => self::parseDescription($image, $settingImage['img_name']),
                                'image' => $image,
                                'thumbnail' => $image
                            ]);
                            break;
                        case 2:
                            $images = imagesUrl($generalImage->content['origin'], $generalImage->content['amount'] ?? 1);
                            $informationList[] = array_merge($information, [
                                'description' => self::parseDescription($images, $settingImage['img_name']),
                                'interval' => $generalImage->content['interval'] ?? 1000,
                                'images' => $images,
                                'thumbnail' => $images[0]
                            ]);
                            break;
                        case 3:
                            if ($settingImage['img_name'] == 'weather_forecast') {
                                $images = array_slice(imagesUrl($generalImage->content['origin'], 8), 0, 6);
                            } else {
                                $images = imagesUrl($generalImage->content['origin'], 6);
                            }

                            $informationList[] = array_merge($information, [
                                'description' => self::parseDescription($images, $settingImage['img_name']),
                                'images' => $images,
                                'thumbnail' => $images[0]
                            ]);
                            break;
                        case 4:
                            $leftImage = imageUrl($generalImage->content['origin_left']);
                            $rightImage = imageUrl($generalImage->content['origin_right']);
                            $informationList[] = array_merge($information, [
                                'image_l' => $leftImage,
                                'image_r' => $rightImage,
                                'thumbnail' => $rightImage
                            ]);
                            break;
                    }
                } else {
                    $information = [
                        'key' => ($settingImage['img_name'] ?? $settingImage['name']) . '_' . $index,
                        'mode' => GeneralImages::$mode[5],
                        'scale' => 100,
                        'point_x' => 0,
                        'point_y' => 0,
                        'title' => '小叮嚀' . $count
                    ];

                    switch ($settingImage['type']) {
                        case 'youtube':
                            // TODO: 缺 Youtube 照片
                            $informationList[] = array_merge($information, [
                                'mode' => GeneralImages::$mode[6],
                                'description' => '',
                                'title' => $settingImage['name'] ?? '',
                                'url' => $settingImage['url'],
                                'thumbnail' => url('images/weather/24H預測.png')
                            ]);
                            break;
                        case 'website':
                            // TODO: 缺 Website 照片
                            $informationList[] = array_merge($information, [
                                'mode' => GeneralImages::$mode[7],
                                'description' => '',
                                'title' => $settingImage['name'] ?? '',
                                'url' => $settingImage['url'],
                                'thumbnail' => url('images/weather/24H預測.png')
                            ]);
                            break;
                        default:
                            $informationList[] = array_merge($information, [
                                'description' => '',
                                'image' => url($settingImage['img_url']),
                                'thumbnail' => url($settingImage['img_url'])
                            ]);
                    }
                }

                $count++;
            } catch (Exception $exception) {
                throw new WFCException($title . '[第' . ($index + 1) . '項][' . ($generalImage->content['display_name'] ?? '') . ']資料解析錯誤', 500, $exception);
            }
        }

        return $informationList;
    }

    /**
     *
     * @param $urls
     * @param string $imageName
     * @return string
     */
    static private function parseDescription($urls, string $imageName): string
    {
        $startTime = '';
        $endTime = '';
        switch ($imageName) {
            case 'east_asia_vis':
                foreach ($urls as $url) {
                    $time = Carbon::createFromFormat('Y-m-d_Hi\.\V\I\S', pathinfo($url)['filename'], 'Asia/Taipei');
                    if (empty($startTime))
                        $startTime = $time->format('m月d日 H:i');
                    $endTime = $time->format('m月d日 H:i');
                }
                return empty($startTime) ? '' : $startTime . ' ~ ' . $endTime;
            case 'east_asia_mb':
                foreach ($urls as $url) {
                    $time = Carbon::createFromFormat('Y-m-d_Hi\.\I\R\1\_\M\B', pathinfo($url)['filename'], 'Asia/Taipei');
                    if (empty($startTime))
                        $startTime = $time->format('m月d日 H:i');
                    $endTime = $time->format('m月d日 H:i');
                }
                return empty($startTime) ? '' : $startTime . ' ~ ' . $endTime;
            case 'east_asia_ir':
                foreach ($urls as $url) {
                    $time = Carbon::createFromFormat('Y-m-d_Hi\.\I\R\1\_\C\R', pathinfo($url)['filename'], 'Asia/Taipei');
                    if (empty($startTime))
                        $startTime = $time->format('m月d日 H:i');
                    $endTime = $time->format('m月d日 H:i');
                }
                return empty($startTime) ? '' : $startTime . ' ~ ' . $endTime;
            case 'surface_weather_map':
                $time = Carbon::createFromFormat('Y-md-Hi\_\S\F\C\c\o\m\b\o\H\D', pathinfo($urls)['filename'], 'Asia/Taipei');
                return $time->format('m月d日 H:i');
            case 'global_ir':
                foreach ($urls as $url) {
                    $time = Carbon::createFromFormat('Y-m-d_Hi\.\I\R\1\_\F\D\K\.\M\B', pathinfo($url)['filename'], 'Asia/Taipei');
                    if (empty($startTime))
                        $startTime = $time->format('m月d日 H:i');
                    $endTime = $time->format('m月d日 H:i');
                }
                return empty($startTime) ? '' : $startTime . ' ~ ' . $endTime;
            case 'radar_echo':
                foreach ($urls as $url) {
                    $time = Carbon::createFromFormat('\C\V\1\_\4\K\_\3\8\4\0\_YmdHi', pathinfo($url)['filename'], 'Asia/Taipei');
                    if (empty($startTime))
                        $startTime = $time->format('m月d日 H:i');
                    $endTime = $time->format('m月d日 H:i');
                }
                return empty($startTime) ? '' : $startTime . ' ~ ' . $endTime;
            case 'temperature':
                foreach ($urls as $url) {
                    $time = Carbon::createFromFormat('Y-m-d_Hi\.\G\T\P\8', pathinfo($url)['filename'], 'Asia/Taipei');
                    if (empty($startTime))
                        $startTime = $time->format('m月d日 H:i');
                    $endTime = $time->format('m月d日 H:i');
                }
                return empty($startTime) ? '' : $startTime . ' ~ ' . $endTime;
            case 'rainfall':
                foreach ($urls as $url) {
                    $time = Carbon::createFromFormat('Y-m-d_Hi', substr(pathinfo($url)['filename'], 0, 15), 'Asia/Taipei');
                    if (empty($startTime))
                        $startTime = $time->format('m月d日 H:i');
                    $endTime = $time->format('m月d日 H:i');
                }
                return empty($startTime) ? '' : $startTime . ' ~ ' . $endTime;
            case 'numerical_forecast':
                foreach ($urls as $url) {
                    $time = Carbon::createFromFormat('YmdH', '20' . substr(pathinfo($url)['filename'], 15, 8), 'Asia/Taipei');
                    if (empty($startTime))
                        $startTime = $time->format('m月d日');
                    $endTime = $time->format('m月d日');
                }
                return empty($startTime) ? '' : $startTime . ' ~ ' . $endTime;
            case 'forecast_24h':
                $time = Carbon::createFromFormat('Y-md-hi\_\A\0\1\2\H\D', pathinfo($urls)['filename'], 'Asia/Taipei');
                return $time->format('m月d日 H:i');
            case 'weather_forecast':
                foreach ($urls as $url) {
                    $time = Carbon::createFromFormat('Y-md', substr(pathinfo($url)['filename'], 0, 9), 'Asia/Taipei');
                    return $time->format('m月d日');
                }
                return empty($startTime) ? '' : $startTime . ' ~ ' . $endTime;
            case 'wave_analysis_chart':
                $time = Carbon::createFromFormat('\F\I\1\2\P\OYmd\-\0\0', pathinfo($urls)['filename'], 'Asia/Taipei');
                return $time->format('m月d日 H:i');
            default:
                return '';
        }
    }
}
