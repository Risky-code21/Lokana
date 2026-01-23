<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_umkm extends Model
{
    protected $table = "product_umkms";

    protected $fillable = [
        'umkm_id',
        'name',
        'slug',
        'short_text',
        'full_text',
        'price'
    ];

    public function umkm()
    {
        return $this->belongsTo(UmkmProfile::class, 'umkm_id');
    }

    //slug
}
