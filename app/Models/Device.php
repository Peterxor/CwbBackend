<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Board;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Device
 * @package App\Models
 *
 * @property int id 播報裝置ID
 * @property int|null user_id 主播ID
 * @property string name 播報裝置名稱
 * @property array forecast_json 一般天氣預報資料
 * @property array typhoon_json 主播圖卡資料
 * @property array preference_json 個人化設定
 * @property User|null user 主播
 */
class Device extends Model
{
    //
    protected $table = 'device';
    protected $fillable = [
        'name', 'forecast_json', 'typhoon_json', 'preference_json', 'user_id', 'theme', 'created_at', 'updated_at'
    ];

    protected $appends = [
        'theme_url'
    ];

    protected $casts = [
        'forecast_json' => 'array',
        'typhoon_json' => 'array',
        'preference_json' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function board()
    {
        return $this->hasOne(Board::class, 'device_id', 'id');
    }

    public function hostPreference()
    {
        return $this->hasMany(HostPreference::class, 'device_id', 'id');
    }

    public function getThemeUrlAttribute()
    {
        $themeSet = [
            'nature_blue', 'tech_blue', 'industry_orange', 'modern_red'
        ];
        $dirName = $themeSet[$this->theme - 1] ?? 'nature_blue';
        return [
            url("/images/theme/$dirName/bg_typhoon.jpg"),
            url("/images/theme/$dirName/left.png"),
            url("/images/theme/$dirName/right.png"),
        ];

    }

//    public function getDecodeForecastAttribute () {
//        return json_decode($this->forecast_json);
//    }
//
//    public function getDecodeTyphoonAttribute () {
//        return json_decode($this->typhoon_json);
//    }
}
