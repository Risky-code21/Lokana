<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    protected $table = "articles";

    protected $fillable = [
        'title',
        'slug',
        'short_text',
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

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function likes()
    {
        return $this->morphMany(View::class, 'likeable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'viewable');
    }

    public function photos()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
