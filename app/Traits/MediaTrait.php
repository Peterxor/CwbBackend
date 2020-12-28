<?php
namespace App\Traits;

use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait MediaTrait
{
    /**
     * Get Media
     *
     * @return MorphToMany
     */
    public function media(): MorphToMany
    {
        return $this->morphToMany(
            Media::class,
            'model',
            'model_has_medias',
            'model_id',
            'media_id'
        );
    }
}
