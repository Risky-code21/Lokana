<?php

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
        'features'
    ];
    
    // TAMBAH INI untuk auto-convert JSON ke array
    protected $casts = [
        'features' => 'array'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
}