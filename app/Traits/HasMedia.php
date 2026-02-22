<?php

namespace App\Traits;

use App\Models\Media; // Sesuaikan namespace model Media Anda
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasMedia
{
    /**
     *  Relation polymorphic yang akan otomatis dimiliki setiap model ketika menggunakan traits ini
     *
     *  @return MorphMany
     */
    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    /**
     *  Helper function untuk mengambil foto thumbnail tanpa perlu barisan kode yang panjang lebar
     *
     * @return MorphOne
     */
    public function thumbnail(): MorphOne
    {
        // Ambil foto yang berkaitan dengan article dengan is thumbnail adalah true
        return $this->morphOne(Media::class, 'mediable')->where('is_thumbnail', true);
    }
}
