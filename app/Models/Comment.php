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
        'full_text',
        'content'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Relasi untuk mengambil induk (jika diperlukan)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
