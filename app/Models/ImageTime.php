<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Device;
use App\Models\Media;


class ImageTime extends Model
{
    //
    protected $table = 'image_times';
    protected $fillable = [
        'user_id',
        'device_id',
        'general_image_id',
        'is_default',
        'start_file',
        'end_file',
        'created_at',
        'updated_at'
    ];



}
