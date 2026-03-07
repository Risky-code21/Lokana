<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Services\AuthService;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     *  @todo Constructor untuk menginisialisasi AuthService
     *  yang akan digunakan di dalam controller ini.
     *
     *  @param AuthService $authService untuk layanan autentikasi
     */
    public function __construct(protected AuthService $authService) {}

    /**
     *  @todo Function untuk menampilkan halaman register
     *
     *  @return View untuk menampilkan view halaman register
     */
    public function index(): View
    {
        return view('pages.auth.register');
    }

    /**
     *  @todo untuk melakukan chceking ketersediaan data user dan kemudian registrasi user.
     *
     *  @param RegisterUserRequest $request untuk validasi request registrasi
     *  @return RedirectResponse untuk mengarahkan user ke halaman landing page semula
     */
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        try {
            $user = $this->authService->registerUser($request->validated());

            // Melakukan login user setelah registrasi berhasil
            Auth::login($user);

            // Regenerate session untuk mencegah session fixation attack
            $request->session()->regenerate();

            // Mengarahkan user ke halaman landing page semula namun dengan fitur autentikasi yang sudah aktif
            return redirect()->intended('landing-page');
        }
        // Error database
        catch (QueryException $e) {
            // Race condition untuk email unik
            $errorCode = $e->errorInfo[1];

            // Untuk audit error dengan logging
            Log::error('Registration error: ' . $e->getMessage());

            // Race condition email sudah terdaftar
            if ($errorCode == 1062) {
                return redirect()->back()->withErrors(['email' => 'The email has already been registered.'])->withInput();
            }

            return redirect()->back()->withErrors(['error' => 'An error occurred while processing your registration. Please try again.'])->withInput();
        }
        // Error umum
        catch (\Exception $e) {

            // Untuk audit error dengan logging
            Log::error('Registration error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
        }
    }
}
