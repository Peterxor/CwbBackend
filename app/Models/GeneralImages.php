<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class GeneralImages
 *
 * @property int id
 * @property string name
 * @property array content
 * @property int category_id
 * @property int sort
 *
 * @package App\Models
 */
class GeneralImages extends Model
{
    //
    protected $table = 'general_images';
    protected $fillable = [
        'name', 'content', 'category_id', 'sort', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'content' => 'array'
    ];

    public static $mode = [
        1 => 'single',
        2 => 'gif',
        3 => 'list',
        4 => 'abreast'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(GeneralImagesCategory::class, 'category_id', 'id');
    }
}
