<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonnel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personnel', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable()->comment('人員姓名');
            $table->string('nick_name', 255)->nullable()->comment('角色稱呼');
            $table->string('career', 255)->nullable()->comment('現職');
            $table->string('education', 255)->nullable()->comment('學歷');
            $table->json('experience')->nullable()->comment('經歷');
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
        Schema::dropIfExists('personnel');
    }
}
