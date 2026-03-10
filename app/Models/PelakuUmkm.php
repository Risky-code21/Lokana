<?php
// app/Models/PelakuUmkm.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelakuUmkm extends Model
{
    use HasFactory;

    protected $table = "pelaku_umkms";

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke UmkmProfile - PERBAIKAN INI
     * foreign key: pelaku_umkm (di tabel umkm_profiles)
     * local key: id (di tabel pelaku_umkms)
     */
    public function umkmProfiles()
    {
        return $this->hasMany(UmkmProfile::class, 'pelaku_umkm', 'id');
    }

    /**
     * Relasi ke User (jika pelaku_umkm terhubung ke user)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}