<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Device;

class InserDevicePreferenceJson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $preference_json = '{"tool": {"colors": ["#274357", "#274357", "#274357", "#274357", "#274357", "#274357"]}, "typhoon": {"wind_forecast": {"title": {"point": ["0", "0"]}, "taiwan_e": {"point": ["0", "0"], "scale": "100"}, "taiwan_m": {"point": ["0", "0"], "scale": "100"}, "taiwan_n": {"point": ["0", "0"], "scale": "100"}, "taiwan_s": {"point": ["0", "0"], "scale": "100"}, "tool_left": {"point": ["0", "0"]}, "image_tool": {"point": ["0", "0"]}, "taiwan_all": {"point": ["0", "0"], "scale": "100"}, "tool_right": {"point": ["0", "0"]}, "tool_middle": {"point": ["0", "0"]}}, "typhoon_dynamics": {"title": {"point": ["0", "0"]}, "typhoon_ir": {"point": ["0", "0"], "scale": "100"}, "typhoon_mb": {"point": ["0", "0"], "scale": "100"}, "tool_middle": {"point": ["0", "0"]}, "typhoon_vis": {"point": ["0", "0"], "scale": "100"}}, "wind_observation": {"title": {"point": ["0", "0"]}, "taiwan_e": {"point": ["0", "0"], "scale": "100"}, "taiwan_m": {"point": ["0", "0"], "scale": "100"}, "taiwan_n": {"point": ["0", "0"], "scale": "100"}, "taiwan_s": {"point": ["0", "0"], "scale": "100"}, "tool_left": {"point": ["0", "0"]}, "image_tool": {"point": ["0", "0"]}, "taiwan_all": {"point": ["0", "0"], "scale": "100"}, "tool_right": {"point": ["0", "0"]}, "tool_middle": {"point": ["0", "0"]}}, "rainfall_forecast": {"title": {"point": ["0", "0"]}, "taiwan_e": {"point": ["0", "0"], "scale": "100"}, "taiwan_h": {"point": ["0", "0"], "scale": "100"}, "taiwan_m": {"point": ["0", "0"], "scale": "100"}, "taiwan_n": {"point": ["0", "0"], "scale": "100"}, "taiwan_s": {"point": ["0", "0"], "scale": "100"}, "taiwan_y": {"point": ["0", "0"], "scale": "100"}, "tool_left": {"point": ["0", "0"]}, "image_tool": {"point": ["0", "0"]}, "taiwan_all": {"point": ["0", "0"], "scale": "100"}, "tool_right": {"point": ["0", "0"]}, "tool_middle": {"point": ["0", "0"]}}, "typhoon_potential": {"title": {"point": ["0", "0"]}, "tool_middle": {"point": ["0", "0"]}}, "anchor_information": {"block": {"point": ["0", "0"]}}, "rainfall_observation": {"title": {"point": ["0", "0"]}, "taiwan_e": {"point": ["0", "0"], "scale": "100"}, "taiwan_h": {"point": ["0", "0"], "scale": "100"}, "taiwan_m": {"point": ["0", "0"], "scale": "100"}, "taiwan_n": {"point": ["0", "0"], "scale": "100"}, "taiwan_s": {"point": ["0", "0"], "scale": "100"}, "taiwan_y": {"point": ["0", "0"], "scale": "100"}, "tool_left": {"point": ["0", "0"]}, "image_tool": {"point": ["0", "0"]}, "taiwan_all": {"point": ["0", "0"], "scale": "100"}, "tool_right": {"point": ["0", "0"]}, "tool_middle": {"point": ["0", "0"]}}}, "weather": {"images": {"rainfall": {"point": ["0", "0"], "scale": "100"}, "global_ir": {"point": ["0", "0"], "scale": "100"}, "radar_echo": {"point": ["0", "0"], "scale": "100"}, "temperature": {"point": ["0", "0"], "scale": "100"}, "east_asia_ir": {"point": ["0", "0"], "scale": "100"}, "east_asia_mb": {"point": ["0", "0"], "scale": "100"}, "forecast_24h": {"point": ["0", "0"], "scale": "100"}, "east_asia_vis": {"point": ["0", "0"], "scale": "100"}, "weather_alert": {"point": ["0", "0"], "scale": "100"}, "weather_forecast": {"point": ["0", "0"], "scale": "100"}, "ultraviolet_light": {"point": ["0", "0"], "scale": "100"}, "numerical_forecast": {"point": ["0", "0"], "scale": "100"}, "surface_weather_map": {"point": ["0", "0"], "scale": "100"}, "wave_analysis_chart": {"point": ["0", "0"], "scale": "100"}, "precipitation_forecast_6h": {"point": ["0", "0"], "scale": "100"}, "precipitation_forecast_12h": {"point": ["0", "0"], "scale": "100"}}, "general": {"tool_left": {"point": ["0", "0"]}, "tool_right": {"point": ["0", "0"]}}, "weather_information": {"block": {"point": ["0", "0"]}}}}';
        $preference_json = json_decode($preference_json);
        $devices = Device::all();
        foreach ($devices as $device) {
            $device->preference_json = $preference_json;
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
