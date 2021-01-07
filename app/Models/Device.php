<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Device
 * @package App\Models
 * @property int|null user_id 使用者ID
 * @property array preference_json 個人化設定
 */
class Device extends Model
{
    //
    protected $table = 'device';
    protected $fillable = [
        'name', 'forecast_json', 'typhoon_json', 'preference_json', 'created_at', 'updated_at', 'user_id'
    ];

    protected $casts = [
        'preference_json' => 'array'
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
