<?php

namespace App\Services;

use App\Events\ArticleStatusUpdated;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ArticleService
{
    public function __construct(protected MediaService $mediaService) {}

    // ----------------------------------------------------- User

    /**
     *  Function untuk mendapatkan data article untuk ditampilkan di sisi user
     *
     *  @param array $filters
     *  @param integer $perPage
     *  @return LengthAwarePaginator
     */
    public function getPublishedArticles(array $filters = [], int $perPage = 6): LengthAwarePaginator
    {
        // 1. Gunakan 'query()' bukan 'all()' agar tidak memuat seluruh DB ke RAM
        $query = Article::query()
            ->where('status', 'publish') // Pastikan status sesuai enum di database
            ->with(['medias', 'author', 'category']) // Eager load relasi penting
            ->withCount(['views', 'comments', 'likes']) // Hitung statistik
            ->latest(); // Urutkan dari yang terbaru

        // 2. Filter Kategori
        if (!empty($filters['category'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('name', $filters['category']); // Asumsi filter pakai slug kategori
            });
        }

        // 3. Filter Pencarian (Title / Content)
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    /**
     *  Function untuk menggambil data article
     *
     *  @param array $filters
     *  @return Query
     */
    public function getPopularArticle(array $filters = [])
    {
        //Gunakan Query Dasar (sama seperti getPublishedArticles)
        $query = Article::query()->where('status', 'publish');

        //Terapkan Filter (Copy logic filter dari getPublishedArticles atau refactor jadi private function)
        if (isset($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['category'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('name', $filters['category']);
            });
        }

        // Kita urutkan berdasarkan View terbanyak, lalu Like terbanyak
        return $query
            ->orderBy('views_count', 'desc')
            ->orderBy('likes_count', 'desc')
            ->first();
    }

    /**
     *  Function untuk mengambil article berdasarkan slugnya
     * 
     *  @param string $slug
     *  @return Article
     */
    public function getArticleBySlug(string $slug): Article
    {
        return Article::where('slug', $slug)
            ->where('status', 'publish')
            ->with(['medias', 'author', 'category', 'comments.user'])
            ->withCount(['views', 'comments', 'likes'])
            ->firstOrFail();
    }


    // ----------------------------------------------------- Admin

    /**
     *  Function untuk menampilkan article pada index admin
     *
     * @param array $filters
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAdminArticles(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Article::query()
            ->with(['author', 'category'])
            ->withCount(['views', 'comments', 'likes'])
            ->latest();

        // Filter Status (Draft/Published)
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter Pencarian Judul
        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        return $query->paginate($perPage);
    }

    /**
     *  Function untuk membuat sebuah article baru
     *
     *  @param array $data
     *  @return Article
     */
    public function createArticle(array $data): Article
    {
        // Penggunaan db transaction untuk bisa rollback jika ada proses tak terduga yang bisa saja merusak database
        return DB::transaction(function () use ($data) {

            // pembuatan article menggunakan data yang diteruskan melalui controller sebelumnya
            $article = Article::create([
                'title'             => $data['title'],
                'slug'              => \Illuminate\Support\Str::slug($data['title']),
                'author_id'         => Auth::id(),
                'category_id'       => $data['category_id'],
                'short_description' => $data['short_description'],
                'content'           => $data['content'],
                'status'            => $data['status'] ?? 'draft',
            ]);

            // Insert foto thumbnail article
            if (isset($data['thumbnail'])) {
                $this->mediaService->upload(
                    $article,
                    $data['thumbnail'],
                    'article-thumbnails-images',
                    true
                );
            }

            return $article;
        });
    }

    /**
     *  Function untuk update article
     *
     *  @param Article $article
     *  @param array $data
     *  @return Article
     */
    public function updateArticle(Article $article, array $data): Article
    {
        return DB::transaction(function () use ($article, $data) {
            // pembuatan article menggunakan data yang diteruskan melalui controller sebelumnya
            $article->update([
                'title'             => $data['title'],
                'slug'              => \Illuminate\Support\Str::slug($data['title']),
                'author_id'         => Auth::id(),
                'category_id'       => $data['category_id'],
                'short_description' => $data['short_description'],
                'content'           => $data['content'],
                'status'            => $data['status'] ?? 'draft',
            ]);

            // Insert foto thumbnail article
            if (isset($data['thumbnail'])) {
                $this->mediaService->upload(
                    $article,
                    $data['thumbnail'],
                    'article-thumbnails-images',
                    true
                );
            }

            return $article;
        });
    }

    /**
     *  Function untuk menghapus article tunggal
     *
     *  @param Article $article
     *  @return boolean
     */
    public function deleteArticle(Article $article): bool
    {
        return DB::transaction(function () use ($article) {
            $this->mediaService->delete($article);
            return $article->delete();
        });
    }

    /**
     *  Function untuk menghapus beberapa article sekaligus
     *
     *  @param array $articleIds
     *  @return integer
     */
    public function massDelete(array $articleIds): int
    {
        $count = 0;
        $articles = Article::whereIn('id', $articleIds)->get();

        foreach ($articles as $article) {
            $this->deleteArticle($article);
            $count++;
        }

        return $count;
    }
}
