<?php

namespace App\Services\WFC;

use App\Services\WFC\Exceptions\WFCException;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Finder;

class AnchorInformation
{
    /**
     * 主播圖卡
     *
     * @param array $setting 圖資設定
     * @param array $preference 裝置設定
     * @return array
     * @throws WFCException
     */
    static public function get(array $setting, array $preference): array
    {
        $blockPreference = $preference['typhoon']['anchor-information']['block'];
        return [
            'meta' => [
                'block' => [
                    'scale' => $blockPreference['scale'] ?? 100,
                    'point_x' => $blockPreference['point_x'] ?? 0,
                    'point_y' => $blockPreference['point_y'] ?? 0,
                ]
            ],
            'information' => [
                [
                    'mode' => 'gif',
                    'scale' => 150,
                    'point_x' => -10,
                    'point_y' => -10,
                    'interval' => 2000,
                    'title' => "東亞VIS",
                    'description' => '11/30 11:50 ~ 11/30 12:00',
                    'images' => [
                        url('test/2020-11-10_1510.BVIS.jpg'),
                        url('test/2020-11-10_1520.BVIS.jpg'),
                        url('test/2020-11-10_1530.BVIS.jpg'),
                    ],
                    'thumbnail' => url('test/2020-11-10_1530.BVIS.jpg')
                ], [
                    'mode' => 'abreast',
                    'scale' => 100,
                    'point_x' => 0,
                    'point_y' => 0,
                    'title' => "雨量",
                    'description' => '11/30 11:50 ~ 11/30 12:00',
                    'image_l' => url('test/2020-11-08_0540.QZJ4.png'),
                    'image_r' => url('test/2020-11-10_1050.QZJ4.png'),
                    'thumbnail' => url('test/2020-11-10_1050.QZJ4.png')
                ], [
                    'mode' => 'list',
                    'scale' => 100,
                    'point_x' => 0,
                    'point_y' => 0,
                    'title' => "地面天氣圖",
                    'description' => '11/30 11:50 ~ 11/30 12:00',
                    'images' => [
                        url('test/2020-1110-0000_SFCcomboHD.jpg'),
                        url('test/2020-1109-1800_SFCcomboHD.jpg'),
                        url('test/2020-1109-0000_SFCcomboHD.jpg'),
                        url('test/2020-1108-1800_SFCcomboHD.jpg'),
                    ],
                    'thumbnail' => url('test/2020-1110-0000_SFCcomboHD.jpg')
                ], [
                    'mode' => 'single',
                    'scale' => 100,
                    'point_x' => 0,
                    'point_y' => 5,
                    "title" => "紫外線",
                    'description' => '11/30 11:50 ~ 11/30 12:00',
                    'image' => url('test/UVI_Max.png'),
                    'thumbnail' => url('test/UVI_Max.png')
                ], [
                    'mode' => 'custom',
                    'scale' => 100,
                    'point_x' => 0,
                    'point_y' => 0,
                    "title" => "小叮嚀",
                    'description' => '',
                    'image' => url('test/天氣警報.png'),
                    'thumbnail' => url('test/天氣警報.png')
                ],
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

            $data = ['alert_value' => (int)$setting['alert_value'],'location' =>  ['n' => [], 'm' => [], 's' => [], 'e' => []]];
            foreach ($rainfallForecast->PrecipitationInformation->AreaForecastData ?? [] as $areaForecastData) {
                if(((string) $areaForecastData->Precipitation->attributes()['region']) == 'flat'){
                    $data['location'][Transformer::parseRainfallFcstCity((string) $areaForecastData->attributes()['area'])][(string) $areaForecastData->attributes()['area']]['flat'] =  (string) $areaForecastData->Precipitation->Value;
                } else {
                    $data['location'][Transformer::parseRainfallFcstCity((string) $areaForecastData->attributes()['area'])][(string) $areaForecastData->attributes()['area']]['mountain'] =  (string) $areaForecastData->Precipitation->Value;
                }
            }

            return $data;
        } catch (Exception $exception) {
            throw new WFCException('雨量預測[' . $title . ']資料解析錯誤', 500, $exception);
        }
    }
}
