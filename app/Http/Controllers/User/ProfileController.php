<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profile user
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $user = Auth::user();

        // Query khusus untuk Liked Articles agar BISA DI-PAGINATE
        $likedArticles = $user->likes()
            ->where('likeable_type', 'article')
            ->hasMorph('likeable', [Article::class])
            ->with([
                'likeable' => function (MorphTo $morphTo) {
                    $morphTo->morphWith([
                        Article::class => ['author', 'category', 'medias', 'views']
                    ]);
                }
            ])
            ->paginate(4);

        return view('pages.user.profile.profile', compact('user', 'likedArticles'));
    }

    /**
     * Update Username dan Avatar (Tab Profile)
     */
    public function updateIdentity(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB
        ]);

        if ($request->hasFile('avatar')) {
            // Hapus foto lama dari storage fisik jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan foto baru dan catat path-nya
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->name = $validated['name'];
        $user->save();

        return redirect()->route('profiles.index')->with('success', 'Profile identity updated successfully.');
    }

    /**
     * Update Email dan Password (Tab Settings)
     */
    public function updateSecurity(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Cek jika email berubah
        if ($user->email !== $validated['email']) {
            $user->email = $validated['email'];
            $user->email_verified_at = null; // Memaksa user verifikasi ulang (opsional)
        }

        // Cek jika user ingin ganti password
        if ($request->filled('new_password')) {
            // Validasi password lama
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password does not match.']);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return redirect()->route('profiles.index')->with('success', 'Security settings updated successfully.');
    }

    /**
     * Hapus Akun (Danger Zone)
     */
    public function destroy(): RedirectResponse
    {
        $user = Auth::user();

        // Bersihkan foto dari storage sebelum akun dihapus
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();
        Auth::logout();

        return redirect()->route('landing-page')->with('success', 'Your account has been deleted successfully.');
    }
}
