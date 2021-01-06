<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TyphoonImage
 *
 * @property int sort
 * @property string content
 *
 * @package App\Models
 */
class TyphoonImage extends Model
{
    //
    protected $table = 'typhoon_images';
    protected $fillable = [
        'name', 'content', 'sort', 'created_at', 'updated_at'
    ];
}
