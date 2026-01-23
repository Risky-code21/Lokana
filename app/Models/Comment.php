<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'user_id',
        'commentable_id',
        'commentable_type',
        'rating',
        'full_text'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }
}
