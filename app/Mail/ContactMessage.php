<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// Website contact form enquiry, sent to the team inbox (services.contact.to)
class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data, public string $topic)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [new Address($this->data['email'], $this->data['name'])],
            subject: "Website enquiry: {$this->topic} from {$this->data['name']}",
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.contact');
    }
}
