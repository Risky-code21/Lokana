<?php

namespace App\Services;

use App\Events\ArticleStatusUpdated;
use App\Models\Article;
use App\Models\User;

class InteractionService
{
    public function toggleLikes(Article $article, User $user)
    {
        $exsitingLike = $article->likes()->where('user_id', $user->id);

        if ($exsitingLike) {
            $exsitingLike->delete();
            $status = 'unliked';
        } else {
            $article->likes()->create([
                'user_id' => $user->id,
                ''
            ]);
            $status = 'liked';
        }

        return $status;
    }

    public function recordView(Article $article, $ip, $userAgent)
    {
        // Catat view baru ke database
        $article->views()->create([
            'ip_address' => $ip,
            'device_id' => $userAgent // Kita pakai UserAgent browser sebagai ID perangkat
        ]);

        // 🔥 Broadcast ke Reverb juga saat ada yang lihat
        ArticleStatusUpdated::dispatch($article->refresh());
    }
}
