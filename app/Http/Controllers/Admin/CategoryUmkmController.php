<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryUmkm;
use App\Http\Requests\CategoryUmkmRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CategoryUmkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);
        
        $categories = CategoryUmkm::query()
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
            
        // Get stats
        $stats = [
            'total' => CategoryUmkm::count(),
            'with_umkm' => CategoryUmkm::has('umkmProfiles')->count(),
            'empty' => CategoryUmkm::doesntHave('umkmProfiles')->count(),
        ];
        
        return view('pages.admin.category-umkm.index', compact('categories', 'search', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.category-umkm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryUmkmRequest $request)
    {
        try {
            CategoryUmkm::create($request->validated());
            
            return redirect()->route('admin.category-umkm.index')
                ->with('success', 'Kategori UMKM berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryUmkm $category_umkm)
    {
        $category = $category_umkm->load(['umkmProfiles' => function($query) {
            $query->latest()->limit(10);
        }]);
        
        return view('pages.admin.category-umkm.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryUmkm $category_umkm)
    {
        return view('pages.admin.category-umkm.edit', compact('category_umkm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUmkmRequest $request, CategoryUmkm $category_umkm)
    {
        try {
            $category_umkm->update($request->validated());
            
            return redirect()->route('admin.category-umkm.index')
                ->with('success', 'Kategori UMKM berhasil diperbarui.');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

// Hapus metode bulkDestroy yang kompleks, ganti dengan yang simple:

public function bulkDestroy(Request $request): JsonResponse
{
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:category_umkms,id'
    ]);
    
    try {
        // Hapus logic pengecekan deleted_at
        $categoriesToDelete = CategoryUmkm::whereIn('id', $request->ids)
            ->whereDoesntHave('umkmProfiles')
            ->get();
        
        $deletedIds = $categoriesToDelete->pluck('id')->toArray();
        
        if (empty($deletedIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada kategori yang dapat dihapus karena semua memiliki data UMKM.'
            ], 400);
        }
        
        $count = CategoryUmkm::whereIn('id', $deletedIds)->delete(); // Hard delete
        
        return response()->json([
            'success' => true,
            'message' => "Berhasil menghapus {$count} kategori UMKM.",
            'count' => $count
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus kategori: ' . $e->getMessage()
        ], 500);
    }
}

// Update method destroy:
public function destroy(CategoryUmkm $category_umkm)
{
    // Check if category has UMKM
    if ($category_umkm->umkmProfiles()->count() > 0) {
        return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki data UMKM.');
    }
    
    try {
        $category_umkm->delete(); // Hard delete (tidak pakai soft delete)
        
        return redirect()->route('admin.category-umkm.index')
            ->with('success', 'Kategori UMKM berhasil dihapus.');
            
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
    }
}
    /**
     * Get categories for select dropdown (AJAX)
     */
    public function getCategories(Request $request): JsonResponse
    {
        $search = $request->get('search', '');
        
        $categories = CategoryUmkm::query()
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->limit(20)
            ->get(['id', 'name as text']);
            
        return response()->json([
            'results' => $categories
        ]);
    }
}