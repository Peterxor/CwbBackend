<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Device;

class UpdateDeviceForecastJsonTyphoonJson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $typhoon_forecast_json = '[{"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "east_asia_vis"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "east_asia_vis"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "east_asia_vis"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "east_asia_vis"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "east_asia_vis"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "east_asia_vis"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "east_asia_vis"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "east_asia_vis"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "east_asia_vis"}]';
        $typhoon_forecast_json = json_decode($typhoon_forecast_json);
        $devices = Device::all();
        foreach ($devices as $device) {
            $device->forecast_json = $typhoon_forecast_json;
            $device->typhoon_json = $typhoon_forecast_json;
            $device->save();
        }
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
