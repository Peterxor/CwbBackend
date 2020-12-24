<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TyphoonImage;

class InsertTyphoonTableData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $typhoon_move = [
            'type' => 1,
            'info' => [
                'origin' => '/天氣演示圖資範例/xml (颱風)/newpta.xml',
                'move_pages' => 10,
                'change_rate_second' => 0.35,
            ],
            'show_info' => [
                'ir' => [
                    'origin' => '/天氣演示圖資範例/xml (颱風)/newpta.xml',
                    'move_pages' => 10,
                    'change_rate_page' => 6,
                ],
                'mb' => [
                    'origin' => '/天氣演示圖資範例/xml (颱風)/newpta.xml',
                    'move_pages' => 10,
                    'change_rate_page' => 7,
                ],
                'vis' => [
                    'origin' => '/天氣演示圖資範例/xml (颱風)/newpta.xml',
                    'move_pages' => 10,
                    'change_rate_page' => 8,
                ]
            ]
        ];

        $typhoon_potential = [
            'type' => 2,
            'info' => [
                'origin' => '/天氣演示圖資範例/xml (颱風)/newpta.xml',
                'move_pages' => 10,
                'change_rate_second' => 0.35,
            ]
        ];

        $wind_observe = [
            'type' => 3,
            'info' => [
                'origin' => '/天氣演示圖資範例/xml (颱風)/newpta.xml',
            ]
        ];

        $wind_prediction = [
            'type' => 4,
            'info' => [
                'origin' => '/天氣演示圖資範例/xml (颱風)/newpta.xml',
            ]
        ];

        $rain_observe = [
            'type' => 5,
            'info' => [
                'origin_word' => '/天氣演示圖資範例/xml (颱風)/newpta.xml',
                'origin_pic' => '/天氣演示圖資範例/xml (颱風)/newpta.xml',
                'move_pages' => 10,
                'change_rate_second' => 0.35,
            ],
            'timezone_rain' => [
                'one_day_before' => [
                    'status' => 1, // 1: 啟用 2: 停用
                    'word' => 'D:\Contents\Broadcast\ty\txt\pre10\before1nd',
                    'pic' => 'D:\Contents\Broadcast\ty\images\preci\before1nd',
                ],
                'two_day_before' => [
                    'status' => 1, // 1: 啟用 2: 停用
                    'word' => 'D:\Contents\Broadcast\ty\txt\pre10\before1nd',
                    'pic' => 'D:\Contents\Broadcast\ty\images\preci\before1nd',
                ],
                'three_day_before' => [
                    'status' => 1, // 1: 啟用 2: 停用
                    'word' => 'D:\Contents\Broadcast\ty\txt\pre10\before1nd',
                    'pic' => 'D:\Contents\Broadcast\ty\images\preci\before1nd',
                ],
                'four_day_before' => [
                    'status' => 1, // 1: 啟用 2: 停用
                    'word' => 'D:\Contents\Broadcast\ty\txt\pre10\before1nd',
                    'pic' => 'D:\Contents\Broadcast\ty\images\preci\before1nd',
                ]
            ],
            'location_rain' => [
                'one_day_before' => [
                    'status' => 1, // 1: 啟用 2: 停用
                    'word' => 'D:\Contents\Broadcast\ty\txt\pre10\before1nd',
                ],
                'two_day_before' => [
                    'status' => 1, // 1: 啟用 2: 停用
                    'word' => 'D:\Contents\Broadcast\ty\txt\pre10\before1nd',
                ],
                'three_day_before' => [
                    'status' => 1, // 1: 啟用 2: 停用
                    'word' => 'D:\Contents\Broadcast\ty\txt\pre10\before1nd',
                ],
                'four_day_before' => [
                    'status' => 1, // 1: 啟用 2: 停用
                    'word' => 'D:\Contents\Broadcast\ty\txt\pre10\before1nd',
                ]
            ]
        ];

        $rain_prediction = [
            'type' => 6,
            'info' => [
                'origin' => 'D:\Contents\Broadcast\ty\txt\pre10\before1nd',
                'alert_value' => 600,
                'origin24' => 'D:\Contents\Broadcast\ty\txt\pre10\before1nd',
                'alert_value_24' => 150,
            ]
        ];
        $json_typhoon_move = json_encode($typhoon_move);
        $json_typhoon_potential = json_encode($typhoon_potential);
        $json_wind_observe = json_encode($wind_observe);
        $json_wind_prediction = json_encode($wind_prediction);
        $json_rain_observe = json_encode($rain_observe);
        $json_rain_prediction = json_encode($rain_prediction);

        TyphoonImage::create([
            'name' => '颱風動態圖',
            'content' => $json_typhoon_move,
            'sort' => 1,
        ]);

        TyphoonImage::create([
            'name' => '颱風潛勢圖',
            'content' => $json_typhoon_potential,
            'sort' => 2,
        ]);

        TyphoonImage::create([
            'name' => '風力觀測',
            'content' => $json_wind_observe,
            'sort' => 3,
        ]);

        TyphoonImage::create([
            'name' => '風力預測',
            'content' => $json_wind_prediction,
            'sort' => 4,
        ]);

        TyphoonImage::create([
            'name' => '雨量觀測',
            'content' => $json_rain_observe,
            'sort' => 5,
        ]);

        TyphoonImage::create([
            'name' => '雨量預測',
            'content' => $json_rain_prediction,
            'sort' => 6
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        TyphoonImage::delete();
    }
}
