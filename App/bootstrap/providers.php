<?php

return [
    App\Providers\AppServiceProvider::class,
    Modules\Core\App\Providers\CoreServiceProvider::class,
    Modules\PkgBlog\App\Providers\PkgBlogServiceProvider::class,
    App\Providers\MailchimpServiceProvider::class,
];
