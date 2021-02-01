<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\HostPreference;

class UpdateNewHostPreferenceJson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $preference_json = '{"typhoon": {"wind_forecast": {"title": {"point": ["0", "0"]}, "taiwan_e": {"point": ["0", "0"]}, "taiwan_m": {"point": ["0", "0"]}, "taiwan_n": {"point": ["0", "0"]}, "taiwan_s": {"point": ["0", "0"]}, "tool_left": {"point": ["0", "0"]}, "image_tool": {"point": ["0", "0"]}, "taiwan_all": {"point": ["0", "0"]}, "tool_right": {"point": ["0", "0"]}, "tool_middle": {"point": ["0", "0"]}}, "typhoon_dynamics": {"title": {"point": ["0", "0"]}, "typhoon_ir": {"point": ["0", "0"]}, "typhoon_mb": {"point": ["0", "0"]}, "tool_middle": {"point": ["0", "0"]}, "typhoon_vis": {"point": ["0", "0"]}}, "wind_observation": {"title": {"point": ["0", "0"]}, "taiwan_e": {"point": ["0", "0"]}, "taiwan_m": {"point": ["0", "0"]}, "taiwan_n": {"point": ["0", "0"]}, "taiwan_s": {"point": ["0", "0"]}, "tool_left": {"point": ["0", "0"]}, "image_tool": {"point": ["0", "0"]}, "taiwan_all": {"point": ["0", "0"]}, "tool_right": {"point": ["0", "0"]}, "tool_middle": {"point": ["0", "0"]}}, "rainfall_forecast": {"title": {"point": ["0", "0"]}, "taiwan_e": {"point": ["0", "0"]}, "taiwan_h": {"point": ["0", "0"]}, "taiwan_m": {"point": ["0", "0"]}, "taiwan_n": {"point": ["0", "0"]}, "taiwan_s": {"point": ["0", "0"]}, "taiwan_y": {"point": ["0", "0"]}, "tool_left": {"point": ["0", "0"]}, "image_tool": {"point": ["0", "0"]}, "taiwan_all": {"point": ["0", "0"]}, "tool_right": {"point": ["0", "0"]}, "tool_middle": {"point": ["0", "0"]}}, "typhoon_potential": {"title": {"point": ["0", "0"]}, "tool_middle": {"point": ["0", "0"]}}, "anchor_information": {"block": {"point": ["0", "0"]}}, "rainfall_observation": {"title": {"point": ["0", "0"]}, "taiwan_e": {"point": ["0", "0"]}, "taiwan_h": {"point": ["0", "0"]}, "taiwan_m": {"point": ["0", "0"]}, "taiwan_n": {"point": ["0", "0"]}, "taiwan_s": {"point": ["0", "0"]}, "taiwan_y": {"point": ["0", "0"]}, "tool_left": {"point": ["0", "0"]}, "image_tool": {"point": ["0", "0"]}, "taiwan_all": {"point": ["0", "0"]}, "tool_right": {"point": ["0", "0"]}, "tool_middle": {"point": ["0", "0"]}}}, "weather": {"images": {"rainfall": {"point": ["0", "0"]}, "global_ir": {"point": ["0", "0"]}, "radar_echo": {"point": ["0", "0"]}, "temperature": {"point": ["0", "0"]}, "east_asia_ir": {"point": ["0", "0"]}, "east_asia_mb": {"point": ["0", "0"]}, "forecast_24h": {"point": ["0", "0"]}, "east_asia_vis": {"point": ["0", "0"]}, "weather_alert": {"point": ["0", "0"]}, "weather_forecast": {"point": ["0", "0"]}, "ultraviolet_light": {"point": ["0", "0"]}, "numerical_forecast": {"point": ["0", "0"]}, "surface_weather_map": {"point": ["0", "0"]}, "wave_analysis_chart": {"point": ["0", "0"]}, "precipitation_forecast_6h": {"point": ["0", "0"]}, "precipitation_forecast_12h": {"point": ["0", "0"]}}, "general": {"tool_left": {"point": ["0", "0"]}, "tool_right": {"point": ["0", "0"]}}, "weather_information": {"block": {"point": ["0", "0"]}}}}';
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
