<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreArticleRequest;
use App\Http\Requests\Admin\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category_article;
use App\Services\ArticleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
     *  Function untuk menampilkan tampilan page create article
     *
     *  @return View
     */
    public function create(): View
    {
        // Ambil kategori article yang tersedia untuk dropdown choose category
        $categories = Category_article::all();

        // Kembalikan view beserta variable categories yang sudah dibuat
        return view('pages.testing', compact('categories'));
    }


    /**
     * Function untuk membuat article baru berdasarkan request yang dikirim
     *
     *  @param StoreArticleRequest $request
     *  @return RedirectResponse
     */
    public function store(StoreArticleRequest $request): RedirectResponse
    {
        // Array data untuk dikirim ke function yang ada didalam article service
        $data = [
            'title'             => $request->title,
            'category_id'       => $request->category_id,
            'short_description' => $request->short_description,
            'content'           => $request->content,
            // Jika status tidak di set maka otomatis mengisi status dengan publish
            'status'            => $request->status ?? 'publish',
            'thumbnail'            => $request->file('thumbnail')
        ];

        // Block try catch untuk menangkap error serta membatalkan proses jika terdapat error yang terjadi pada saat service berjalan
        try {
            // Function create article pada article service
            $this->articleService->createArticle($data);

            // Setelah berhasil membuat article kembalikan flash data untuk state alert
            return redirect()->route('article.index')->with('success', 'Article published successfully!');
        }
        // Tangkap error yang umum
        catch (\Exception $e) {
            // Sajikan dalam audit log agar bisa melihat ghost error
            Log::error('Article create error: ' . $e->getMessage());

            // Kembali ke page yang sama ( create ) dengan flash data error untuk state alert
            return back()->with('error', 'Gagal membuat artikel: ' . $e->getMessage())->withInput();
        }
    }

    /**
     *  Function untuk menangkap request foto yang dikirim dari edtitor floara
     *
     *  @param Request $request
     *  @return JsonResponse
     */
    public function uploadFromEditor(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('editor-images-article', $filename, 'public');

                // Return response JSON supaya flora bisa otomatis menyimpan gambarnya
                return response()->json([
                    'link' => asset('storage/' . $path)
                ]);
            }
        } catch (\Exception $e) {
            // Audit error untuk floara editor yang digunakan didalam menu admin
            Log::error('Floara text editor error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     *  Function untuk delete article
     *
     *  @param Article $article
     *  @return RedirectResponse
     */
    public function delete(Article $article): RedirectResponse
    {
        try {
            $this->articleService->deleteArticle($article);

            return redirect()->back()->with(['success', 'Berhasil hapus article']);
        } catch (\Exception $e) {

            //  Audit log
            Log::error('delete article error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal hapus article'])->withInput();
        }
    }


    /**
     *  Function untuk menampilkan edit page dari article yang dipilih
     *
     *  @param [type] $slug
     *  @return View
     */
    public function edit($slug): View
    {
        $article = $this->articleService->getArticleBySlug($slug);
        $categories = Category_article::all();
        return view('pages.testing-2', compact(['article', 'categories']));
    }

    // Tukar posisi: Request dulu, baru Article (Best Practice Laravel)
    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {

        // Array data yang akan dikirim kedalam article service
        $data = [
            'title'             => $request->title,
            'category_id'       => $request->category_id,
            'short_description' => $request->short_description,
            'content'           => $request->content,
            'status'            => $request->status ?? 'publish',
            'thumbnail'            => $request->file('thumbnail')
        ];

        try {
            $this->articleService->updateArticle($article, $data);

            return redirect()->route('article.index')->with('success', 'Artikel berhasil diperbarui!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Article update error: ' . $e->getMessage());

            return back()->with('error', 'Gagal update artikel: ' . $e->getMessage())->withInput();
        }
    }
}
