<?php

namespace App\Services\WFC;

use App\Services\WFC\Exceptions\WFCException;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Finder;

class WindObservation
{
    /**
     * 風力觀測資料
     *
     * @param array $setting 圖資設定
     * @param array $preference 裝置設定
     * @return array
     * @throws WFCException
     */
    static public function get(array $setting, array $preference): array
    {
        try {
            $path = Storage::disk('data')->path($setting['wind-observation']['origin']);

            // 以名稱排序(A-Z)取最後一個
            $files = iterator_to_array(Finder::create()->files()->in($path)->sortByName(), false);
            $windObs = simplexml_load_file($files[count($files) - 1]->getPathname());

            $wind = [
                'startTime' => (string)$windObs->dataset->datasetInfo->validTime->startTime,
                'endTime' => (string)$windObs->dataset->datasetInfo->validTime->endTime,
            ];

            $location = ['n' => [], 'm' => [], 's' => [], 'e' => []];
            foreach ($windObs->dataset->location ?? [] as $loc) {
                if (empty($city = Transformer::parseLocation((string)$loc->locationName)))
                    continue;

                $location[Transformer::parseWindCity($city)][$city] = [
                    "wind" => (string)$loc->weatherElement[1]->time->parameter[2]->parameterValue,
                    "gust" => (string)$loc->weatherElement[2]->time->parameter[2]->parameterValue,
                ];
            }

            $wind['location'] = $location;

            $titlePreference = $preference['typhoon']['wind-observation']['title'];
            $taiwanAllPreference = $preference['typhoon']['wind-observation']['taiwan-all'];
            $taiwanEPreference = $preference['typhoon']['wind-observation']['taiwan-e'];
            $taiwanMPreference = $preference['typhoon']['wind-observation']['taiwan-m'];
            $taiwanNPreference = $preference['typhoon']['wind-observation']['taiwan-n'];
            $taiwanSPreference = $preference['typhoon']['wind-observation']['taiwan-s'];
            $toolLeftPreference = $preference['typhoon']['wind-observation']['tool-left'];
            $toolRightPreference = $preference['typhoon']['wind-observation']['tool-right'];
            $toolMiddlePreference = $preference['typhoon']['wind-observation']['tool-middle'];
            $imageToolPreference = $preference['typhoon']['wind-observation']['image-tool'];

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
                'wind' => $wind
            ];
        } catch (Exception $exception) {
            throw new WFCException('風力觀測資料解析錯誤', 500, $exception);
        }
    }
}
