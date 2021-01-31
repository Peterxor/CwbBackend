<?php


namespace App\Services\WFC;


use App\Models\GeneralImages;
use App\Services\WFC\Traits\InformationTraits;

class WeatherOverview
{
    use InformationTraits;

    /**
     * 一般天氣總攬資料
     *
     * @param array $preference 裝置設定
     * @return array
     * @throws Exceptions\WFCException
     */
    static public function get(array $preference): array
    {
        $generalImages = GeneralImages::query()->select(['name'])->orderBy('sort')->get();
        $setting = [];

        foreach ($generalImages as $generalImage){
            $setting[] = [
                'img_name' => $generalImage->name,
                'type' => 'origin'
            ];
        }

        $blockPreference = $preference['weather']['weather_information']['block'];
        return [
            'meta' => [
                'block' => [
                    'scale' => $blockPreference['scale'] ?? 100,
                    'point_x' => $blockPreference['point_x'] ?? 0,
                    'point_y' => $blockPreference['point_y'] ?? 0,
                ]
            ],
            'information' => self::format('一般天氣總攬', $setting, $preference)
        ];
    }
}
