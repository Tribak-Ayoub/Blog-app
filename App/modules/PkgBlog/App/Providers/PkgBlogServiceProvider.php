<?php

namespace Modules\PkgBlog\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\PkgBlog\App\Models\Article;
use Modules\PkgBlog\App\Policies\ArticlePolicy;

class PkgBlogServiceProvider extends ServiceProvider
{
    protected $policies = [
        Article::class => ArticlePolicy::class,
    ];
    
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
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/Migrations');

        foreach (glob(__DIR__ . '/../../Routes/*.php') as $routeFile) {
            $this->loadRoutesFrom($routeFile);
        }

        $this->loadViewsFrom(__DIR__ . '/../../Resources/Views', 'pkg-blog');
    }
}
