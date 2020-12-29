<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Device;

class UpdateDeviceJson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $temp = [
            'type' => 'origin',
            'img_id' => '1',
            'img_name' => '東亞VIS',
        ];
        $temp2 = [
            'type' => 'origin',
            'img_id' => '1',
            'img_name' => '颱風動態圖'
        ];
        $forecast_data = [];
        $typhoon_data = [];

        for ($i = 0; $i < 10; $i++) {
            $forecast_data[] = $temp;
            $typhoon_data[] = $temp2;
        }

        $forecast_json = json_encode($forecast_data);
        $typhoon_json = json_encode($typhoon_data);
        Device::where('id', 1)->update(['forecast_json' => $forecast_json]);
        Device::where('id', 1)->update(['typhoon_json' => $typhoon_json]);
        Device::where('id', 2)->update(['forecast_json' => $forecast_json]);
        Device::where('id', 2)->update(['typhoon_json' => $typhoon_json]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        $json = json_encode([]);
        Device::where('id', 1)->update(['forecast_json' => $json]);
        Device::where('id', 1)->update(['typhoon_json' => $json]);
        Device::where('id', 2)->update(['forecast_json' => $json]);
        Device::where('id', 2)->update(['typhoon_json' => $json]);

    }
}
