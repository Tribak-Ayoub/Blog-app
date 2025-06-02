<?php

namespace Modules\PkgBlog\App\Controllers;

use Modules\Core\App\Controllers\BaseController;
use Modules\PkgBlog\App\Requests\ContactRequest;
use Modules\PkgBlog\App\Services\ContactService;
use Illuminate\Http\JsonResponse;

class ContactController extends BaseController
{
    public function __construct(protected ContactService $service) {}

    public function __invoke(ContactRequest $request): JsonResponse
    {
        try {
            $this->service->send($request->validated());

            return response()->json([
                'message' => 'Message sent successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send message. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
