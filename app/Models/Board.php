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

    public function device() {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }

    public function media()
    {
        return $this->hasOne(Media::class, 'id', 'media_id');
    }

}
