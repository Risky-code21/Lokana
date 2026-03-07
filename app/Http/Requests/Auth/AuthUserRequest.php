<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthUserRequest extends FormRequest
{
    /**
     *  @todo Hentikan validasi pada kegagalan pertama
     *
     *  @var boolean
     */
    protected $stopOnFirstFailure = true;

    /**
     *  @todo untuk menentukan apakah diizinkan melakukan request ini
     *
     *  @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     *  @todo untuk memvalidasi request autentikasi user yang masuk
     *
     *  @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Rules untuk validasi request login user
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'remember_me' => 'sometimes|boolean',
        ];
    }
}
