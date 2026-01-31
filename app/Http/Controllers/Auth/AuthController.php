<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthUserRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function index(): View
    {
        return view('pages.auth.login');
    }

    public function store(AuthUserRequest $request): RedirectResponse
    {
        try {
            $user = $this->authService->autentikasiUser($request->validated());

            Auth::login($user, $request->boolean('remember_me'));

            $request->session()->regenerate();

            // Akan dihapus, karena sistem login user tidak menggunakan dashboard kecuali admin
            return redirect()->intended('dashboard');
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Login failed. Please try again.'])->withInput();
        }
    }
}
