<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthUserRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     *  @todo Constructor untuk menginisialisasi AuthService
     *  yang akan digunakan di dalam controller ini.
     *
     *  @param AuthService $authService untuk layanan autentikasi
     */
    public function __construct(protected AuthService $authService) {}

    /**
     *  @todo Function untuk menampilkan halaman login 
     *
     *  @return View untuk menampilkan view halaman login
     */
    public function index(): View
    {
        return view('pages.auth.login');
    }

    /**
     *  @todo Function untuk melakukan autentikasi user
     *  berdasarkan data yang dikirimkan dari form login.
     *  Jika berhasil, user akan diarahkan ke halaman landing page semula
     *
     *  @param AuthUserRequest $request untuk validasi request login
     *  @return RedirectResponse untuk mengarahkan user ke halaman landing page semula
     */
    public function store(AuthUserRequest $request): RedirectResponse
    {
        try {
            $user = $this->authService->autentikasiUser($request->validated());

            // Melakukan login user dengan opsi remember me jika dipilih
            Auth::login($user, $request->boolean('remember_me'));

            // Regenerate session untuk mencegah session fixation attack
            $request->session()->regenerate();

            // Mengarahkan user ke halaman landing page semula namun dengan fitur autentikasi yang sudah aktif
            if ($user->role == 'admin') {
                return redirect()->intended('admin/dashboard');
            }
            return redirect()->intended('/');
        }
        // Lempar kembali agar ditangani otomatis oleh Handler Laravel
        // (Akan otomatis redirect back dengan pesan error asli)
        catch (ValidationException $e) {
            throw $e;
        }
        // Error umum, errornya bisa menerima error apa saja 
        catch (\Exception $e) {
            // Untuk audit error dengan logging
            Log::error('Login error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Login failed. Please try again.'])->withInput();
        }
    }
}
