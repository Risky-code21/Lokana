<?php

namespace App\Models;

use BadFunctionCallException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelakuUmkm extends Model
{
    /** @use HasFactory<\Database\Factories\PelakuUmkmFactory> */
    use HasFactory;

    protected $table = "pelaku_umkms";

    protected $fillable = [
        'umkm_id',
        'name',
        'email',
        'phone',
        'address',
    ];

    protected $casts = [
        'created_at' => 'datetime:D M Y H:i',
        'updated_at' => 'datetime:D M Y H:i',
    ];

    public function umkm_profiles()
    {
        return $this->hasMany(UmkmProfile::class, 'owner_id');
    }
}
