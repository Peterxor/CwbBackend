<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Device;
use App\Models\Media;


class Board extends Model
{
    //
    protected $table = 'boards';
    protected $fillable = [
        'type', 'device_id', 'personnel_id_a', 'personnel_id_b', 'conference_time', 'conference_status',
        'next_conference_time', 'next_conference_status', 'background', 'media_id', 'created_at', 'updated_at'
    ];
    protected $appends = [
        'background_url'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }

    public function media()
    {
        return $this->hasOne(Media::class, 'id', 'media_id');
    }

    public function personnel_a()
    {
        return $this->hasOne(Personnel::class, 'id', 'personnel_id_a');
    }

    public function personnel_b()
    {
        return $this->hasOne(Personnel::class, 'id', 'personnel_id_b');
    }

    public function getBackgroundUrlAttribute()
    {
        $backgroundSet = [
            'cloud.png', 'sunny.png', 'info.png', 'typhoon_eye.png'
        ];
        $backgroundFile = $backgroundSet[$this->background - 1] ?? 'cloud.png';
        return env('APP_URL') . '/images/board_background/' . $backgroundFile;
    }

}
