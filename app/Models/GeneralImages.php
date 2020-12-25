<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GeneralImagesCategory;


class GeneralImages extends Model
{
    //
    protected $table = 'general_images';
    protected $fillable = [
        'name', 'content', 'category_id', 'sort', 'created_at', 'updated_at'
    ];

    public function category()
    {
        return $this->belongsTo(GeneralImagesCategory::class, 'category_id', 'id');
    }
}
