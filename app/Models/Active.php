<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class Active extends Model
{
    protected $table = 'activity_log';

    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id', 'id');
    }
}
