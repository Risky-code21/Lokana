<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryArticle extends Model
{
    protected $table = 'category_articles';

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Get the articles for the category.
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'category_id');
    }

    /**
     * The attributes that should be appended to arrays.
     */
    protected $appends = [
        'articles_count'
    ];

    /**
     * Get the articles count attribute.
     */
    public function getArticlesCountAttribute()
    {
        return $this->articles()->count();
    }
}