<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('auth-protection', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())->response(function () {
                return redirect()->back()->withInput()->withErrors(['error' => 'too many attempts, try again later.']);
            });
        });

        // Merubah cara pemanggilan model agar lebih simpel karena kita menggunakan konsep polymorphic pada relasi antar table pada database kita
        Relation::enforceMorphMap([
            'article' => \App\Models\Article::class,
            'comment' => \App\Models\Comment::class,
        ]);
    }
}
