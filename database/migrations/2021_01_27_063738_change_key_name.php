<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\GeneralImages;
use App\Models\TyphoonImage;

class ChangeKeyName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $general_images = GeneralImages::all();
        $typhoon_images = TyphoonImage::all();
        foreach ($general_images as $general_image) {
            $general_image->name = implode('_', explode('-', $general_image->name));
            $general_image->save();
        }
        foreach ($typhoon_images as $typhoon_image) {
            $typhoon_image->name = implode('_', explode('-', $typhoon_image->name));
            $typhoon_image->save();
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
        $general_images = GeneralImages::all();
        $typhoon_images = TyphoonImage::all();
        foreach ($general_images as $general_image) {
            $general_image->name = implode('-', explode('_', $general_image->name));
            $general_image->save();
        }
        foreach ($typhoon_images as $typhoon_image) {
            $typhoon_image->name = implode('-', explode('_', $typhoon_image->name));
            $typhoon_image->save();
        }
    }
}
