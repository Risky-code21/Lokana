<?php

namespace App\Services;

use App\Events\ArticleStatusUpdated;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;
use Illuminate\Support\Facades\Auth;

class ArticleService
{
    public function __construct(protected MediaService $mediaService) {}

    // =========================================================================
    // 🟢 USER SIDE (Public Access)
    // =========================================================================

    /**
     * Mengambil artikel yang sudah publish dengan filter & pagination
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

    // app/Services/ArticleService.php

    public function getPopularArticle(array $filters = [])
    {
        // 1. Gunakan Query Dasar (sama seperti getPublishedArticles)
        $query = Article::query()->where('status', 'publish');

        // 2. Terapkan Filter (Copy logic filter dari getPublishedArticles atau refactor jadi private function)
        if (isset($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['category'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('name', $filters['category']);
            });
        }

        // 3. LOGIC POPULER (Views + Likes)
        // Kita urutkan berdasarkan View terbanyak, lalu Like terbanyak
        return $query
            ->orderBy('views_count', 'desc') // Langsung order saja
            ->orderBy('likes_count', 'desc')
            ->first();
    }

    /**
     * Detail Artikel User
     */
    public function getArticleBySlug(string $slug): Article
    {
        return Article::where('slug', $slug)
            ->where('status', 'publish')
            ->with(['medias', 'author', 'category', 'comments.user']) // Load komen & user-nya
            ->withCount(['views', 'comments', 'likes'])
            ->firstOrFail();
    }

    /**
     * Logika Like/Unlike (Toggle)
     */
    public function toggleLike(Article $article, User $user): array
    {
        // Cek apakah user sudah like?
        // Asumsi relasi likes() adalah MorphMany atau HasMany
        $existingLike = $article->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $status = 'unliked';
        } else {
            $article->likes()->create([
                'user_id' => $user->id
            ]);
            $status = 'liked';
        }

        // 🔥 Broadcast Update ke Reverb (Update jumlah like realtime)
        $this->broadcastUpdate($article);

        return [
            'status' => $status,
            'total_likes' => $article->likes()->count()
        ];
    }

    /**
     * Mencatat View & Broadcast Realtime
     */
    public function recordView(Article $article, string $ip, string $userAgent): void
    {
        // Cek duplikasi view sederhana (opsional: bisa pakai Session/Cache untuk throttle)
        // Disini kita insert saja sesuai request
        $existingView = $article->views()->where('ip_address', $ip)->where('user_agent', $userAgent)->first();
        if (!$existingView) {
            $article->views()->create([
                'visitor_id' => random_int(2, 20),
                'ip_address' => $ip,
                'user_agent' => $userAgent // Pastikan nama kolom di DB 'user_agent' atau sesuaikan
            ]);
        }

        // 🔥 Broadcast Update ke Reverb (Update jumlah view realtime)
        $this->broadcastUpdate($article);
    }

    // =========================================================================
    // 🔴 ADMIN SIDE (Management)
    // =========================================================================

    /**
     * List Artikel untuk Admin (Bisa lihat draft & published)
     * + Fitur Filter Admin
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
     * Create Article
     */
    public function createArticle(array $data): Article
    {
        return DB::transaction(function () use ($data) {
            // 1. Simpan Data Artikel
            $article = Article::create([
                'title'             => $data['title'],
                'slug'              => \Illuminate\Support\Str::slug($data['title']), // Auto slug
                'author_id'         => Auth::id(),
                'category_id'       => $data['category_id'],
                'short_description' => $data['short_description'],
                'content'           => $data['content'],
                'status'            => $data['status'] ?? 'draft',
            ]);

            // 2. Upload Media (Integrasi MediaService Baru)
            if (isset($data['medias']) && is_array($data['medias'])) {
                foreach ($data['medias'] as $file) {
                    // Panggil MediaService yang sudah kita refactor (Logic MD5 & Local Storage)
                    $this->mediaService->upload(
                        $article,
                        $file,
                        'article-images' // Nama folder penyimpanan
                    );
                }
            }

            return $article;
        });
    }

    /**
     * Update Article
     */
    public function updateArticle(Article $article, array $data): Article
    {
        return DB::transaction(function () use ($article, $data) {
            // 1. Update Data Text
            $article->update([
                'title'             => $data['title'],
                // Slug update opsional, hati-hati SEO rusak jika slug berubah
                'category_id'       => $data['category_id'],
                'short_description' => $data['short_description'],
                'content'           => $data['content'],
                'status'            => $data['status'] ?? $article->status,
            ]);

            // 2. Tambah Media Baru (Jika ada upload baru saat edit)
            if (isset($data['medias']) && is_array($data['medias'])) {
                foreach ($data['medias'] as $file) {
                    $this->mediaService->upload($article, $file, 'article-images');
                }
            }

            // Catatan: Untuk menghapus media spesifik, sebaiknya buat endpoint terpisah 
            // misal: DELETE /media/{id} yang memanggil MediaService->deleteById($id)

            return $article;
        });
    }

    /**
     * Delete Single Article
     */
    public function deleteArticle(Article $article): bool
    {
        return DB::transaction(function () use ($article) {
            // 1. Hapus Media Fisik & Record via MediaService
            $this->mediaService->delete($article);

            // 2. Hapus Artikel
            return $article->delete();
        });
    }

    /**
     * 🔥 Mass Delete (Menghapus Banyak sekaligus)
     */
    public function massDelete(array $articleIds): int
    {
        $count = 0;
        // Kita looping agar logic MediaService::delete() tetap terpanggil per artikel
        // Jangan pakai Article::whereIn(...)->delete() karena itu bypass logic hapus gambar!

        $articles = Article::whereIn('id', $articleIds)->get();

        foreach ($articles as $article) {
            $this->deleteArticle($article); // Reuse fungsi delete single di atas
            $count++;
        }

        return $count;
    }

    // =========================================================================
    // 📡 PRIVATE HELPERS
    // =========================================================================

    /**
     * Helper untuk dispatch event Reverb
     */
    private function broadcastUpdate(Article $article): void
    {
        // Refresh model untuk mendapatkan count terbaru (likes/views)
        // Kita load count-nya saja agar ringan payload-nya
        $article->loadCount(['views', 'likes', 'comments']);

        // Dispatch Event
        ArticleStatusUpdated::dispatch($article);
    }
}
