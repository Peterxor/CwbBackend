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
//        dd($setting);
        $data = [];

        if ($setting['type'] === 1) {
            $data['type'] = 'default';
            $data['background'] = $setting['background_url'] ?? '';
            $data['user_1'] = $setting['personnel_a'] ? [
                'name' => $setting['personnel_a']['name'],
                'nick_name' => $setting['personnel_a']['nick_name'],
                'career' => $setting['personnel_a']['career'],
                'education' => $setting['personnel_a']['education'],
                'experience' => $setting['personnel_a']['experience'],
            ] : [];
            $data['user_2'] = $setting['personnel_b'] ? [
                'name' => $setting['personnel_b']['name'],
                'nick_name' => $setting['personnel_b']['nick_name'],
                'career' => $setting['personnel_b']['career'],
                'education' => $setting['personnel_b']['education'],
                'experience' => $setting['personnel_b']['experience'],
            ] : [];
            $data['current_press_conference'] = $setting['conference_status'] === 1 ? $setting['conference_time'] ?? null : null;
            $data['next_press_conference'] = $setting['next_conference_status'] === 1 ? $setting['next_conference_time'] ?? null : null;
        } else {
            $data['type'] = 'upload';
            $data['media_url'] = $setting['media']['url'] ?? '';
        }
        return [
            'meta' => [
                'theme' => $setting['themes'] ?? [],
                'color' => $preference['tool']['colors'] ?? [],
            ],
            'data' => $data
        ];
    }
}
