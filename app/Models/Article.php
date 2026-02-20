<?php

namespace App\Models;

use App\Traits\HasLike;
use App\Traits\HasMedia;
use App\Traits\HasView;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory, HasMedia, HasView, HasLike;

    protected $table = "articles";

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'content',
        'author_id',
        'category_id',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($article) {
            if (empty($article->slug)) {
                $article->slug = $article->generateUniqueSlug;
            }
        });
    }

    public function generateUniqueSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $count = 0;
        $originalSlug = $slug;

        while (self::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $count++;
            $slug = $originalSlug . '-' . $count;
        }

        return $slug;
    }


    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category_article::class, 'category_id');
    }

    protected $withCount = ['likes', 'views'];
}
