<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TyphoonImage;

class FixJsonToDash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $typhoonImages = TyphoonImage::all();
        foreach ($typhoonImages as $image) {
            $temp = [];
            foreach ($image->content as $key => $value) {
                $newKey = implode('_', explode('-', $key));
                $temp[$newKey] = $value;
                if ($image->name === 'rainfall_observation') {
                    $newValue = is_array($value) ? [] : $value;
                    if (is_array($value)) {
                        foreach ($value as $subKey => $subValue) {
                            $newSubKey = implode('_', explode('-', $subKey));
                            $newValue[$newSubKey] = $subValue;
                        }
                    }
                    $temp[$newKey] = $newValue;
                }
            }
            $image->content = $temp;
            $image->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $typhoonImages = TyphoonImage::all();
        foreach ($typhoonImages as $image) {
            $temp = [];
            foreach ($image->content as $key => $value) {
                $newKey = implode('-', explode('_', $key));
                $temp[$newKey] = $value;
                if ($image->name === 'rainfall_observation') {
                    $newValue = is_array($value) ? [] : $value;
                    if (is_array($value)) {
                        foreach ($value as $subKey => $subValue) {
                            $newSubKey = implode('-', explode('_', $subKey));
                            $newValue[$newSubKey] = $subValue;
                        }
                    }
                    $temp[$newKey] = $newValue;
                }
            }
            $image->content = $temp;
            $image->save();
        }
    }
}
