<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        // 1. Validasi Input
        $request->validate([
            'content'   => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id', // Cek validitas ID induk jika ada
        ]);

        // 2. Simpan ke Database
        // Kita manfaatkan relasi morphMany 'comments' dari Article
        $article->comments()->create([
            'user_id'   => Auth::id(),
            'content'   => $request->content,
            'parent_id' => $request->parent_id, // Null = Komentar Utama, Terisi = Balasan
            // 'commentable_type' & 'commentable_id' otomatis terisi oleh Laravel
        ]);

        // 3. Redirect kembali dengan pesan sukses
        return back()->with('success', 'Komentar berhasil dikirim! 💬');
    }

    public function show($slug) // Atau show(Article $article) tergantung route binding Anda
    {
        // 1. Ambil Artikel
        $article = \App\Models\Article::where('slug', $slug)->firstOrFail();

        // 2. AMBIL KOMENTAR (Parent Only)
        // Kita hanya mengambil komentar induk (parent_id = null)
        // Child/Reply akan dipanggil otomatis lewat relasi di Blade nanti
        $comments = $article->comments()
            ->whereNull('parent_id') // Filter hanya komentar utama
            ->with(['user', 'replies.user']) // Eager load biar ringan (N+1 problem solved)
            ->latest()
            ->get();

        // 3. Kirim data ke View (Jangan lupa masukkan 'comments' ke compact)
        return view('pages.user.article.detail-article', compact('article', 'comments'));
    }
}
