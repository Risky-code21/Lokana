<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;

class LandingPageController extends Controller
{


    public function index()
    {
        $articles = Article::query()
            ->where('status', 'publish')
            ->with(['medias', 'author', 'category'])
            ->withCount(['views', 'comments', 'likes'])
            ->inRandomOrder() // Mengacak urutan data
            ->limit(3)        // Batasi maksimal 3 data
            ->get();          // Jangan lupa panggil get() untuk eksekusi query


        return view('pages.landing_page', compact('articles'));
    }
}
