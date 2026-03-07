<?php

namespace App\Traits;

use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLike
{
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     *  Function untuk mengecek apakah suatu like dilakukan oleh user yang sedang terautentikasi pada saat ini
     *
     *  @param [type] $userId
     *  @return boolean
     */
    public function isLikedBy($userId): bool
    {
        if (!$userId) return false;

        return $this->likes()
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     *  Helper function untuk membuat likes pada setiap model yang menggunakan traits ini
     *
     *  @param [type] $userId
     *  @return boolean
     */
    public function toggleLike($userId): bool
    {
        $like = $this->likes()->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
            return false; // Artinya: Sekarang jadi TIDAK di-like
        } else {
            $this->likes()->create([
                'user_id' => $userId
            ]);
            return true; // Artinya: Sekarang jadi DI-LIKE
        }
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}
