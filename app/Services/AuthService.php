<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function registerUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password']
            ]);
        });
    }

    public function autentikasiUser(array $credential): User
    {
        $user = User::firstOrFail('email', $credential['email']);
        $password = Hash::check($credential['password'], $user->password);

        if (!$user || !$password) {
            throw ValidationException::withMessages([
                'email' => ['incorrect email or password.'],
            ]);
        }

        return $user;
    }

    public function logoutUser()
    {
        return Auth::logout();
    }
}
