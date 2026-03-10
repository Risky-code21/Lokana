<?php
// app/Models/SubscriptionPlan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $table = 'subscription_plans';

    protected $fillable = [
        'name',
        'slug',
        'price',
        'duration_in_days',
        'features',
        'is_active'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];

    /**
     * Relasi ke Subscription - PERBAIKAN INI
     * Gunakan 'plan_id' karena di tabel subscriptions pakai plan_id
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');  // <-- pakai 'plan_id'
    }

    /**
     * Relasi langsung ke UmkmProfile (subscription_plan_id ada di umkm_profiles)
     */
    public function umkmProfiles()
    {
        return $this->hasMany(UmkmProfile::class, 'subscription_plan_id');
    }

    // Optional: method untuk cek apakah plan digunakan
    public function isUsed()
    {
        return $this->subscriptions()->exists() || $this->umkmProfiles()->exists();
    }

    public function getUsageCountAttribute()
    {
        return $this->subscriptions()->count() + $this->umkmProfiles()->count();
    }
}