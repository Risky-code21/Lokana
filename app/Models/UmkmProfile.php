<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UmkmProfile extends Model
{
    use HasFactory;

    protected $table = 'umkm_profiles';

    protected $fillable = [
        'name',
        'slug',
        'pelaku_umkm_id',
        'category_id',
        'established_year',
        'short_description',
        'full_story',
        'thumbnail',
        'address',
        'location_name',
        'google_maps_link',
        'latitude',
        'longitude',
        'contact_person',
        'phone_number',
        'instagram_link',
        'meta_title',
        'meta_description',
        'status'
    ];

    protected $casts = [
        'established_year' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
                // Make slug unique
                $count = 1;
                while (self::where('slug', $model->slug)->exists()) {
                    $model->slug = Str::slug($model->name) . '-' . $count++;
                }
            }
        });
    }

    /**
     * Get the pelaku umkm (owner)
     */
    public function pelakuUmkm()
    {
        return $this->belongsTo(PelakuUmkm::class, 'pelaku_umkm_id');
    }

    /**
     * Get the category
     */
    public function category()
    {
        return $this->belongsTo(CategoryUmkm::class, 'category_id');
    }

    /**
     * Get products for this UMKM
     */
    public function products()
    {
        return $this->hasMany(ProductUmkm::class, 'umkm_id');
    }

    /**
     * Scope for published profiles
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for draft profiles
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Get the URL for this profile
     */
    public function getUrlAttribute()
    {
        return route('umkm.show', $this->slug);
    }

    /**
     * Get the thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('images/default-umkm.jpg');
    }

    /**
     * Get the age of the UMKM
     */
    public function getAgeAttribute()
    {
        return now()->year - $this->established_year;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'draft' => 'bg-gray-100 text-gray-800',
            'published' => 'bg-green-100 text-green-800',
            'archived' => 'bg-red-100 text-red-800'
        ];
        
        return $colors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}