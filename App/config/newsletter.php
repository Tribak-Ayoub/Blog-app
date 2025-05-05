<?php

return [
    'driver' => Spatie\Newsletter\Drivers\MailchimpDriver::class,

    'driver_arguments' => [
        'api_key' => env('MAILCHIMP_APIKEY'),
        'server' => env('MAILCHIMP_SERVER_PREFIX'),
    ],

    'default_list_name' => 'default',

    'lists' => [
        'default' => [
            'id' => env('MAILCHIMP_LIST_ID'),
        ],
    ],
];
