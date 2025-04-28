<?php

namespace Modules\PkgBlog\App\Controllers;

use Illuminate\Http\Request;
use Modules\Core\App\Controllers\BaseController;
use Illuminate\Routing\Controller;
use Spatie\Newsletter\Facades\Newsletter;
use Illuminate\Support\Facades\Log;

class NewsletterController extends BaseController
{
    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        if (!Newsletter::isSubscribed($request->email)) {
            $response = Newsletter::subscribe($request->email);

            // Check if the response is valid
            if ($response) {
                Log::info('Subscription successful', ['email' => $request->email]);
            } else {
                Log::info('Subscription failed', ['email' => $request->email]);
            }

            return response()->json([
                'message' => 'You are now subscribed!',
            ], 200);
        }

        return response()->json([
            'message' => 'You are already subscribed.',
        ], 200);
    }
}
