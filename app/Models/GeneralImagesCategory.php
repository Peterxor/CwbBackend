<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GeneralImages;


class GeneralImagesCategory extends Model
{
    //
    protected $table = 'general_images_category';
    protected $fillable = [
        'name', 'sort', 'created_at', 'updated_at'
    ];

    public function generalImage(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GeneralImages::class, 'category_id', 'id');
    }
}
