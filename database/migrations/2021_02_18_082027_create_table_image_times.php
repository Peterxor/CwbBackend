<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableImageTimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('主播id');
            $table->unsignedBigInteger('device_id')->comment('裝置id');
            $table->unsignedBigInteger('general_image_id')->comment('圖資id');
            $table->boolean('is_default')->comment('是否預設');
            $table->string('start_file', 255)->nullable()->comment('起始檔案名稱');
            $table->string('end_file', 255)->nullable()->comment('結束檔案名稱');
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
        Schema::dropIfExists('image_times');
    }
}
