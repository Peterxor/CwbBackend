<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Device;

class UpdateDevicePreference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $preference_json = '{"tool": {"colors": ["#274357", "#274357", "#274357", "#274357", "#274357", "#274357"]}, "typhoon": {"wind_forecast": {"title": {"point_x": "0", "point_y": "0"}, "taiwan_e": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_m": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_n": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_s": {"scale": "100", "point_x": "0", "point_y": "0"}, "tool_left": {"point_x": "0", "point_y": "0"}, "image_tool": {"point_x": "0", "point_y": "0"}, "taiwan_all": {"scale": "100", "point_x": "0", "point_y": "0"}, "tool_right": {"point_x": "0", "point_y": "0"}, "tool_middle": {"point_x": "0", "point_y": "0"}}, "typhoon_dynamics": {"title": {"point_x": "0", "point_y": "0"}, "typhoon_ir": {"scale": "100", "point_x": "0", "point_y": "0"}, "typhoon_mb": {"scale": "100", "point_x": "0", "point_y": "0"}, "tool_middle": {"point_x": "0", "point_y": "0"}, "typhoon_vis": {"scale": "100", "point_x": "0", "point_y": "0"}}, "wind_observation": {"title": {"point_x": "0", "point_y": "0"}, "taiwan_e": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_m": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_n": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_s": {"scale": "100", "point_x": "0", "point_y": "0"}, "tool_left": {"point_x": "0", "point_y": "0"}, "image_tool": {"point_x": "0", "point_y": "0"}, "taiwan_all": {"scale": "100", "point_x": "0", "point_y": "0"}, "tool_right": {"point_x": "0", "point_y": "0"}, "tool_middle": {"point_x": "0", "point_y": "0"}}, "rainfall_forecast": {"title": {"point_x": "0", "point_y": "0"}, "taiwan_e": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_h": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_m": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_n": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_s": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_y": {"scale": "100", "point_x": "0", "point_y": "0"}, "tool_left": {"point_x": "0", "point_y": "0"}, "image_tool": {"point_x": "0", "point_y": "0"}, "taiwan_all": {"scale": "100", "point_x": "0", "point_y": "0"}, "tool_right": {"point_x": "0", "point_y": "0"}, "tool_middle": {"point_x": "0", "point_y": "0"}}, "typhoon_potential": {"title": {"point_x": "0", "point_y": "0"}, "tool_middle": {"point_x": "0", "point_y": "0"}}, "anchor_information": {"block": {"point_x": "0", "point_y": "0"}}, "rainfall_observation": {"title": {"point_x": "0", "point_y": "0"}, "taiwan_e": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_h": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_m": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_n": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_s": {"scale": "100", "point_x": "0", "point_y": "0"}, "taiwan_y": {"scale": "100", "point_x": "0", "point_y": "0"}, "tool_left": {"point_x": "0", "point_y": "0"}, "image_tool": {"point_x": "0", "point_y": "0"}, "taiwan_all": {"scale": "100", "point_x": "0", "point_y": "0"}, "tool_right": {"point_x": "0", "point_y": "0"}, "tool_middle": {"point_x": "0", "point_y": "0"}}}, "weather": {"images": {"rainfall": {"scale": "100", "point_x": "0", "point_y": "0"}, "global_ir": {"scale": "100", "point_x": "0", "point_y": "0"}, "radar_echo": {"scale": "100", "point_x": "0", "point_y": "0"}, "temperature": {"scale": "100", "point_x": "0", "point_y": "0"}, "east_asia_ir": {"scale": "100", "point_x": "0", "point_y": "0"}, "east_asia_mb": {"scale": "100", "point_x": "0", "point_y": "0"}, "forecast_24h": {"scale": "100", "point_x": "0", "point_y": "0"}, "east_asia_vis": {"scale": "100", "point_x": "0", "point_y": "0"}, "weather_alert": {"scale": "100", "point_x": "0", "point_y": "0"}, "weather_forecast": {"scale": "100", "point_x": "0", "point_y": "0"}, "ultraviolet_light": {"scale": "100", "point_x": "0", "point_y": "0"}, "numerical_forecast": {"scale": "100", "point_x": "0", "point_y": "0"}, "surface_weather_map": {"scale": "100", "point_x": "0", "point_y": "0"}, "wave_analysis_chart": {"scale": "100", "point_x": "0", "point_y": "0"}, "precipitation_forecast_6h": {"scale": "100", "point_x": "0", "point_y": "0"}, "precipitation_forecast_12h": {"scale": "100", "point_x": "0", "point_y": "0"}}, "general": {"tool_left": {"point_x": "0", "point_y": "0"}, "tool_right": {"point_x": "0", "point_y": "0"}}, "weather_information": {"block": {"point_x": "0", "point_y": "0"}}}}';
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
