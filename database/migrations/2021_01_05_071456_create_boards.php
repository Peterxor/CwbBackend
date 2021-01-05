<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(1)->comment('看板類型');
            $table->unsignedInteger('device_id')->nullable()->comment('裝置id');
            $table->unsignedInteger('personnel_id_a')->nullable()->comment('人員1');
            $table->unsignedInteger('personnel_id_b')->nullable()->comment('人員2');
            $table->string('conference_time', 255)->nullable()->comment('會議時間');
            $table->tinyInteger('conference_status')->default(0)->comment('會議啟用狀態 0:停用，1:啟用');
            $table->string('next_conference_time', 255)->nullable()->comment('下場會議時間');
            $table->tinyInteger('next_conference_status')->default(0)->comment('會議啟用狀態 0:停用，1:啟用');
            $table->integer('background')->default(1)->comment('背景');
            $table->unsignedInteger('media_id')->nullable()->comment('媒體id');
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
        Schema::dropIfExists('boards');
    }
}
