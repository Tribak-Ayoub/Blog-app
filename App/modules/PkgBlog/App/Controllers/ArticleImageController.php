<?php

namespace Modules\PkgBlog\App\Controllers;

use Illuminate\Http\Request;
use Modules\Core\App\Controllers\BaseController;

class ArticleImageController extends BaseController
{
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles/gallery', 'public');
            $url = asset('storage/' . $path);
            return response()->json([
                'url' => $url,
                'path' => $path
            ]);
        }

        return response()->json(['error' => 'No image uploaded'], 400);
    }
}
