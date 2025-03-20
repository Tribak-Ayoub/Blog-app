<?php

namespace Modules\PkgBlog\App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgBlog\App\Models\Tag;
use Modules\PkgBlog\App\Services\TagService;

class TagController extends BaseController
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $tags = $this->tagService->paginate($search);

        return response()->json($tags);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $tag = $this->tagService->createTag($data);

        return response()->json($tag);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        $tag = $this->tagService->getTagById($tag->id);

        return response()->json($tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $updateTag = $this->tagService->updateTag($tag, $data);

        return response()->json($updateTag);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = $this->tagService->getTagById($id);

        if (!$tag) {
            return response()->json(['message' => 'Tag not found'], Response::HTTP_NOT_FOUND);
        }

        $this->tagService->deleteTag($tag);

        return response()->json(['message' => 'Tag deleted successfully'], Response::HTTP_OK);
    }
}
