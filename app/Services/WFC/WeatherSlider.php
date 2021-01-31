<?php


namespace App\Services\WFC;


use App\Services\WFC\Traits\InformationTraits;

class WeatherSlider
{
    use InformationTraits;

    /**
     * 一般天氣預報資料
     *
     * @param array $setting 圖資設定
     * @param array $preference 裝置設定
     * @return array
     * @throws Exceptions\WFCException
     */
    static public function get(array $setting, array $preference): array
    {
        $blockPreference = $preference['weather']['weather_information']['block'];
        return [
            'meta' => [
                'block' => [
                    'scale' => $blockPreference['scale'] ?? 100,
                    'point_x' => $blockPreference['point_x'] ?? 0,
                    'point_y' => $blockPreference['point_y'] ?? 0,
                ]
            ],
            'information' => self::format('一般天氣預報', $setting, $preference)
        ];
    }
}
