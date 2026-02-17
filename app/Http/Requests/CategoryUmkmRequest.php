<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUmkmRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Untuk update, ambil ID dari route parameter
        // Untuk create, ID = null
        $id = null;
        
        // Cek jika ini update (punya parameter category_umkm di route)
        if ($this->route('category_umkm')) {
            // Jika parameter adalah object CategoryUmkm (route model binding)
            if (is_object($this->route('category_umkm'))) {
                $id = $this->route('category_umkm')->id;
            } 
            // Jika parameter adalah ID (string/number)
            else {
                $id = $this->route('category_umkm');
            }
        }
        
        return [
            'name' => 'required|string|max:255|unique:category_umkms,name,' . ($id ?: 'NULL') . ',id',
            'description' => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi',
            'name.unique' => 'Nama kategori sudah digunakan',
            'description.required' => 'Deskripsi wajib diisi',
            'description.max' => 'Deskripsi maksimal 500 karakter',
        ];
    }
}