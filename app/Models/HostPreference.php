<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class HostPreference
 * @package App\Models
 * @property int|null user_id 使用者ID
 * @property array preference_json 個人化設定
 */
class HostPreference extends Model
{
    //
    protected $table = 'host_preference';
    protected $fillable = [
        'user_id', 'device_id', 'preference_json', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'preference_json' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }
}
