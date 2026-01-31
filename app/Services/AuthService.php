<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     *  @todo memembuat data user baru untuk registrasi user
     *
     *  @param array $data menerima array data user
     *  @return User mengembalikan instance user yang sudah dibuat
     */
    public function registerUser(array $data): User
    {
        // Menggunakan transaction untuk memastikan integritas data dan fallback jika terjadi error
        return DB::transaction(function () use ($data) {
            // Membuat user baru dengan data yang sudah tervalidasi
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password']
            ]);
        });
    }

    /**
     *  @todo melakukan autentikasi user berdasarkan credential yang diberikan
     *
     *  @param array $credential menerima array credential user
     *  @return User mengembalikan instance user yang sudah terautentikasi
     */
    public function autentikasiUser(array $credential): User
    {
        // Mencari user berdasarkan email dan memverifikasi password
        $user = User::firstOrFail('email', $credential['email']);
        $password = Hash::check($credential['password'], $user->password);

        // Jika user tidak ditemukan atau password tidak sesuai, lemparkan exception validasi
        if (!$user || !$password) {
            throw ValidationException::withMessages([
                'email' => ['incorrect email or password.'],
            ]);
        }

        // Mengembalikan instance user yang sudah terautentikasi
        return $user;
    }

    /**
     *  @todo untuk melakukan logout user yang sedang aktif
     *
     *  @return void
     */
    public function logoutUser()
    {
        return Auth::logout();
    }
}
