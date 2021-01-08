<?php

namespace App\Services\WFC;

use App\Services\WFC\Exceptions\WFCException;
use Carbon\Carbon;
use Exception;
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

        $titlePreference = $preference['typhoon']['rainfall-observation']['title'];
        $taiwanAllPreference = $preference['typhoon']['rainfall-observation']['taiwan-all'];
        $taiwanEPreference = $preference['typhoon']['rainfall-observation']['taiwan-e'];
        $taiwanMPreference = $preference['typhoon']['rainfall-observation']['taiwan-m'];
        $taiwanNPreference = $preference['typhoon']['rainfall-observation']['taiwan-n'];
        $taiwanYPreference = $preference['typhoon']['rainfall-observation']['taiwan-y'];
        $taiwanHPreference = $preference['typhoon']['rainfall-observation']['taiwan-h'];
        $taiwanSPreference = $preference['typhoon']['rainfall-observation']['taiwan-s'];
        $toolLeftPreference = $preference['typhoon']['rainfall-observation']['tool-left'];
        $toolRightPreference = $preference['typhoon']['rainfall-observation']['tool-right'];
        $toolMiddlePreference = $preference['typhoon']['rainfall-observation']['tool-middle'];
        $imageToolPreference = $preference['typhoon']['rainfall-observation']['image-tool'];

        return [
            'meta' => [
                'title' => [
                    'scale' => $titlePreference['scale'] ?? 100,
                    'point_x' => $titlePreference['point_x'] ?? 0,
                    'point_y' => $titlePreference['point_y'] ?? 0,
                ],
                'taiwan-all' => [
                    'scale' => $taiwanAllPreference['scale'] ?? 100,
                    'point_x' => $taiwanAllPreference['point_x'] ?? 0,
                    'point_y' => $taiwanAllPreference['point_y'] ?? 0,
                ],
                'taiwan-e' => [
                    'scale' => $taiwanEPreference['scale'] ?? 100,
                    'point_x' => $taiwanEPreference['point_x'] ?? 0,
                    'point_y' => $taiwanEPreference['point_y'] ?? 0,
                ],
                'taiwan-m' => [
                    'scale' => $taiwanMPreference['scale'] ?? 100,
                    'point_x' => $taiwanMPreference['point_x'] ?? 0,
                    'point_y' => $taiwanMPreference['point_y'] ?? 0,
                ],
                'taiwan-n' => [
                    'scale' => $taiwanNPreference['scale'] ?? 100,
                    'point_x' => $taiwanNPreference['point_x'] ?? 0,
                    'point_y' => $taiwanNPreference['point_y'] ?? 0,
                ],
                'taiwan-y' => [
                    'scale' => $taiwanYPreference['scale'] ?? 100,
                    'point_x' => $taiwanYPreference['point_x'] ?? 0,
                    'point_y' => $taiwanYPreference['point_y'] ?? 0,
                ],
                'taiwan-h' => [
                    'scale' => $taiwanHPreference['scale'] ?? 100,
                    'point_x' => $taiwanHPreference['point_x'] ?? 0,
                    'point_y' => $taiwanHPreference['point_y'] ?? 0,
                ],
                'taiwan-s' => [
                    'scale' => $taiwanSPreference['scale'] ?? 100,
                    'point_x' => $taiwanSPreference['point_x'] ?? 0,
                    'point_y' => $taiwanSPreference['point_y'] ?? 0,
                ],
                'tool-left' => [
                    'scale' => $toolLeftPreference['scale'] ?? 100,
                    'point_x' => $toolLeftPreference['point_x'] ?? 0,
                    'point_y' => $toolLeftPreference['point_y'] ?? 0,
                ],
                'tool-right' => [
                    'scale' => $toolRightPreference['scale'] ?? 100,
                    'point_x' => $toolRightPreference['point_x'] ?? 0,
                    'point_y' => $toolRightPreference['point_y'] ?? 0,
                ],
                'tool-middle' => [
                    'scale' => $toolMiddlePreference['scale'] ?? 100,
                    'point_x' => $toolMiddlePreference['point_x'] ?? 0,
                    'point_y' => $toolMiddlePreference['point_y'] ?? 0,
                ],
                'image-tool' => [
                    'scale' => $imageToolPreference['scale'] ?? 100,
                    'point_x' => $imageToolPreference['point_x'] ?? 0,
                    'point_y' => $imageToolPreference['point_y'] ?? 0,
                ]
            ],
            'rainfall' => [
                'today' => self::format($setting['today'] ?? [], $setting['amount'], $setting['interval'], '今日雨量'),
                'before1nd' => self::format($setting['before1nd'] ?? [], $setting['amount'], $setting['interval'], '前一日雨量'),
                'before2nd' => self::format($setting['before2nd'] ?? [], $setting['amount'], $setting['interval'], '前二日雨量'),
                'before3nd' => self::format($setting['before3nd'] ?? [], $setting['amount'], $setting['interval'], '前三日雨量'),
                'before4nd' => self::format($setting['before4nd'] ?? [], $setting['amount'], $setting['interval'], '前四日雨量'),
            ]
        ];
    }

    /**
     * 雨量格式整理
     *
     * @param array $setting 圖資設定
     * @param int $amount GIF張數
     * @param int $interval 間隔時間(毫秒)
     * @param string $title 圖資名稱
     * @return array
     * @throws WFCException
     */
    static private function format(array $setting, int $amount, int $interval, string $title): array
    {
        if (empty($setting))
            throw new WFCException('雨量觀測[' . $title . ']資料解析錯誤', 500);

        try {
            $data = ['enable' => $setting['status'] == 1, 'title' => '雨量觀測', 'startTime' => '', 'endTime' => '', 'mode' => 'gif', 'interval' => $interval, 'images' => '', 'top' => ['c' => [], 'a' => [], 'n' => [], 'm' => [], 's' => [], 'y' => [], 'h' => [], 'e' => []], 'location' => ['n' => [], 'm' => [], 's' => [], 'y' => [], 'h' => [], 'e' => []]];

            $imageOrigin = rtrim($setting['image-origin'], '/');

            // 以名稱排序(A-Z)取最後一個
            $files = array_reverse(iterator_to_array(Finder::create()->files()->in(Storage::disk('data')->path($imageOrigin))->sortByName(), false));
            $images = [];
            foreach ($files as $key => $file) {
                if ($key >= $amount)
                    continue;
                $images[] = Storage::disk('data')->url($imageOrigin . $file->getBasename());
            }

            $dataOrigin = rtrim($setting['data-origin'], '/');

            $data['images'] = array_reverse($images);

            // 以名稱排序(A-Z)取最後一個
            $files = iterator_to_array(Finder::create()->files()->in(Storage::disk('data')->path($dataOrigin))->sortByName(), false);
            $txt = fopen($files[count($files) - 1]->getPathname(), 'r');


            if (!feof($txt))
                fgets($txt);

            if (!feof($txt)) {
                $str = self::txtDecode(fgets($txt));
                if (!empty($str)) {
                    $strArr = explode(" ", $str);
                    $data['startTime'] = Carbon::create($strArr[0] . ' ' . $strArr[1])->toDateTimeLocalString() . '+08:00';
                    $data['endTime'] = Carbon::create($strArr[3] . ' ' . $strArr[4])->toDateTimeLocalString() . '+08:00';
                }
            }

            while (!feof($txt)) {
                $str = self::txtDecode(fgets($txt));
                if (empty($str))
                    continue;
                $strArr = explode(" ", $str);
                $area = Transformer::parseAddress($strArr[2]);

                if (count($data['top']['a']) < 5) {
                    $data['top']['a'][] = [
                        'city' => $area[0],
                        'area' => $strArr[1],
                        'value' => (float)$strArr[0]
                    ];
                }

                if (count($data['top'][Transformer::parseRainfallObsCity($area[0])]) < 5) {
                    $data['top'][Transformer::parseRainfallObsCity($area[0])][] = [
                        'city' => $area[0],
                        'area' => $strArr[1],
                        'value' => (float)$strArr[0]
                    ];
                }

                if (array_key_exists($area[0], $data['location'][Transformer::parseRainfallObsCity($area[0])])) {
                    continue;
                }
                $data['location'][Transformer::parseRainfallObsCity($area[0])][$area[0]] = [
                    'value' => (float)$strArr[0]
                ];

                if (count($data['top']['c']) < 5) {
                    $data['top']['c'][] = [
                        'city' => $area[0],
                        'area' => $area[1],
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