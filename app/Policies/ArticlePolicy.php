<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    /**
     *  Undocumented function
     *
     *  @param User|null $user
     *  @return boolean
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     *  Undocumented function
     *
     *  @param User|null $user
     *  @param Article $article
     *  @return boolean
     */
    public function view(?User $user, Article $article): bool
    {
        return true;
    }

    /**
     * Undocumented function
     *
     *  @param User $user
     *  @return boolean
     */
    public function create(User $user): bool
    {
        // Sesuaikan 'admin' dengan value yang ada di kolom role database Anda ya
        return $user->role === 'admin';
    }

    /**
     *  Undocumented function
     *
     *  @param User $user
     *  @param Article $article
     *  @return boolean
     */
    public function update(User $user, Article $article): bool
    {
        return $user->role === 'admin';
    }

    /**
     *  Undocumented function
     *
     *  @param User $user
     *  @param Article $article
     *  @return boolean
     */
    public function delete(User $user, Article $article): bool
    {
        return $user->role === 'admin';
    }
}
