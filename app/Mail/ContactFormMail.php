<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        return $this->subject('Pesan Baru dari Website - ' . $this->contact->subject)
                    ->view('emails.contact-form')
                    ->with([
                        'contactName' => $this->contact->name,
                        'contactEmail' => $this->contact->email,
                        'contactSubject' => $this->contact->subject,
                        'contactMessage' => $this->contact->message,
                        'contactDate' => $this->contact->created_at->format('d M Y H:i'),
                    ]);
    }
}