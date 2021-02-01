<?php

namespace App\Services\WFC;

use App\Services\WFC\Exceptions\WFCException;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Finder;

class RainfallForecast
{
    /**
     * 雨量預測資料
     *
     * @param array $setting 圖資設定
     * @param array $preference 裝置設定
     * @return array
     * @throws WFCException
     */
    static public function get(array $setting, array $preference): array
    {
        $titlePreference = $preference['typhoon']['rainfall_forecast']['title'];
        $taiwanAllPreference = $preference['typhoon']['rainfall_forecast']['taiwan_all'];
        $taiwanEPreference = $preference['typhoon']['rainfall_forecast']['taiwan_e'];
        $taiwanMPreference = $preference['typhoon']['rainfall_forecast']['taiwan_m'];
        $taiwanNPreference = $preference['typhoon']['rainfall_forecast']['taiwan_n'];
        $taiwanYPreference = $preference['typhoon']['rainfall_forecast']['taiwan_y'];
        $taiwanHPreference = $preference['typhoon']['rainfall_forecast']['taiwan_h'];
        $taiwanSPreference = $preference['typhoon']['rainfall_forecast']['taiwan_s'];
        $toolLeftPreference = $preference['typhoon']['rainfall_forecast']['tool_left'];
        $toolRightPreference = $preference['typhoon']['rainfall_forecast']['tool_right'];
        $toolMiddlePreference = $preference['typhoon']['rainfall_forecast']['tool_middle'];
        $imageToolPreference = $preference['typhoon']['rainfall_forecast']['image_tool'];

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
                'taiwan_y' => [
                    'scale' => $taiwanYPreference['scale'] ?? 100,
                    'point_x' => $taiwanYPreference['point_x'] ?? 0,
                    'point_y' => $taiwanYPreference['point_y'] ?? 0,
                ],
                'taiwan_h' => [
                    'scale' => $taiwanHPreference['scale'] ?? 100,
                    'point_x' => $taiwanHPreference['point_x'] ?? 0,
                    'point_y' => $taiwanHPreference['point_y'] ?? 0,
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
            'rainfall' => [
                'all' => self::format($setting['all_rainfall'] ?? [], '總雨量預測'),
                '24h' => self::format($setting['24h_rainfall'] ?? [], '24h雨量預測'),
            ]
        ];
    }

    /**
     * 雨量格式整理
     *
     * @param array $setting 圖資設定
     * @param string $title 圖資名稱
     * @return array
     * @throws WFCException
     */
    static private function format(array $setting, string $title): array
    {
        if (empty($setting))
            throw new WFCException('雨量預測[' . $title . ']資料解析錯誤', 500);

        try {
            $path = rtrim($setting['origin'], '/');

            // 以名稱排序(A-Z)取最後一個
            $files = iterator_to_array(Finder::create()->files()->in(Storage::disk('data')->path($path))->sortByName(), false);
            $rainfallForecast = simplexml_load_file($files[count($files) - 1]->getPathname());

            $data = ['alert_value' => (int)$setting['alert_value'], 'location' => ['n' => [], 'm' => [], 's' => [], 'e' => []]];

            if (isset($rainfallForecast->BulletinInformation->StartValidTime->Time) && isset($rainfallForecast->BulletinInformation->EndValidTime->Time)) {
                $data['startTime'] = (string)$rainfallForecast->BulletinInformation->StartValidTime->Time;
                $data['endTime'] = (string)$rainfallForecast->BulletinInformation->EndValidTime->Time;
            } else if (isset($rainfallForecast->BulletinInformation->IssueTime->Time)) {
                $data['time'] = (string)$rainfallForecast->BulletinInformation->IssueTime->Time;
            }

            foreach ($rainfallForecast->PrecipitationInformation->AreaForecastData ?? [] as $areaForecastData) {
                if (((string)$areaForecastData->Precipitation->attributes()['region']) == 'flat') {
                    $data['location'][Transformer::parseRainfallFcstCity((string)$areaForecastData->attributes()['area'])][(string)$areaForecastData->attributes()['area']]['flat'] = (string)$areaForecastData->Precipitation->Value;
                } else {
                    $data['location'][Transformer::parseRainfallFcstCity((string)$areaForecastData->attributes()['area'])][(string)$areaForecastData->attributes()['area']]['mountain'] = (string)$areaForecastData->Precipitation->Value;
                }
            }

            return $data;
        } catch (Exception $exception) {
            throw new WFCException('雨量預測[' . $title . ']資料解析錯誤', 500, $exception);
        }
    }
}
