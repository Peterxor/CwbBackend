<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    //
    protected $table = 'medias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id', 'disk', 'file_name', 'mime_type', 'path', 'size',
    ];

    protected $appends = [
        'url'
    ];

    public function getUrlAttribute() {
        $filesystem = 'media';
        if (env('MEDIA_TYPE', 'media') == 's3') {
            $filesystem = 's3';
        }
        return Storage::disk($filesystem)->url($this->path);
    }
}
