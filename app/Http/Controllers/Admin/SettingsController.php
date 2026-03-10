<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Show settings page.
     */
    public function index()
    {
        $user = auth()->user();
        return view('pages.admin.settings.index', compact('user'));
    }

    /**
     * Update profile.
     */
    public function updateProfile(ProfileRequest $request)
    {
        try {
            $user = auth()->user();
            $data = $request->validated();
            
            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }
            
            $user->update($data);
            
            return back()->with('success', 'Profil berhasil diperbarui.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    /**
     * Update password.
     */
    public function updatePassword(PasswordRequest $request)
    {
        try {
            $user = auth()->user();
            
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            
            return back()->with('success', 'Password berhasil diperbarui.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui password: ' . $e->getMessage());
        }
    }
}