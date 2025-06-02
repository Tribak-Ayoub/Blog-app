<?php

namespace Modules\PkgBlog\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Form Submission: ' . $this->data['subject'],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact',
            with: [
                'data' => $this->data,
                'receivedAt' => now()->format('F j, Y, g:i a')
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
