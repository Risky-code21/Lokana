<?php

namespace App\Traits;

use App\Models\Media; // Sesuaikan namespace model Media Anda
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasMedia
{
    /**
     * Relasi ke semua media (Gallery, dll)
     */
    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    /**
     * Relasi khusus Thumbnail (ambil satu saja)
     */
    public function thumbnail(): MorphOne
    {
        // Asumsi logic Anda: is_thumbnail = true
        return $this->morphOne(Media::class, 'mediable')->where('is_thumbnail', true);
    }
}
