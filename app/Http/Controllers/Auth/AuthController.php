<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthUserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected function __construct(protected AuthService $authService) {}


    public function index()
    {
        return view('pages.auth.login');
    }

    public function store(AuthUserRequest $request)
    {
        try {
            $user = $this->authService->autentikasiUser($request->validate());

            Auth::login($user, $request->boolean('remember_me'));

            $request->session()->regenerate();

            // Akan dihapus, karena sistem login user tidak menggunakan dashboard kecuali admin
            return redirect()->intended('dashboard');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Login failed. Please try again.'])->withInput();
        }
    }
}
