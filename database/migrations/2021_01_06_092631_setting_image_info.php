<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SettingImageInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            'typhoon' => [],
            'weather' => []
        ];

        foreach (config('typhoonlayout') as $typhoon) {
            foreach ($typhoon['children'] ?? [] as $children) {
                $data['typhoon'][$typhoon['name']][$children['name']]['scale'] = 100;
                $data['typhoon'][$typhoon['name']][$children['name']]['point_x'] = 0;
                $data['typhoon'][$typhoon['name']][$children['name']]['point_y'] = 0;
            }
        }

        foreach (config('weatherlayout') as $weather) {
            foreach ($weather['children'] ?? [] as $children) {
                $data['weather'][$weather['name']][$children['name']]['scale'] = 100;
                $data['weather'][$weather['name']][$children['name']]['point_x'] = 0;
                $data['weather'][$weather['name']][$children['name']]['point_y'] = 0;
            }
        }

        DB::update("update device set preference_json = ?", array(json_encode($data)));

        $data = [
            'typhoon' => [],
            'weather' => []
        ];

        foreach (config('typhoonlayout') as $typhoon) {
            foreach ($typhoon['children'] ?? [] as $children) {
                $data['typhoon'][$typhoon['name']][$children['name']]['point_x'] = 0;
                $data['typhoon'][$typhoon['name']][$children['name']]['point_y'] = 0;
            }
        }

        foreach (config('weatherlayout') as $weather) {
            foreach ($weather['children'] ?? [] as $children) {
                $data['weather'][$weather['name']][$children['name']]['point_x'] = 0;
                $data['weather'][$weather['name']][$children['name']]['point_y'] = 0;
            }
        }

        DB::update("update host_preference set preference_json = ?", array(json_encode($data)));

        DB::update("update typhoon_images set name = ? , content = ? where name = ?", array('typhoon-dynamics', '{"display_name": "颱風動態圖"}', '颱風動態圖'));
        DB::update("update typhoon_images set name = ? , content = ? where name = ?", array('typhoon-potential', '{"display_name": "颱風潛勢圖"}', '颱風潛勢圖'));
        DB::update("update typhoon_images set name = ? , content = ? where name = ?", array('wind-observation', '{"display_name": "風力觀測"}', '風力觀測'));
        DB::update("update typhoon_images set name = ? , content = ? where name = ?", array('wind-forecast', '{"display_name": "風力預測"}', '風力預測'));
        DB::update("update typhoon_images set name = ? , content = ? where name = ?", array('rainfall-observation', '{"display_name": "雨量觀測"}', '雨量觀測'));
        DB::update("update typhoon_images set name = ? , content = ? where name = ?", array('rainfall-forecast', '{"display_name": "雨量預測"}', '雨量預測'));

        DB::update("update general_images set name = ? , content = ? where name = ?", array('east-asia-vis', '{"display_name": "東亞VIS"}', '東亞VIS'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('east-asia-mb', '{"display_name": "東亞MB"}', '東亞MB'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('east-asia-ir', '{"display_name": "東亞IR"}', '東亞IR'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('surface-weather-map', '{"display_name": "地面天氣圖"}', '地面天氣圖'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('global-ir', '{"display_name": "全球IR"}', '全球IR'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('ultraviolet-light', '{"display_name": "紫外線"}', '紫外線'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('radar-echo', '{"display_name": "雷達回波"}', '雷達回波'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('temperature', '{"display_name": "溫度"}', '溫度'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('rainfall', '{"display_name": "雨量"}', '雨量'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('numerical-forecast', '{"display_name": "數值預報"}', '數值預報'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('precipitation-forecast-12h', '{"display_name": "定量降水預報12小時"}', '定量降水預報12小時'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('precipitation-forecast-6h', '{"display_name": "定量降水預報6小時"}', '定量降水預報6小時'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('forecast-24h', '{"display_name": "24H預測"}', '24H預測'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('weather-forecast', '{"display_name": "天氣預測"}', '天氣預測'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('wave-analysis-chart', '{"display_name": "波浪分析圖"}', '波浪分析圖'));
        DB::update("update general_images set name = ? , content = ? where name = ?", array('weather-alert', '{"display_name": "天氣警報"}', '天氣警報'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
