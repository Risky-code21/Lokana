<?php
// app/Models/Subscription.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_id',
        'plan_id',           // <-- ini plan_id, bukan subscription_plan_id
        'unique_code',
        'total_amount',
        'payment_proof',
        'admin_notes',
        'verified_at',
        'verified_by',
        'starts_at',
        'expires_at'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

    // Relasi ke UMKM
    public function umkm()
    {
        return $this->belongsTo(UmkmProfile::class, 'umkm_id');
    }

    // Relasi ke plan - PERBAIKAN INI
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');  // <-- pakai 'plan_id'
    }

    // Relasi ke user (admin yang verify)
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}