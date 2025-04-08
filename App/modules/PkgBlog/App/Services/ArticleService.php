<?php

namespace Modules\PkgBlog\App\Services;

use Illuminate\Support\Facades\Auth;
use Modules\PkgBlog\App\Models\Article;
use Modules\PkgBlog\App\Models\ArticleImage;

class ArticleService
{
    public function paginate($filters = [], $perPage = 10)
    {
        $query = Article::latest();

        // Apply category filter
        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        // Apply tag filter
        if (!empty($filters['tag'])) {
            $query->whereHas('tags', function ($query) use ($filters) {
                $query->where('tags.id', $filters['tag']);
            });
        }

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function ($query) use ($filters) {
                $query->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('content', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->paginate($perPage);
    }

    public function getArticleById($id)
    {
        $article = Article::with(['user', 'images', 'category', 'tags', 'comments'])->findOrFail($id);

        if ($article) {
            $article->user->profile_image = $article->user->profile_image;
        }

        $article->increment('view_count');

        return $article;
    }

    public function createArticle(array $data, $images = [])
    {
        $article = Article::create([
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'content' => $data['content'],
            'user_id' => Auth::id(),
        ]);

        foreach ($images as $image) {
            $path = $image->store('articles', 'public');
            ArticleImage::create(['article_id' => $article->id, 'image_path' => $path]);
        }

        if (!empty($data['tags'])) {
            $article->tags()->attach($data['tags']);
        }

        return $article;
    }

    public function updateArticle(Article $article, array $data)
    {

        $article->update([
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'content' => $data['content'],
        ]);

        if (isset($data['tags'])) {
            $article->tags()->sync($data['tags']);
        }

        return $article;
    }

    public function deleteArticle(Article $article)
    {
        $article->delete();
        return true;
    }

    public function getRelatedArticles(Article $article, int $limit = 3)
    {
        return Article::with('images')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest()
            ->take($limit)
            ->get();
    }
}
