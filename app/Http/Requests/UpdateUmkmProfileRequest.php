<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUmkmProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            // PERBAIKAN: ganti dari 'users' ke 'pelaku_umkms'
            'pelaku_umkm' => 'sometimes|required|exists:pelaku_umkms,id',
            
            'nama_pemilik' => 'sometimes|required|string|max:255',
            'tahun_berdiri' => 'sometimes|required|integer|min:1900|max:' . date('Y'),
            'category_id' => 'sometimes|required|exists:category_umkms,id',
            
            // SOSIAL MEDIA - SUDAH NULLABLE
            'instagram_link' => 'nullable|url|max:255',
            'whatsapp_number' => 'sometimes|required|string|max:20',
            'contact_person_name' => 'sometimes|required|string|max:255',
            'contact_person_phone' => 'sometimes|required|string|max:20',
            'email_umkm' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'facebook_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
            'tiktok_link' => 'nullable|url|max:255',
            
            'short_description' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'address' => 'sometimes|required|string',
            'province' => 'sometimes|required|string|max:100',
            'city' => 'sometimes|required|string|max:100',
            'district' => 'sometimes|required|string|max:100',
            'village' => 'sometimes|required|string|max:100',
            'postal_code' => 'sometimes|required|string|max:10',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gallery_images' => 'nullable|array|max:5',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'subscription_plan_id' => 'nullable|exists:subscription_plans,id',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:5120',
            'profile_status' => 'nullable|in:draft,pending,published,archived',
            'verification_status' => 'nullable|in:pending,verified,rejected',
            'is_featured' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama UMKM wajib diisi',
            'pelaku_umkm.required' => 'Pemilik UMKM wajib dipilih',
            'pelaku_umkm.exists' => 'Pemilik UMKM tidak valid',
            'nama_pemilik.required' => 'Nama pemilik wajib diisi',
            'tahun_berdiri.required' => 'Tahun berdiri wajib diisi',
            'tahun_berdiri.integer' => 'Tahun berdiri harus angka',
            'category_id.required' => 'Kategori wajib dipilih',
            'whatsapp_number.required' => 'Nomor WhatsApp wajib diisi',
            'contact_person_name.required' => 'Nama contact person wajib diisi',
            'contact_person_phone.required' => 'Nomor telepon contact person wajib diisi',
            'short_description.required' => 'Deskripsi singkat wajib diisi',
            'content.required' => 'Konten lengkap wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'province.required' => 'Provinsi wajib diisi',
            'city.required' => 'Kota/Kabupaten wajib diisi',
            'district.required' => 'Kecamatan wajib diisi',
            'village.required' => 'Kelurahan/Desa wajib diisi',
            'postal_code.required' => 'Kode pos wajib diisi',
        ];
    }
}