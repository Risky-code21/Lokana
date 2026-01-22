<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category_article extends Model
{
    protected $table = 'category_articles';

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }


    // slug
    // Coba pelajari logika dari subs nya dulu ya 
}
