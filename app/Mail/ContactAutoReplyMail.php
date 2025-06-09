<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactAutoReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        return $this->subject('Terima kasih atas pesan Anda - ' . config('app.name'))
                    ->view('emails.contact-auto-reply')
                    ->with([
                        'contactName' => $this->contact->name,
                        'contactSubject' => $this->contact->subject,
                        'contactDate' => $this->contact->created_at->format('d M Y H:i'),
                    ]);
    }
}