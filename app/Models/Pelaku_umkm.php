<?php

namespace App\Models;

use BadFunctionCallException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaku_umkm extends Model
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

    public function umkm_profiles()
    {
        return $this->hasMany(UmkmProfile::class, 'owner_id');
    }
}
