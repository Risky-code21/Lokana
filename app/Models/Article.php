<?php

namespace App\Models;

use App\Traits\HasLike;
use App\Traits\HasMedia;
use App\Traits\HasView;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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

    /**
     *  Function static yang akan otomatis berjalan dan mengecek setiap slug pada article agar bisa memberikan slug unique untuk slug yang masih kosong
     *
     *  @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($article) {
            if (empty($article->slug)) {
                $article->slug = $article->generateUniqueSlug;
            }
        });
    }

    /**
     *  Function yang bisa digunakan untuk membuat slug unique namun ini versi manual, yang dimana slug yang dihasilkan tetap base dari title namun ditambahkan nomor di belakangnya untuk menghindari kesamaan slug yang tidak di sengaja
     *
     *  @param [type] $title
     *  @param [type] $id
     *  @return string
     */
    public function generateUniqueSlug($title, $id = null): string
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


    // Relasi ke comments table
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // Relasi ke users table sebagai pembuat article ini
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Relasi ke category articles table
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category_article::class, 'category_id');
    }

    // Otomatis mengembalikan likes_count dan views_count yang berisi jumlah dari keseluruhan data likes dan views yang dimiliki oleh article
    protected $withCount = ['likes', 'views'];
}
