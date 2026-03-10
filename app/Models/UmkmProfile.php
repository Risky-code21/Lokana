<?php
// app/Models/UmkmProfile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UmkmProfile extends Model
{
    use SoftDeletes;

    protected $table = 'umkm_profiles';

    protected $fillable = [
        'name', 'slug', 'pelaku_umkm', 'nama_pemilik', 'tahun_berdiri',
        'category_id', 'instagram_link', 'whatsapp_number', 'contact_person_name',
        'contact_person_phone', 'email_umkm', 'website', 'facebook_link',
        'twitter_link', 'tiktok_link', 'short_description', 'content',
        'address', 'province', 'city', 'district', 'village', 'postal_code',
        'latitude', 'longitude', 'logo', 'thumbnail', 'gallery_images',
        'meta_title', 'meta_description', 'meta_keywords',
        'subscription_plan_id', 'payment_proof', 'subscription_start_date',
        'subscription_end_date', 'subscription_status', 'verification_status',
        'profile_status', 'is_featured', 'views_count', 'admin_notes',
        'verified_at', 'verified_by'
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'tahun_berdiri' => 'integer',
        'is_featured' => 'boolean',
        'subscription_start_date' => 'datetime',
        'subscription_end_date' => 'datetime',
        'verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($profile) {
            if (empty($profile->slug)) {
                $profile->slug = Str::slug($profile->name);
            }
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(CategoryUmkm::class, 'category_id');
    }

    /**
     * Relasi ke PelakuUmkm - PERBAIKAN INI
     * foreign key: pelaku_umkm (di tabel umkm_profiles)
     * owner key: id (di tabel pelaku_umkms)
     */
    public function owner()
    {
        return $this->belongsTo(PelakuUmkm::class, 'pelaku_umkm', 'id');
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('profile_status', 'published')
                     ->where('subscription_status', 'active')
                     ->where('subscription_end_date', '>', now());
    }

    public function scopePending($query)
    {
        return $query->where('profile_status', 'pending');
    }

    // Accessors
    public function getFullAddressAttribute()
    {
        return implode(', ', array_filter([
            $this->address,
            $this->village,
            $this->district,
            $this->city,
            $this->province,
            $this->postal_code
        ]));
    }
}