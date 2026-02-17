<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUmkmProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $currentYear = now()->year;
        
        return [
            // Basic Info
            'name' => 'required|string|max:255|unique:umkm_profiles,name',
            'slug' => 'nullable|string|max:255|unique:umkm_profiles,slug',
            
            // Relationships
            'pelaku_umkm_id' => 'required|exists:pelaku_umkms,id',
            'category_id' => 'required|exists:category_umkms,id',
            
            // Profile Info
            'established_year' => 'required|integer|min:1900|max:' . $currentYear,
            'short_description' => 'required|string|max:255',
            'full_story' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            
            // Location
            'address' => 'required|string|max:500',
            'location_name' => 'nullable|string|max:255',
            'google_maps_link' => 'nullable|url|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            
            // Contact
            'contact_person' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'instagram_link' => 'nullable|url|max:255',
            
            // SEO
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            
            // Status
            'status' => 'required|in:draft,published,archived'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama UMKM wajib diisi',
            'name.unique' => 'Nama UMKM sudah digunakan',
            'pelaku_umkm_id.required' => 'Pemilik UMKM wajib dipilih',
            'pelaku_umkm_id.exists' => 'Pemilik UMKM tidak valid',
            'category_id.required' => 'Kategori UMKM wajib dipilih',
            'category_id.exists' => 'Kategori UMKM tidak valid',
            'established_year.required' => 'Tahun berdiri wajib diisi',
            'established_year.max' => 'Tahun berdiri tidak valid',
            'short_description.required' => 'Deskripsi singkat wajib diisi',
            'short_description.max' => 'Deskripsi singkat maksimal 255 karakter',
            'full_story.required' => 'Cerita lengkap wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'contact_person.required' => 'Nama kontak wajib diisi',
            'phone_number.required' => 'Nomor telepon wajib diisi',
            'google_maps_link.url' => 'Link Google Maps harus berupa URL valid',
            'instagram_link.url' => 'Link Instagram harus berupa URL valid',
            'thumbnail.image' => 'Thumbnail harus berupa gambar',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB',
            'meta_title.max' => 'Meta title maksimal 70 karakter',
            'meta_description.max' => 'Meta description maksimal 160 karakter'
        ];
    }

    /**
     * Prepare the data for validation
     */
    protected function prepareForValidation()
    {
        if ($this->has('name') && !$this->has('slug')) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->name)
            ]);
        }
    }
}