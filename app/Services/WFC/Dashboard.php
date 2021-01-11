<?php

namespace App\Services\WFC;

use App\Services\WFC\Exceptions\WFCException;

class Dashboard
{
    /**
     * 首頁
     *
     * @param array $setting 圖資設定
     * @param array $preference 裝置設定
     * @return array
     * @throws WFCException
     */
    static public function get(array $setting, array $preference): array
    {
        return [
            'meta' => [],
            'data' => [
                'type' => 'default',
                'background' => '還沒想好',
                'user_1' => [
                    'name' => '伍婉華',
                    'nick-name' => '簡任技正',
                    'career' => '秘書室簡任技正',
                    'education' => '中央大學大氣物理研究所碩士',
                    'experience' => [
                        '第一組第二科科長',
                        '氣象預報中心技正',
                        '氣象預報中心資深預報員'
                    ]
                ],
                'user_2' => null,
                'current_press_conference' => [
                    'enable' => true,
                    'time' => '11 : 40 AM',
                ],
                'next_press_conference' => [
                    'enable' => true,
                    'time' => '14 : 40 AM'
                ]
            ]
        ];
    }
}
