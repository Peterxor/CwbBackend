<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\GeneralImages;

class InsertGeneralImageData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $content = [
            "type" => "1",
            "data_origin" => "D:\Contents\Broadcast\images\sat_weather\asia_vis"
        ];
        $json_content = json_encode($content);
        GeneralImages::create([
            'name' => '東亞VIS',
            'sort' => 0,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '東亞MB',
            'sort' => 1,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '東亞IR',
            'sort' => 2,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '地面天氣圖',
            'sort' => 3,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '全球IR',
            'sort' => 4,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '紫外線',
            'sort' => 5,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '雷達回波',
            'sort' => 6,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '溫度',
            'sort' => 7,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '雨量',
            'sort' => 8,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '數值預報',
            'sort' => 9,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '定量降水預報12小時',
            'sort' => 10,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '定量降水預報6小時',
            'sort' => 11,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '24H預測',
            'sort' => 12,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '天氣預測',
            'sort' => 13,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '波浪分析圖',
            'sort' => 14,
            'content' => $json_content,
        ]);
        GeneralImages::create([
            'name' => '天氣警報',
            'sort' => 15,
            'content' => $json_content,
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
        GeneralImages::truncate();
    }
}
