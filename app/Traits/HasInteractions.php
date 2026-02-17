<?php

namespace App\Traits;

use App\Models\Like;
use App\Models\Media;
use App\Models\View;

trait HasInteractions
{
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function medias()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function thumbnail()
    {
        return $this->morphOne(Media::class, 'mediable')->where('is_thumbnail', true);
    }
}
