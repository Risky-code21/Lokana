<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // Ambil ID dari route dengan cara yang benar
        $userId = $this->route('user');
        
        // Jika ada ID (update), ambil ID-nya
        // Jika tidak ada (create), set ke null
        $userId = $userId ? $userId->id : null;
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                // Gunakan Rule::unique untuk validasi yang lebih baik
                Rule::unique('users')->ignore($userId),
            ],
            'role' => 'required|in:admin,user',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Password hanya required saat create
        if ($this->isMethod('POST')) {
            $rules['password'] = ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()];
        } else {
            // Saat update, password optional
            $rules['password'] = ['nullable', 'confirmed', Password::min(8)->mixedCase()->numbers()];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'avatar.max' => 'Ukuran gambar maksimal 2MB.',
            'role.required' => 'Role harus dipilih.',
            'role.in' => 'Role tidak valid.',
        ];
    }
}