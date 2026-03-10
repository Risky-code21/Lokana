<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index(Request $request)
    {
        $search = $request->get('search', '');
        $role = $request->get('role', '');
        $perPage = $request->get('per_page', 10);
        
        // Debugging - lihat apa yang diterima dari request
        Log::info('Filter role: ' . $role);
        Log::info('Search: ' . $search);
        
        $query = User::query();
        
        // Filter berdasarkan search
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        // Filter berdasarkan role
        if (!empty($role) && $role !== 'all') {
            $query->where('role', $role);
            Log::info('Applying role filter: ' . $role);
        }
        
        // Urutkan dan paginasi
        $users = $query->latest()->paginate($perPage)->withQueryString();
        
        // Debugging - lihat jumlah hasil
        Log::info('Total users found: ' . $users->total());
            
        // Get stats
        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'user' => User::where('role', 'user')->count(),
        ];
        
        return view('pages.admin.users.index', compact('users', 'search', 'role', 'perPage', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $data = $request->validated();
            
            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }
            
            // Hash password
            $data['password'] = Hash::make($data['password']);
            
            User::create($data);
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('pages.admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('pages.admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            $data = $request->validated();
            
            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }
            
            // Handle password
            if ($request->filled('password')) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            
            $user->update($data);
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil diperbarui.');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Cegah admin menghapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        
        try {
            // Delete avatar
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $user->delete();
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil dihapus.');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete users
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id'
        ]);
        
        try {
            // Filter out current user
            $ids = array_filter($request->ids, function($id) {
                return $id != auth()->id();
            });
            
            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus akun Anda sendiri.'
                ], 400);
            }
            
            // Delete avatars
            $users = User::whereIn('id', $ids)->get();
            foreach ($users as $user) {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }
            
            $count = User::whereIn('id', $ids)->delete();
            
            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$count} user."
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus user: ' . $e->getMessage()
            ], 500);
        }
    }
}