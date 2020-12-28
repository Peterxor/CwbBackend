<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;


class Device extends Model
{
    //
    protected $table = 'device';
    protected $fillable = [
        'name', 'forecast_json', 'typhoon_json', 'created_at', 'updated_at', 'user_id'
    ];
    protected $appends = ['decode_forecast', 'decode_typhoon'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getDecodeForecastAttribute () {
        return json_decode($this->forecast_json);
    }

    public function getDecodeTyphoonAttribute () {
        return json_decode($this->typhoon_json);
    }
}
