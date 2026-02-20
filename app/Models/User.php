<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     *  Casting profile user, jika tidak ada foto yang tersedia atau diupload dari sisi user
     *
     *  @return Attribute
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Asumsikan Anda punya kolom 'avatar' di table users
                if ($this->avatar && file_exists(storage_path('app/public/' . $this->avatar))) {
                    return asset('storage/' . $this->avatar);
                }

                // Fallback ke CDN UI-Avatars menggunakan inisial nama
                return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&background=random&color=fff";
            },
        );
    }
}
