<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryUmkm extends Model
{
    use HasFactory; // HAPUS SoftDeletes

    protected $table = 'category_umkms';

    protected $fillable = [
        'name',
        'description'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        // HAPUS 'deleted_at' => 'datetime',
    ];

    /**
     * Get the validation rules
     */
    public static function rules($id = null)
    {
        return [
            'name' => 'required|string|max:255|unique:category_umkms,name,' . $id,
            'description' => 'required|string|max:500',
        ];
    }

    /**
     * Get the validation messages
     */
    public static function messages()
    {
        return [
            'name.required' => 'Nama kategori wajib diisi',
            'name.unique' => 'Nama kategori sudah digunakan',
            'description.required' => 'Deskripsi wajib diisi',
        ];
    }

    /**
     * Scope untuk search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
        });
    }

    /**
     * Scope untuk ordering
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get UMKM profiles in this category
     */
    public function umkmProfiles()
    {
        return $this->hasMany(UmkmProfile::class, 'category_id');
    }

    /**
     * Get total UMKM in this category
     */
    public function getTotalUmkmAttribute()
    {
        return $this->umkmProfiles()->count();
    }

    /**
     * Check if category can be deleted
     */
    public function getCanDeleteAttribute()
    {
        return $this->umkmProfiles()->count() === 0;
    }
}