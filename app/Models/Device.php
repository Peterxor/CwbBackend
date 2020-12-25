<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Device extends Model
{
    //
    protected $table = 'device';
    protected $fillable = [
        'name', 'forecast_json', 'typhoon_json', 'created_at', 'updated_at', 'user_id'
    ];
}
