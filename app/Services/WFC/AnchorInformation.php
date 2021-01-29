<?php

namespace App\Services\WFC;

use App\Services\WFC\Exceptions\WFCException;
use App\Services\WFC\Traits\InformationTraits;

class AnchorInformation
{
    use InformationTraits;
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
        $blockPreference = $preference['typhoon']['anchor_information']['block'];

        return [
            'meta' => [
                'block' => [
                    'scale' => $blockPreference['scale'] ?? 100,
                    'point_x' => $blockPreference['point_x'] ?? 0,
                    'point_y' => $blockPreference['point_y'] ?? 0,
                ]
            ],
            'information' => self::format('主播圖卡', $setting, $preference)
        ];
    }
}
