<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    protected function __construct(protected AuthService $authService) {}

    public function index()
    {
        return view('pages.auth.register');
    }

    public function store(RegisterUserRequest $request)
    {
        try {
            $user = $this->authService->registerUser($request->validated());

            Auth::login($user);

            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }
        // Error umum
        catch (\Exception $e) {

            // Untuk audit error
            Log::error('Registration error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
        }
        // Error database
        catch (QueryException $e) {
            // Race condition untuk email unik
            $errorCode = $e->errorInfo[1];

            // Untuk audit error
            Log::error('Registration error: ' . $e->getMessage());

            if ($errorCode == 1062) {
                return redirect()->back()->withErrors(['email' => 'The email has already been registered.'])->withInput();
            }

            return redirect()->back()->withErrors(['error' => 'An error occurred while processing your registration. Please try again.'])->withInput();
        }
    }
}
