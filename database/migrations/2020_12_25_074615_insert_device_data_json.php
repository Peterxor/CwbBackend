<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\TyphoonImage;
use App\Models\GeneralImages;
use App\Models\Device;

class InsertDeviceDataJson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $forecast = [];
        $typhoon = [];
        $user = User::first();
        $typhoonImages = TyphoonImage::get();
        $generalImages = GeneralImages::get();

        foreach($typhoonImages as $image) {
            $forecast[] = [
                'id' => $image->id,
                'name' => $image->name,
            ];
        }

        foreach($generalImages as $image) {
            $typhoon[] = [
                'id' => $image->id,
                'name' => $image->name,
            ];
        }

        $forecast_json = json_encode($forecast);
        $typhoon_json = json_encode($typhoon);

        Device::create([
            'name' => '防災視訊室',
            'user_id' => $user->id,
            'forecast_json' => $forecast_json,
            'typhoon_json' => $typhoon_json,
        ]);


        Device::create([
            'name' => '公關室',
            'user_id' => $user->id,
            'forecast_json' => $forecast_json,
            'typhoon_json' => $typhoon_json,
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Device::truncate();
    }
}
