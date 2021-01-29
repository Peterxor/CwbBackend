<?php

namespace App\Services\WFC;

use App\Models\TyphoonImage;
use App\Services\WFC\Exceptions\WFCException;
use Carbon\Carbon;
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
            $typhoonPotential = simplexml_load_file(Storage::disk('data')->path($setting['typhoon_potential']['origin']));

            $typhoon['current']['center']['point']['lat'] = (float)$typhoonPotential->TY_TRACK_POINT->center->point->lat;
            $typhoon['current']['center']['point']['lon'] = (float)$typhoonPotential->TY_TRACK_POINT->center->point->lon;
            $typhoon['current']['track']['points'] = [];

            foreach ($typhoonPotential->TY_TRACK_POINT->track->point as $point) {
                $typhoon['current']['track']['points'][] = [
                    'lat' => (float)$point->lat,
                    'lon' => (float)$point->lon
                ];
            }

            $currentTime = self::currentTime();

            $typhoon['fcst'] = [];
            foreach ($typhoonPotential->CIRCLE as $circle) {
                $tempTime = clone $currentTime;
                $tempTime->addHours((int)$circle->hour);

                $item['center']['point']['lat'] = (float)$circle->center->point->lat;
                $item['center']['point']['lon'] = (float)$circle->center->point->lon;
                $item['radius'] = (float)$circle->radius;
                $item['label'] =  $tempTime->format('m月d日 H:i');
                $item['track']['points'] = [];
                foreach ($circle->track->point as $point) {
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

            $titlePreference = $preference['typhoon']['typhoon_potential']['title'];
            $toolMiddlePreference = $preference['typhoon']['typhoon_potential']['tool_middle'];

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

    /**
     * 取得目前時間
     *
     * @return Carbon|false
     * @throws WFCException
     */
    static public function currentTime()
    {
        /** @var TyphoonImage $typhoonImage */
        $typhoonImage = TyphoonImage::query()->where('name', 'typhoon_dynamics')->first();
        $setting = $typhoonImage->content;
        $path = Storage::disk('data')->path($setting['typhoon_dynamics']['origin'] ?? '');

        try {
            $typhoonDynamics = simplexml_load_file($path);
            return Carbon::create((string)$typhoonDynamics->current->Point->Time);
        } catch (Exception $exception) {
            throw new WFCException('颱風潛勢[颱風動態]資料解析錯誤', 500, $exception);
        }
    }
}
