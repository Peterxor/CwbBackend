<?php

namespace App\Services\WFC;

use App\Services\WFC\Exceptions\WFCException;
use Exception;
use Illuminate\Support\Facades\Storage;

class TyphoonPotential
{
    /**
     * 颱風潛勢
     *
     * @param array $setting 圖資設定
     * @param array $preference 裝置設定
     * @return array
     * @throws WFCException
     */
    static public function get(array $setting, array $preference): array
    {
        try {
            $typhoonPotential = simplexml_load_file(Storage::disk('data')->path($setting['typhoon-potential']['origin']));

            $typhoon['current']['center']['point']['lat'] = (float)$typhoonPotential->TY_TRACK_POINT->center->point->lat;
            $typhoon['current']['center']['point']['lon'] = (float)$typhoonPotential->TY_TRACK_POINT->center->point->lon;
            $typhoon['current']['track']['points'] = [];

            foreach ($typhoonPotential->TY_TRACK_POINT->track->point as $point){
                $typhoon['current']['track']['points'][] = [
                    'lat' => (float)$point->lat,
                    'lon' => (float)$point->lon
                ];
            }

            $typhoon['fcst'] = [];
            foreach ($typhoonPotential->CIRCLE as $circle) {
                $item['center']['point']['lat'] = (float)$circle->center->point->lat;
                $item['center']['point']['lon'] = (float)$circle->center->point->lon;
                $item['radius'] = (float)$circle->radius;
                $item['label'] = (int)$circle->hour;
                $item['track']['points'] = [];
                foreach ($circle->track->point as $point){
                    $item['track']['points'][] = [
                        'lat' => (float)$point->lat,
                        'lon' => (float)$point->lon
                    ];
                }
                $typhoon['fcst'][] = $item;
            }

            $typhoon['outer_line']['track']['points'] = [];

            foreach ($typhoonPotential->OUTER_LINE_POINT->track->point as $point) {
                $typhoon['outer_line']['track']['points'][] = [
                    'lat' => (float)$point->lat,
                    'lon' => (float)$point->lon
                ];
            }

            $titlePreference = $preference['typhoon']['typhoon-potential']['title'];
            $toolMiddlePreference = $preference['typhoon']['typhoon-potential']['tool-middle'];

            return [
                'meta' => [
                    'title' => [
                        'scale' => $titlePreference['scale'] ?? 100,
                        'point_x' => $titlePreference['point_x'] ?? 0,
                        'point_y' => $titlePreference['point_y'] ?? 0,
                    ],
                    'tool_middle' => [
                        'scale' => $toolMiddlePreference['scale'] ?? 100,
                        'point_x' => $toolMiddlePreference['point_x'] ?? 0,
                        'point_y' => $toolMiddlePreference['point_y'] ?? 0,
                    ]
                ],
                'typhoon' => $typhoon
            ];
        } catch (Exception $exception) {
            throw new WFCException('颱風潛勢資料解析錯誤', 500, $exception);
        }
    }
}
