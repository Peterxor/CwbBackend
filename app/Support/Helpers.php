<?php

if (!function_exists('getBackground')) {
    function getBackground($background)
    {
        switch ($background) {
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
