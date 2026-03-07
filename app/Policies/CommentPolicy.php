<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     *  Function policy untuk update article
     *
     *  @param User $user
     *  @param Comment $comment
     *  @return boolean
     */
    public function update(User $user, Comment $comment): bool
    {
        // User boleh edit jika dia adalah pemilik komentar
        return $user->id === $comment->user_id;
    }

    /**
     *  Fumction policy untuk delete article
     *
     *  @param User $user
     *  @param Comment $comment
     *  @return boolean
     */
    public function delete(User $user, Comment $comment): bool
    {
        // User boleh hapus jika dia adalah pemilik komentar
        return $user->id === $comment->user_id;
    }
}
