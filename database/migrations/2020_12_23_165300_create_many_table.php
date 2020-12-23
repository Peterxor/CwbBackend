<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('forecast_json')->nullable()->comment('天氣預報');
            $table->json('typhoon_json')->nullable()->comment('颱風預報');
            $table->timestamps();
        });


        Schema::create('host_preference', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable()->comment('主播id');
            $table->unsignedInteger('device_id')->nullable()->comment('device id');
            $table->json('preference_json')->nullable()->comment('偏好json');
            $table->timestamps();
        });


        Schema::create('typhoon_images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('content')->nullable()->comment('颱風圖資');
            $table->integer('sort')->nullable()->comment('排序');
            $table->timestamps();
        });


        Schema::create('general_images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('content')->nullable()->comment('颱風圖資');
            $table->integer('sort')->nullable()->comment('排序');
            $table->unsignedInteger('parent_id')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device');
        Schema::dropIfExists('host_preference');
        Schema::dropIfExists('typhoon_images');
        Schema::dropIfExists('general_images');

    }
}
