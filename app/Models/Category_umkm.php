<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category_umkm extends Model
{
    protected $table = 'category_umkms';

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function umkms()
    {
        return $this->hasMany(UmkmProfile::class, 'category_id');
    }

    //slug
}
