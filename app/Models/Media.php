<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';

    protected $fillable = [
        'url',
        'mediable_id',
        'mediable_type',
        'is_thumbnail',
    ];

    public function mediable()
    {
        return $this->morphTo();
    }
}
