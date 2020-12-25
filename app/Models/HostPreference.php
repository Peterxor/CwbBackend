<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class HostPreference extends Model
{
    //
    protected $table = 'host_preference';
    protected $fillable = [
        'user_id', 'device_id', 'preference_json', 'created_at', 'updated_at'
    ];

}
