<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Str;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class MyTestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailInfo;
    public $path;
    public $event;
    /**
     * Create a new message instance.
     */
    public function __construct($mailInfo)
    {
        //
        $this ->mailInfo = $mailInfo;
        //$this->event = $event;
        //$this->path = $path;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            //subject: 'Este es un correo de prueba, no contestar.',
            subject: $this -> mailInfo['subject'],
        );
    }

    /**
     * Get the message content definition. una view de blade, o un texto plano
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.email',
        );
    }

    /**
     * Get the attachments for the message.
     * 
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $pdf_name = 'Evento-' . Str::uuid() . '.pdf';
        return [
            Attachment::fromData(fn () => $this->mailInfo['pdf']->output(), $pdf_name)
                ->withMime('application/pdf'),
        ];
    }
}
