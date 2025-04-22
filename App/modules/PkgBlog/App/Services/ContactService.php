<?php

namespace Modules\PkgBlog\App\Services;

use Illuminate\Support\Facades\Mail;
use Modules\PkgBlog\App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Log;

class ContactService
{
    public function send(array $data): bool
    {
        try {
            $recipient = config('mail.contact.email', config('mail.from.address'));

            if (empty($recipient)) {
                throw new \Exception('No recipient email configured');
            }

            Mail::to($recipient)
                ->send(new ContactFormMail($data));

            Log::info('Contact form submitted successfully', [
                'email' => $data['email'],
                'subject' => $data['subject']
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Contact form failed to send', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            return false;
        }
    }
}
