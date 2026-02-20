<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleService;
use App\Models\Category_article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function __construct(protected ArticleService $articleService) {}

    // 1. TAMPILKAN FORM
    public function create()
    {
        // Ambil kategori untuk dropdown
        $categories = Category_article::all();
        return view('pages.testing', compact('categories'));
    }

    // 2. API KHUSUS FROALA (Upload Gambar di dalam Text Editor)
    public function uploadFromEditor(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                // Gunakan logic upload manual/service
                // Kita simpan di folder 'editor-images' agar terpisah
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('editor-images', $filename, 'public');

                // Froala BUTUH return JSON format: { "link": "url_gambar" }
                return response()->json([
                    'link' => asset('storage/' . $path)
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Article error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // 3. SIMPAN ARTIKEL UTAMA
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'title'             => 'required|string|max:255',
            'category_id'       => 'required|exists:category_articles,id',
            'short_description' => 'required|string|max:500',
            'content'           => 'required', // Ini HTML dari Froala
            'thumbnail'         => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Thumbnail wajib
        ]);

        // Siapkan data untuk Service
        $data = [
            'title'             => $request->title,
            'category_id'       => $request->category_id,
            'short_description' => $request->short_description,
            'content'           => $request->content,
            'status'            => 'publish', // Default published

            // Masukkan thumbnail ke array 'medias' agar diproses ArticleService
            'medias'            => [$request->file('thumbnail')]
        ];

        try {
            $this->articleService->createArticle($data);
            return redirect()->route('article.index')->with('success', 'Artikel berhasil diterbitkan!');
        } catch (\Exception $e) {
            Log::error('Article error: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat artikel: ' . $e->getMessage())->withInput();
        }
    }

    public function index(Request $request)
    {
        // Ambil filter dari URL (?search=...&category=...)
        $filters = $request->only(['search', 'category']);

        // Panggil Service untuk logic filtering & pagination
        $populerArticle = $this->articleService->getPopularArticle($filters);
        $articles = $this->articleService->getPublishedArticles($filters);
        $categoriesArticle = Category_article::all();

        return view('pages.user.article.index', compact('articles', 'populerArticle', 'categoriesArticle'));
    }

    /**
     * Halaman Detail Artikel
     */
    public function show(Request $request, $slug)
    {
        // 1. Ambil data artikel
        $article = Article::where('slug', $slug)->firstOrFail();

        // 2. Ambil komentar khusus PARENT saja (parent_id = null)
        // Gunakan paginate(5) agar diload 5 per 5
        $comments = Comment::with(['user', 'replies.user']) // Eager load biar cepat
            ->where('commentable_type', 'article') // Asumsi pakai polymorphic
            ->where('commentable_id', $article->id)
            ->whereNull('parent_id') // Kunci utama: Hanya Induk
            ->latest()
            ->paginate(5);

        $relatedArticle = Article::query()
            ->where('status', 'publish')       // Pastikan hanya artikel publish
            ->where('id', '!=', $article->id)  // PENTING: Jangan tampilkan artikel yang sedang dibaca saat ini
            ->where(function ($query) use ($article) {
                // Logic: Kategori Sama ATAU Author Sama
                $query->where('category_id', $article->category_id) // Pakai ID lebih cepat daripada whereHas name
                    ->orWhere('author_id', $article->author->id);   // Atau penulisnya sama
            })
            ->inRandomOrder() // Acak urutannya
            ->limit(3)        // Batasi cuma 3 artikel (biar layout tidak rusak)
            ->get();          // <--- WAJIB: Eksekusi query menjadi Collection

        // 3. LOGIKA SAKTI AJAX: 
        // Jika request datang dari tombol "Load More" (bukan dari ngetik URL biasa)
        if ($request->ajax()) {
            $html = '';

            // Looping komentar baru, lalu render component 'comment-item' menjadi string HTML
            foreach ($comments as $comment) {
                $html .= view('components.comment-bubble', [
                    'comment' => $comment,
                    'articleSlug' => $article->slug
                ])->render();
            }

            // Kembalikan dalam bentuk JSON
            return response()->json([
                'html' => $html,
                'hasMore' => $comments->hasMorePages() // true jika masih ada halaman berikutnya
            ]);
        }

        // 4. Jika load halaman pertama kali (bukan AJAX), render view detail artikel biasa
        return view('pages.user.article.detail-article', compact('article', 'comments', 'relatedArticle'));
    }

    public function delete(Article $article)
    {
        try {
            $this->articleService->deleteArticle($article);

            Log::error('Berhasil hapus article');
            return redirect()->back()->with(['success', 'Berhasil hapus article']);
        } catch (\Exception $e) {
            Log::error('delete article error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal hapus article'])->withInput();
        }
    }

    public function edit($slug)
    {
        $article = $this->articleService->getArticleBySlug($slug);
        $categories = Category_article::all();
        return view('pages.testing-2', compact(['article', 'categories']));
    }

    // Tukar posisi: Request dulu, baru Article (Best Practice Laravel)
    public function update(Request $request, Article $article)
    {
        // 1. Validasi
        $request->validate([
            'title'             => 'required|string|max:255',
            'category_id'       => 'required|exists:category_articles,id', // Sesuaikan nama tabel kategori anda
            'short_description' => 'required|string|max:500',
            'content'           => 'required',

            // PERBAIKAN 1: Gunakan 'nullable'. 
            // Artinya: User Boleh kosongkan jika tidak ingin ganti gambar.
            'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 2. Siapkan Data Dasar
        $data = [
            'title'             => $request->title,
            'category_id'       => $request->category_id,
            'short_description' => $request->short_description,
            'content'           => $request->content,
            // Opsional: Jangan hardcode 'publish', gunakan status lama atau input user
            'status'            => $article->status,
        ];

        // PERBAIKAN 2: Logika Upload Bersyarat
        // Hanya masukkan ke array 'medias' JIKA user benar-benar upload file baru
        if ($request->hasFile('thumbnail')) {
            $data['medias'] = [$request->file('thumbnail')];
        }

        try {
            // Panggil Service
            // Service kita sebelumnya sudah punya logic: "if (isset($data['medias'])) { upload... }"
            // Jadi kalau key 'medias' tidak ada, dia aman (gambar lama tidak terhapus).
            $this->articleService->updateArticle($article, $data);

            return redirect()->route('article.index')->with('success', 'Artikel berhasil diperbarui!');
        } catch (\Exception $e) {
            // Gunakan Log facade agar error tercatat di storage/logs/laravel.log
            \Illuminate\Support\Facades\Log::error('Article update error: ' . $e->getMessage());

            return back()->with('error', 'Gagal update artikel: ' . $e->getMessage())->withInput();
        }
    }

    public function like(Article $article)
    {
        // 1. Pastikan User Login (Proteksi ganda selain Route)
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            // 2. Panggil Service toggleLike
            $this->articleService->toggleLike($article, Auth::user());

            // 3. Kembalikan JSON (Status & Total Likes baru)
            // return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
