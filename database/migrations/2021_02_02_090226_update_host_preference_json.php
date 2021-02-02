<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\HostPreference;

class UpdateHostPreferenceJson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $preference_json = '{"typhoon": {"wind_forecast": {"title": {"point_x": "0", "point_y": "0"}, "taiwan_e": {"point_x": "0", "point_y": "0"}, "taiwan_m": {"point_x": "0", "point_y": "0"}, "taiwan_n": {"point_x": "0", "point_y": "0"}, "taiwan_s": {"point_x": "0", "point_y": "0"}, "tool_left": {"point_x": "0", "point_y": "0"}, "image_tool": {"point_x": "0", "point_y": "0"}, "taiwan_all": {"point_x": "0", "point_y": "0"}, "tool_right": {"point_x": "0", "point_y": "0"}, "tool_middle": {"point_x": "0", "point_y": "0"}}, "typhoon_dynamics": {"title": {"point_x": "0", "point_y": "0"}, "typhoon_ir": {"point_x": "0", "point_y": "0"}, "typhoon_mb": {"point_x": "0", "point_y": "0"}, "tool_middle": {"point_x": "0", "point_y": "0"}, "typhoon_vis": {"point_x": "0", "point_y": "0"}}, "wind_observation": {"title": {"point_x": "0", "point_y": "0"}, "taiwan_e": {"point_x": "0", "point_y": "0"}, "taiwan_m": {"point_x": "0", "point_y": "0"}, "taiwan_n": {"point_x": "0", "point_y": "0"}, "taiwan_s": {"point_x": "0", "point_y": "0"}, "tool_left": {"point_x": "0", "point_y": "0"}, "image_tool": {"point_x": "0", "point_y": "0"}, "taiwan_all": {"point_x": "0", "point_y": "0"}, "tool_right": {"point_x": "0", "point_y": "0"}, "tool_middle": {"point_x": "0", "point_y": "0"}}, "rainfall_forecast": {"title": {"point_x": "0", "point_y": "0"}, "taiwan_e": {"point_x": "0", "point_y": "0"}, "taiwan_h": {"point_x": "0", "point_y": "0"}, "taiwan_m": {"point_x": "0", "point_y": "0"}, "taiwan_n": {"point_x": "0", "point_y": "0"}, "taiwan_s": {"point_x": "0", "point_y": "0"}, "taiwan_y": {"point_x": "0", "point_y": "0"}, "tool_left": {"point_x": "0", "point_y": "0"}, "image_tool": {"point_x": "0", "point_y": "0"}, "taiwan_all": {"point_x": "0", "point_y": "0"}, "tool_right": {"point_x": "0", "point_y": "0"}, "tool_middle": {"point_x": "0", "point_y": "0"}}, "typhoon_potential": {"title": {"point_x": "0", "point_y": "0"}, "tool_middle": {"point_x": "0", "point_y": "0"}}, "anchor_information": {"block": {"point_x": "0", "point_y": "0"}}, "rainfall_observation": {"title": {"point_x": "0", "point_y": "0"}, "taiwan_e": {"point_x": "0", "point_y": "0"}, "taiwan_h": {"point_x": "0", "point_y": "0"}, "taiwan_m": {"point_x": "0", "point_y": "0"}, "taiwan_n": {"point_x": "0", "point_y": "0"}, "taiwan_s": {"point_x": "0", "point_y": "0"}, "taiwan_y": {"point_x": "0", "point_y": "0"}, "tool_left": {"point_x": "0", "point_y": "0"}, "image_tool": {"point_x": "0", "point_y": "0"}, "taiwan_all": {"point_x": "0", "point_y": "0"}, "tool_right": {"point_x": "0", "point_y": "0"}, "tool_middle": {"point_x": "0", "point_y": "0"}}}, "weather": {"images": {"rainfall": {"point_x": "0", "point_y": "0"}, "global_ir": {"point_x": "0", "point_y": "0"}, "radar_echo": {"point_x": "0", "point_y": "0"}, "temperature": {"point_x": "0", "point_y": "0"}, "east_asia_ir": {"point_x": "0", "point_y": "0"}, "east_asia_mb": {"point_x": "0", "point_y": "0"}, "forecast_24h": {"point_x": "0", "point_y": "0"}, "east_asia_vis": {"point_x": "0", "point_y": "0"}, "weather_alert": {"point_x": "0", "point_y": "0"}, "weather_forecast": {"point_x": "0", "point_y": "0"}, "ultraviolet_light": {"point_x": "0", "point_y": "0"}, "numerical_forecast": {"point_x": "0", "point_y": "0"}, "surface_weather_map": {"point_x": "0", "point_y": "0"}, "wave_analysis_chart": {"point_x": "0", "point_y": "0"}, "precipitation_forecast_6h": {"point_x": "0", "point_y": "0"}, "precipitation_forecast_12h": {"point_x": "0", "point_y": "0"}}, "general": {"tool_left": {"point_x": "0", "point_y": "0"}, "tool_right": {"point_x": "0", "point_y": "0"}}, "weather_information": {"block": {"point_x": "0", "point_y": "0"}}}}';
        $preference_json = json_decode($preference_json);
        $host_preferences = HostPreference::all();
        foreach ($host_preferences as $host_preference) {
            $host_preference->preference_json = $preference_json;
            $host_preference->save();
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
