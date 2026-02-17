<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryArticle;
use App\Http\Requests\CategoryArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CategoryArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10); // Definisikan $perPage di sini
        
        $categories = CategoryArticle::query()
            ->withCount('articles') // Tambahkan ini untuk menghitung jumlah artikel
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
            
        // Get stats
        $stats = [
            'total' => CategoryArticle::count(),
            'with_articles' => CategoryArticle::has('articles')->count(),
            'empty' => CategoryArticle::doesntHave('articles')->count(),
        ];
        
        return view('pages.admin.category-articles.index', compact('categories', 'search', 'perPage', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.category-articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryArticleRequest $request)
    {
        try {
            CategoryArticle::create($request->validated());
            
            return redirect()->route('admin.article-categories.index')
                ->with('success', 'Kategori artikel berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryArticle $category_article)
    {
        $category = $category_article->load(['articles' => function($query) {
            $query->latest()->limit(10);
        }]);
        
        return view('pages.admin.category-articles.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryArticle $category_article)
    {
        return view('pages.admin.category-articles.edit', compact('category_article'));
    }

    /**
     * Update the specified resource in storage.
     */
/**
 * Update the specified resource in storage.
 */
    public function update(CategoryArticleRequest $request, CategoryArticle $category_article)
    {
        try {
            $category_article->update($request->validated());
            
            return redirect()->route('admin.article-categories.index')
                ->with('success', 'Kategori artikel berhasil diperbarui.');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryArticle $category_article)
    {
        // Check if category has articles
        if ($category_article->articles()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki artikel.');
        }
        
        try {
            $category_article->delete(); // Hard delete
            
            return redirect()->route('admin.article-categories.index')
                ->with('success', 'Kategori artikel berhasil dihapus.');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete categories
     */
    public function bulkDestroy(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:category_articles,id'
        ]);
        
        try {
            $categoriesToDelete = CategoryArticle::whereIn('id', $request->ids)
                ->whereDoesntHave('articles')
                ->get();
            
            $deletedIds = $categoriesToDelete->pluck('id')->toArray();
            
            if (empty($deletedIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada kategori yang dapat dihapus karena semua memiliki artikel.'
                ], 400);
            }
            
            $count = CategoryArticle::whereIn('id', $deletedIds)->delete(); // Hard delete
            
            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$count} kategori artikel.",
                'count' => $count
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get categories for select dropdown (AJAX)
     */
    public function getCategories(Request $request): JsonResponse
    {
        $search = $request->get('search', '');
        
        $categories = CategoryArticle::query()
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