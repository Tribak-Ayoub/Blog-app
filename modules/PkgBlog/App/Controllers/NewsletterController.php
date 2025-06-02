<?php

namespace Modules\PkgBlog\App\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Core\App\Controllers\BaseController;
use Spatie\Newsletter\Facades\Newsletter;
use Illuminate\Support\Facades\Mail;
use Modules\PkgBlog\App\Mail\SubscriptionConfirmation;

class NewsletterController extends BaseController
{

    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        if (!Newsletter::isSubscribed($request->email)) {
            try {
                $response = Newsletter::subscribe(
                    $request->email,
                    [],
                    'default',
                    ['status' => 'subscribed']
                );

                // Send the confirmation email
                Mail::to($request->email)->send(new SubscriptionConfirmation($request->email));

                return response()->json([
                    'message' => 'You are now subscribed!',
                    'response' => $response
                ], 200);
            } catch (Exception $e) {

                return response()->json([
                    'message' => 'Subscription failed.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

        return response()->json([
            'message' => 'You are already subscribed.',
        ], 200);
    }
}
