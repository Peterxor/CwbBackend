<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForecastJsonTyphoonJsonToHostPreference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('host_preference', function (Blueprint $table) {
            //
            $table->json('typhoon_json')->after('device_id')->nullable()->comment('颱風主播圖卡');
            $table->json('forecast_json')->after('typhoon_json')->nullable()->comment('天氣預報排程');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('host_preference', function (Blueprint $table) {
            //
            $table->dropColumn('typhoon_json');
            $table->dropColumn('forecast_json');
        });
    }

}
