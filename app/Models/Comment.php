<?php

namespace App\Models;

use App\Traits\HasLike;
use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasMedia, HasLike;

    // Nama tabel komentar, dideginsikan ulang agar tidak salah
    protected $table = 'comments';

    // Column yang bisa diisi secara masal
    protected $fillable = [
        'user_id',
        'commentable_id',
        'commentable_type',
        'rating',
        'full_text',
        'content',
        'parent_id',
        'reply_target_id'
    ];

    /**
     *  Function untuk polymorphic relation ke model lain agar tidak perlu membuat relasi model satu per satu
     *
     * `@return MorphTo
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     *  Function untuk user relation di komentar, supaya kita tahu siapa yang membuat komentar ini
     *
     *  @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     *  Function untuk self relation, untuk mendukung fitur replay komentar
     *
     *  @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     *  Function untuk mendukung fitur grouping komentar, walau kita mereplay komentar berbeda didalam satu parent komentar, dia tetap terhitung menjadi anak dari parent komentar
     *
     *  @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     *  Function relation untuk mendukung fitur targeting komentar yang telah di replay dari suatu komentar tertentu yang sudah ada nantinya
     *
     *  @return BelongsTo
     */
    public function target(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'reply_target_id');
    }
}
