<?php

namespace Modules\PkgBlog\App\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\PkgBlog\App\Models\Article;
use Modules\PkgBlog\App\Models\Category;
use Modules\PkgBlog\App\Models\Tag;
use Modules\PkgBlog\App\Services\ArticleService;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index(Request $request)
    {
        $filters = [
            'category' => $request->category,
            'tag' => $request->tag,
            'search' => $request->search,
        ];

        $articles = $this->articleService->paginate($filters);
        $categories = Category::all();
        $tags = Tag::all();

        return response()->json([
            'articles' => $articles,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function show(string $id)
    {
        $article = $this->articleService->getArticleById($id);
        $commentableId = $article->id;
        $commentableType = Article::class;

        return response()->json([
            'article' => $article
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $allTags = Tag::all();

        return response()->json([
            'categories' => $categories,
            'tags' => $allTags
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array|exists:tags,id'
        ]);

        $article = $this->articleService->createArticle($validated);

        return response()->json([
            'message' => "The article has been created",
            'article' => $article
        ], Response::HTTP_CREATED);
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        $allTags = Tag::all();
        $selectedTags = $article->tags->pluck('id')->toArray();

        return response()->json([
            'article' => $article,
            'categories' => $categories,
            'tags' => $allTags,
            'selectedTags' => $selectedTags
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array|exists:tags,id'
        ]);

        $article = Article::findOrFail($id);
        $this->articleService->updateArticle($article, $validated);

        return response()->json([
            'message' => "The article has been updated",
            'article' => $article
        ]);
    }

    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $this->articleService->deleteArticle($article);

        return response()->json([
            'message' => "The article has been deleted"
        ], Response::HTTP_NO_CONTENT);
    }
}
