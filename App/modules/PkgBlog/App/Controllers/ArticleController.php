<?php

namespace Modules\PkgBlog\App\Controllers;

use Illuminate\Http\Request;
use Modules\Core\App\Controllers\BaseController;

class ArticleController extends BaseController
{
    public function index()
    {
        return view('PkgBlog::index');
    }

    public function show($id)
    {
        return view('PkgBlog::show', compact('id'));
    }

    public function create()
    {
        return view('PkgBlog::create');
    }

    public function store(Request $request)
    {
        return redirect()->route('articles.index');
    }

    public function edit($id)
    {
        return view('PkgBlog::edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('articles.index');
    }

    public function destroy($id)
    {
        return redirect()->route('articles.index');
    }
}
