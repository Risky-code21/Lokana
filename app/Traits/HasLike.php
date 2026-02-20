<?php

namespace App\Traits;

use App\Models\Like; // Pastikan model Like ada
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLike
{
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Cek apakah user X sudah like?
     */
    public function isLikedBy($userId): bool
    {
        if (!$userId) return false;

        return $this->likes()
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Toggle Like (Like/Unlike)
     */
    public function toggleLike($userId)
    {
        $like = $this->likes()->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
            return 'unliked';
        } else {
            // MAGIC LAGI:
            // create() otomatis mengisi likeable_id & likeable_type
            // sesuai dengan model yang memanggil trait ini.
            $this->likes()->create([
                'user_id' => $userId
            ]);
            return 'liked';
        }
    }

    // Atribut tambahan untuk JSON/Blade: $article->likes_count
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}
