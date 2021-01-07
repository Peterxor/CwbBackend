<?php

use App\Models\Device;
use App\Models\HostPreference;

if (!function_exists('getBackground')) {
    function getBackground($background)
    {
        switch ($background) {
            default:
            case 0:
                return [
                    [
                        'name' => '雲朵版',
                        'value' => 1,
                    ]
                ];
            case 1:
                return '雲朵版';
        }
    }
}

if (!function_exists('getTheme')) {
    function getTheme($theme)
    {
        switch ($theme) {
            case 0:
                return [
                    [
                        'name' => '自然',
                        'value' => 1,
                    ],
                    [
                        'name' => '科技藍',
                        'value' => 2,
                    ],
                    [
                        'name' => '工業橘',
                        'value' => 3,
                    ],
                    [
                        'name' => '現代紅',
                        'value' => 4,
                    ]
                ];
            default:
            case 1:
                return '自然';
            case 2:
                return '科技藍';
            case 3:
                return '工業橘';
            case 4:
                return '現代紅';
        }
    }
}


if (!function_exists('preference')) {
    function preference($device_id): array
    {
        /** @var Device $device */
        $device = Device::query()->find($device_id);
        /** @var HostPreference $hostPreference */
        $hostPreference = HostPreference::query()->firstOrCreate(['user_id' => $device->user_id, 'device_id' => $device_id]);

        return array_merge($device->preference_json, $hostPreference->preference_json ?? []);
    }
}
