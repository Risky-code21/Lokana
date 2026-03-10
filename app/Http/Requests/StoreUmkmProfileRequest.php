<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUmkmProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            // PERBAIKAN: ganti dari 'users' ke 'pelaku_umkms'
            'pelaku_umkm' => 'required|exists:pelaku_umkms,id',
            
            'nama_pemilik' => 'required|string|max:255',
            'tahun_berdiri' => 'required|integer|min:1900|max:' . date('Y'),
            'category_id' => 'required|exists:category_umkms,id',
            
            // SOSIAL MEDIA - SUDAH NULLABLE (TIDAK PERLU DIISI)
            'instagram_link' => 'nullable|url|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'contact_person_name' => 'required|string|max:255',
            'contact_person_phone' => 'required|string|max:20',
            'email_umkm' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'facebook_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
            'tiktok_link' => 'nullable|url|max:255',
            
            'short_description' => 'required|string|max:255',
            'content' => 'required|string',
            'address' => 'required|string',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'village' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
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
            'payment_proof' => 'required_if:subscription_plan_id,!=,null|image|mimes:jpeg,png,jpg,pdf|max:5120',
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
            'tahun_berdiri.min' => 'Tahun berdiri minimal 1900',
            'tahun_berdiri.max' => 'Tahun berdiri maksimal ' . date('Y'),
            'category_id.required' => 'Kategori wajib dipilih',
            'category_id.exists' => 'Kategori tidak valid',
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
            
            // Validasi sosial media - nullable jadi tidak ada pesan required
            'instagram_link.url' => 'Link Instagram harus berupa URL yang valid',
            'facebook_link.url' => 'Link Facebook harus berupa URL yang valid',
            'twitter_link.url' => 'Link Twitter harus berupa URL yang valid',
            'tiktok_link.url' => 'Link TikTok harus berupa URL yang valid',
            'website.url' => 'Link website harus berupa URL yang valid',
            'email_umkm.email' => 'Format email tidak valid',
            
            'logo.image' => 'Logo harus berupa gambar',
            'logo.max' => 'Logo maksimal 2MB',
            'logo.mimes' => 'Logo harus berformat jpeg, png, atau jpg',
            'thumbnail.image' => 'Thumbnail harus berupa gambar',
            'thumbnail.max' => 'Thumbnail maksimal 2MB',
            'gallery_images.*.image' => 'File gallery harus berupa gambar',
            'gallery_images.*.max' => 'Setiap gambar gallery maksimal 2MB',
            'gallery_images.max' => 'Maksimal 5 gambar gallery',
            'payment_proof.required_if' => 'Bukti pembayaran wajib diupload jika memilih paket subscription',
            'payment_proof.image' => 'Bukti pembayaran harus berupa gambar atau PDF',
            'payment_proof.max' => 'Bukti pembayaran maksimal 5MB',
        ];
    }
}