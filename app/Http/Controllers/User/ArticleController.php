<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\ArticleService;
use App\Models\Category_article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     *  Dependency injection untuk memasukan function yang memuat logika bisnis yang sebelumnya sudah dibuat di article service
     *
     *  @param ArticleService $articleService
     */
    public function __construct(protected ArticleService $articleService) {}

    /**
     *  Function untuk menampilkan view index dari menu article
     *
     *  @param Request $request
     *  @return View
     */
    public function index(Request $request): View
    {
        // Ambil filter, saat ini hanya menyediakan filter category, jika ada filter search bisa langsung ditambahkan karena request filter search sudah bisa digunakan
        $filters = $request->only(['search', 'category']);

        // Panggil Service untuk logic filtering & pagination
        // Untuk menggambil article berdasarkan filter saat ini ( Category )
        $populerArticle = $this->articleService->getPopularArticle($filters);

        // Menggambil article lainnya dan ini akan relative terhadap filter tadi
        $articles = $this->articleService->getPublishedArticles($filters);

        // Ambil category atticle untuk membuat filtering pada index
        $categoriesArticle = Category_article::all();

        return view('pages.user.article.index', compact('articles', 'populerArticle', 'categoriesArticle'));
    }

    /**
     *  Function untuk menampilkan detail article page
     *
     *  @param Request $request
     *  @param [type] $slug
     *  @return void
     */
    public function show(Request $request, $slug)
    {
        // Seleksi article berdasarkan slug yang diambil dari param url
        $article = Article::where('slug', $slug)->firstOrFail();

        // Otomatis record atau menambahkan 1 view pada article yang dipilih
        $article->recordView();


        // Menggambil komentar
        // Walau kita hanya memanggil komentar parent saja, kita sudah mengambil reply komentar beserta isi dari reply tersebut, mempaginate untuk fitur load more
        $comments = Comment::with(['user', 'replies.user'])
            ->where('commentable_type', 'article')
            ->where('commentable_id', $article->id)
            ->whereNull('parent_id')
            ->latest()
            ->paginate(5);

        // Menggambil article yang sangat berdekatan atau memiliki hal yang sama antara author dan category namenya dan wajib article yang memiliki status publish
        $relatedArticle = Article::query()
            ->where('status', 'publish')
            ->where('id', '!=', $article->id)
            ->where(function ($query) use ($article) {
                $query->where('category_id', $article->category_id)
                    ->orWhere('author_id', $article->author->id);
            })
            ->inRandomOrder()
            ->limit(3)
            ->get();


        // Menggambil request dari load more button yang ada pada view sekarang
        if ($request->ajax()) {
            $html = '';

            // Looping komentar baru, lalu render component 'comment-bubble component' menjadi string HTML
            foreach ($comments as $comment) {
                $html .= view('components.comment-bubble', [
                    'comment' => $comment,
                    'modelSlug' => $article->slug
                ])->render();
            }

            // Kembalikan dalam bentuk JSON
            return response()->json([
                'html' => $html,
                'hasMore' => $comments->hasMorePages()
            ]);
        }

        // Jika halaman baru pertama kali halaman di load maka gunakan terusan blade seperti biasanya
        return view('pages.user.article.detail-article', compact('article', 'comments', 'relatedArticle'));
    }
}
