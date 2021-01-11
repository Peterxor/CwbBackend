<?php

namespace App\Services\WFC;

use App\Services\WFC\Exceptions\WFCException;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Finder;

class WindForecast
{
    /**
     * 風力預測資料
     *
     * @param array $setting 圖資設定
     * @param array $preference 裝置設定
     * @return array
     * @throws WFCException
     */
    static public function get(array $setting, array $preference): array
    {
        try {
            $path = Storage::disk('data')->path($setting['wind-forecast']['origin']);

            // 以名稱排序(A-Z)取最後一個
            $files = iterator_to_array(Finder::create()->files()->in($path)->sortByName(), false);
            $windForecast = simplexml_load_file($files[count($files) - 1]->getPathname());

            $wind = [];
            foreach ($windForecast->WindForecastInformation->AreaForecastData ?? [] as $areaForecastData) {
                $key = (string)$areaForecastData->StartValidTime->Time;
                if (!array_key_exists($key, $wind)) {
                    $wind[$key]['startTime'] = (string)$areaForecastData->StartValidTime->Time;
                    $wind[$key]['endTime'] = (string)$areaForecastData->EndValidTime->Time;
                    $wind[$key]['location'] = ['n' => [], 'm' => [], 's' => [], 'e' => []];
                }

                if (((string)$areaForecastData->WindData->attributes()['type']) == 'average') {
                    $wind[$key]['location'][Transformer::parseWindCity((string)$areaForecastData->attributes()['area'])][(string)$areaForecastData->attributes()['area']]['wind'] = (string)$areaForecastData->WindData->Level;
                } else {
                    $wind[$key]['location'][Transformer::parseWindCity((string)$areaForecastData->attributes()['area'])][(string)$areaForecastData->attributes()['area']]['gust'] = (string)$areaForecastData->WindData->Level;
                }
            }

            $titlePreference = $preference['typhoon']['wind-forecast']['title'];
            $taiwanAllPreference = $preference['typhoon']['wind-forecast']['taiwan-all'];
            $taiwanEPreference = $preference['typhoon']['wind-forecast']['taiwan-e'];
            $taiwanMPreference = $preference['typhoon']['wind-forecast']['taiwan-m'];
            $taiwanNPreference = $preference['typhoon']['wind-forecast']['taiwan-n'];
            $taiwanSPreference = $preference['typhoon']['wind-forecast']['taiwan-s'];
            $toolLeftPreference = $preference['typhoon']['wind-forecast']['tool-left'];
            $toolRightPreference = $preference['typhoon']['wind-forecast']['tool-right'];
            $toolMiddlePreference = $preference['typhoon']['wind-forecast']['tool-middle'];
            $imageToolPreference = $preference['typhoon']['wind-forecast']['image-tool'];

            return [
                'meta' => [
                    'title' => [
                        'scale' => $titlePreference['scale'] ?? 100,
                        'point_x' => $titlePreference['point_x'] ?? 0,
                        'point_y' => $titlePreference['point_y'] ?? 0,
                    ],
                    'taiwan_all' => [
                        'scale' => $taiwanAllPreference['scale'] ?? 100,
                        'point_x' => $taiwanAllPreference['point_x'] ?? 0,
                        'point_y' => $taiwanAllPreference['point_y'] ?? 0,
                    ],
                    'taiwan_e' => [
                        'scale' => $taiwanEPreference['scale'] ?? 100,
                        'point_x' => $taiwanEPreference['point_x'] ?? 0,
                        'point_y' => $taiwanEPreference['point_y'] ?? 0,
                    ],
                    'taiwan_m' => [
                        'scale' => $taiwanMPreference['scale'] ?? 100,
                        'point_x' => $taiwanMPreference['point_x'] ?? 0,
                        'point_y' => $taiwanMPreference['point_y'] ?? 0,
                    ],
                    'taiwan_n' => [
                        'scale' => $taiwanNPreference['scale'] ?? 100,
                        'point_x' => $taiwanNPreference['point_x'] ?? 0,
                        'point_y' => $taiwanNPreference['point_y'] ?? 0,
                    ],
                    'taiwan_s' => [
                        'scale' => $taiwanSPreference['scale'] ?? 100,
                        'point_x' => $taiwanSPreference['point_x'] ?? 0,
                        'point_y' => $taiwanSPreference['point_y'] ?? 0,
                    ],
                    'tool_left' => [
                        'scale' => $toolLeftPreference['scale'] ?? 100,
                        'point_x' => $toolLeftPreference['point_x'] ?? 0,
                        'point_y' => $toolLeftPreference['point_y'] ?? 0,
                    ],
                    'tool_right' => [
                        'scale' => $toolRightPreference['scale'] ?? 100,
                        'point_x' => $toolRightPreference['point_x'] ?? 0,
                        'point_y' => $toolRightPreference['point_y'] ?? 0,
                    ],
                    'tool_middle' => [
                        'scale' => $toolMiddlePreference['scale'] ?? 100,
                        'point_x' => $toolMiddlePreference['point_x'] ?? 0,
                        'point_y' => $toolMiddlePreference['point_y'] ?? 0,
                    ],
                    'image_tool' => [
                        'scale' => $imageToolPreference['scale'] ?? 100,
                        'point_x' => $imageToolPreference['point_x'] ?? 0,
                        'point_y' => $imageToolPreference['point_y'] ?? 0,
                    ]
                ],
                'wind' => $wind
            ];
        } catch (Exception $exception) {
            throw new WFCException('風力預測資料解析錯誤', 500, $exception);
        }
    }
}
