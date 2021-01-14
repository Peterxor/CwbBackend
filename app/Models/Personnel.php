<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Personnel extends Model
{
    //
    protected $table = 'personnel';
    protected $fillable = [
        'name', 'nick_name', 'career', 'education', 'created_at', 'updated_at', 'experience'
    ];
    protected $casts = [
        'experience' => 'array'
    ];
}
