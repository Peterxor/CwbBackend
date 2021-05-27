<?php

namespace App\Services\WFC;

use App\Services\WFC\Exceptions\WFCException;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Finder;

class RainfallObservation
{
    /**
     * 雨量觀測資料
     *
     * @param array $setting 圖資設定
     * @param array $preference 裝置設定
     * @return array
     * @throws WFCException
     */
    static public function get(array $setting, array $preference): array
    {
        if (!isset($setting['amount']))
            throw new WFCException('雨量觀測[動態組圖張數]資料解析錯誤', 500);

        if (!isset($setting['interval']))
            throw new WFCException('雨量觀測[換圖速率]資料解析錯誤', 500);

        $titlePreference = $preference['typhoon']['rainfall_observation']['title'];
        $taiwanAllPreference = $preference['typhoon']['rainfall_observation']['taiwan_all'];
        $taiwanEPreference = $preference['typhoon']['rainfall_observation']['taiwan_e'];
        $taiwanMPreference = $preference['typhoon']['rainfall_observation']['taiwan_m'];
        $taiwanNPreference = $preference['typhoon']['rainfall_observation']['taiwan_n'];
        $taiwanYPreference = $preference['typhoon']['rainfall_observation']['taiwan_y'];
        $taiwanHPreference = $preference['typhoon']['rainfall_observation']['taiwan_h'];
        $taiwanSPreference = $preference['typhoon']['rainfall_observation']['taiwan_s'];
        $toolLeftPreference = $preference['typhoon']['rainfall_observation']['tool_left'];
        $toolRightPreference = $preference['typhoon']['rainfall_observation']['tool_right'];
        $toolMiddlePreference = $preference['typhoon']['rainfall_observation']['tool_middle'];
        $imageToolPreference = $preference['typhoon']['rainfall_observation']['image_tool'];

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
                'today' => self::format('今日雨量', $setting['today'] ?? [], $setting['amount'], $setting['interval']),
                'before1nd' => self::format('前一日雨量', $setting['before1nd'] ?? [], $setting['amount'], $setting['interval']),
                'before2nd' => self::format('前二日雨量', $setting['before2nd'] ?? [], $setting['amount'], $setting['interval']),
                'before3nd' => self::format('前三日雨量', $setting['before3nd'] ?? [], $setting['amount'], $setting['interval']),
                'before4nd' => self::format('前四日雨量', $setting['before4nd'] ?? [], $setting['amount'], $setting['interval']),
            ]
        ];
    }

    /**
     * 雨量格式整理
     *
     * @param string $title 圖資名稱
     * @param array $setting 圖資設定
     * @param int $amount GIF張數
     * @param int $interval 間隔時間(毫秒)
     * @return array
     * @throws WFCException
     */
    static private function format(string $title, array $setting, int $amount, int $interval): array
    {
        if (empty($setting))
            throw new WFCException('雨量觀測[' . $title . ']資料解析錯誤', 500);

        try {
            $data = [
                'enable' => $setting['status'] == 1,
                'title' => '雨量觀測',
                'startTime' => '',
                'endTime' => '',
                'mode' => 'gif',
                'interval' => $interval,
                'images' => imagesUrl($setting['image_origin'], $amount),
                'top' => ['c' => [], 'a' => [], 'n' => [], 'm' => [], 's' => [], 'y' => [], 'h' => [], 'e' => []],
                'location' => ['n' => [], 'm' => [], 's' => [], 'y' => [], 'h' => [], 'e' => []]];

            $dataOrigin = rtrim($setting['data_origin'], '/');

            // 以名稱排序(A-Z)取最後一個
            $files = iterator_to_array(Finder::create()->files()->in(Storage::disk('data')->path($dataOrigin))->sortByName(), false);
            $txt = fopen($files[count($files) - 1]->getPathname(), 'r');


            if (!feof($txt))
                fgets($txt);

            if (!feof($txt)) {
                $str = self::txtDecode(fgets($txt));
                $strArr = explode(" ", $str);
                if (count($strArr) >= 5) {
                    $data['startTime'] = Carbon::create($strArr[0] . ' ' . $strArr[1])->toDateTimeLocalString() . '+08:00';
                    $data['endTime'] = Carbon::create($strArr[3] . ' ' . $strArr[4])->toDateTimeLocalString() . '+08:00';
                }
            }

            $topCity = [];

            while (!feof($txt)) {
                $str = self::txtDecode(fgets($txt));
                $strArr = explode(" ", $str);
                if (count($strArr) < 3)
                    continue;

                $strArr[2] = str_replace('台', '臺', $strArr[2]);

                $area = Transformer::parseAddress($strArr[2]);
                if (count($area) == 0 || empty(Transformer::parseRainfallObsCity($area[0]))) {
                    Log::warning('雨量觀測[測站資料]資料解析錯誤:' . $str);
                    continue;
                }

                // 全臺測站排名
                if (count($data['top']['a']) < 5) {
                    $data['top']['a'][] = [
                        'city' => $area[0],
                        'area' => $area[1],
                        'site' => $strArr[1],
                        'value' => (float)$strArr[0]
                    ];
                }

                // 全臺縣市排名
                if (count($data['top']['c']) < 5 && !in_array($area[0], $topCity)) {
                    $data['top']['c'][] = [
                        'city' => $area[0],
                        'area' => $area[1],
                        'site' => $strArr[1],
                        'value' => (float)$strArr[0]
                    ];
                    $topCity[] = $area[0];
                }

                $rainfallObsCity = Transformer::parseRainfallObsCity($area[0]);

                $cityArray = [$rainfallObsCity];

                if ($area[0] == '宜蘭縣')
                    $cityArray[] = 'n';

                foreach ($cityArray as $city) {
                    if (count($data['top'][$city]) < 5) {
                        $data['top'][$city][] = [
                            'city' => $area[0],
                            'area' => $area[1],
                            'site' => $strArr[1],
                            'value' => (float)$strArr[0]
                        ];
                    }

                    if (array_key_exists($area[0], $data['location'][$city])) {
                        continue;
                    }
                    $data['location'][$city][$area[0]] = [
                        'value' => (float)$strArr[0]
                    ];
                }
            }

            fclose($txt);

            return $data;
        } catch (Exception $exception) {
            throw new WFCException('雨量觀測[' . $title . ']資料解析錯誤', 500, $exception);
        }
    }

    /**
     * 轉換文字編碼
     *
     * @param string $line 一行文字
     * @return string
     */
    static private function txtDecode(string $line): string
    {
        return trim(preg_replace("/\s(?=\s)/", "\\1",
            mb_convert_encoding($line, "UTF-8", "BIG5")));
    }
}
