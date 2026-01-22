<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmProfile extends Model
{
    /** @use HasFactory<\Database\Factories\UmkmProfileFactory> */
    use HasFactory;

    protected $table = 'umkm_profiles';

    protected $fillable = [
        'name',
        'slug',
        'short_text',
        'full_text',
        'address',
        'latitude',
        'longitude'
    ];

    public function owner()
    {
        return $this->hasMany(User::class, 'owner_id');
    }

    public function category()
    {
        return $this->belongsTo(Category_umkm::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product_umkm::class, 'umkm_id');
    }

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function reviews()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function photos()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class, 'umkm_id')
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->latestOfMany();
    }
}
