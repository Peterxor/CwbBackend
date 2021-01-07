<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TyphoonImage
 *
 * @property int id
 * @property string name
 * @property array content
 * @property int sort
 *
 * @package App\Models
 */
class TyphoonImage extends Model
{
    protected $table = 'typhoon_images';
    protected $fillable = [
        'name', 'content', 'sort', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'content' => 'array'
    ];
}
