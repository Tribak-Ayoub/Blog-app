<?php

namespace Modules\PkgBlog\App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionConfirmation extends Mailable
{
    use SerializesModels;

    public $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('Subscription Confirmation')
            ->view('emails.subscription_confirmation');
    }
}
