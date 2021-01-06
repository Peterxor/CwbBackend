<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            foreach ($typhoon['children'] ?? [] as $children){
                $data['typhoon'][$typhoon['name']][$children['name']]['scale'] = 100;
                $data['typhoon'][$typhoon['name']][$children['name']]['point'] = [0, 0];
            }
        }

        foreach (config('weatherlayout') as $typhoon) {
            foreach ($typhoon['children'] ?? [] as $children){
                $data['weather'][$typhoon['name']][$children['name']]['scale'] = 100;
                $data['weather'][$typhoon['name']][$children['name']]['point'] = [0, 0];
            }
        }

        \Illuminate\Support\Facades\DB::update("update device set preference_json = ?", array(json_encode($data)));

        $data = [
            'typhoon' => [],
            'weather' => []
        ];

        foreach (config('typhoonlayout') as $typhoon) {
            foreach ($typhoon['children'] ?? [] as $children){
                $data['typhoon'][$typhoon['name']][$children['name']]['point'] = [0, 0];
            }
        }

        foreach (config('weatherlayout') as $typhoon) {
            foreach ($typhoon['children'] ?? [] as $children){
                $data['weather'][$typhoon['name']][$children['name']]['point'] = [0, 0];
            }
        }

        \Illuminate\Support\Facades\DB::update("update host_preference set preference_json = ?", array(json_encode($data)));
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
