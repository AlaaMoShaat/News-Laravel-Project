<?php

namespace App\Providers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('posts')) {
            if (!Cache::has('read_more_posts')) {
                $read_more_posts = Post::select('id', 'slug', 'title')->latest()->limit(10)->get();
                Cache::remember('read_more_posts', 3600, function () use ($read_more_posts) {
                    return $read_more_posts;
                });
            }


            if (!Cache::has('latest_posts')) {
                $latest_posts = Post::active()->select('id', 'title', 'slug')->latest()->limit(5)->get();
                Cache::remember('latest_posts', 3600, function () use ($latest_posts) {
                    return $latest_posts;
                });
            }
            if (!Cache::has('popular_posts')) {
                $popular_posts = Post::active()->withCount('comments')->orderBy('comments_count', 'desc')->take(5)->get();
                Cache::remember('popular_posts', 3600, function () use ($popular_posts) {
                    return $popular_posts;
                });
            }



            $read_more_posts = Cache::get('read_more_posts');
            $latest_posts = Cache::get('latest_posts');
            $popular_posts = Cache::get('popular_posts');
            view()->share([
                'read_more_posts' => $read_more_posts,
                'latest_posts' => $latest_posts,
                'popular_posts' => $popular_posts
            ]);
        }
    }
}