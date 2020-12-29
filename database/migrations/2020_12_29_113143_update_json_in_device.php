<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Device;

class UpdateJsonInDevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $json = '[{"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}]';
        Device::where('id', 1)->update(['typhoon_json' => $json]);
        Device::where('id', 1)->update(['forecast_json' => $json]);
        Device::where('id', 2)->update(['typhoon_json' => $json]);
        Device::where('id', 2)->update(['forecast_json' => $json]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $json = '[{"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}, {"type": "origin", "img_id": "1", "img_url": "/images/weather/東亞VIS.jpg", "img_name": "東亞VIS"}]';
        Device::where('id', 1)->update(['typhoon_json' => $json]);
        Device::where('id', 1)->update(['forecast_json' => $json]);
        Device::where('id', 2)->update(['typhoon_json' => $json]);
        Device::where('id', 2)->update(['forecast_json' => $json]);
    }
}
