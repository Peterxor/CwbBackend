<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Device;
use App\Models\User;
use App\Models\TyphoonImage;
use App\Models\GeneralImages;

class InsertDeviceData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('device', function ($table) {
            $table->integer('user_id')->nullable()->comment('主播id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('device', function ($table) {
            $table->dropColumn('user_id');
        });
    }
}
