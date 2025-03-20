<?php

namespace Modules\PkgBlog\App\Services;

use Illuminate\Support\Facades\Auth;
use Modules\PkgBlog\App\Models\Category;

class CategoryService
{
    public function paginate($perPage = 10)
    {
        return Category::latest()->paginate($perPage);
    }

    public function getCategoryById($id)
    {
        return Category::findOrFail($id);
    }

    public function createCategory(array $data)
    {
        return Category::create([
            'name' => $data['name'],
        ]);
    }

    public function updateCategory(Category $category, array $data)
    {
        $category->update([
            'name' => $data['name'],
        ]);

        return $category;
    }

    public function deleteCategory(Category $category)
    {
        return $category->delete();
    }

    public function getCategories()
    {
        return Category::all();
    }
}
