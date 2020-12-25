<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class GeneralImagesCategory extends Model
{
    //
    protected $table = 'general_images_category';
    protected $fillable = [
        'name', 'sort', 'created_at', 'updated_at'
    ];
}
