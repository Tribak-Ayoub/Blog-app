<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MailchimpMarketing\ApiClient;

class MailchimpServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('mailchimp', function () {
            $client = new ApiClient();
            $client->setConfig([
                'apiKey' => config('newsletter.apiKey'),
                'server' => env('MAILCHIMP_SERVER_PREFIX'),
            ]);

            return $client;
        });
    }
}
