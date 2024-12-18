<?php

namespace Code\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Mail\Mailables\Attachment;

class MessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $cuerpo;
    public $attach;

    /**
     * Create a new message instance.
     */
    public function __construct($subject,$cuerpo,$attach)
    {
        $this->subject = $subject;
        $this->cuerpo = $cuerpo;
        $this->attach = $attach;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.mail.template.message',
            with: [
                'subject' => $this->subject,
                'cuerpo' => $this->cuerpo,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachmentss = [];
        set_time_limit(360);
        foreach($this->attach as $attachment){
            if (str_contains($attachment['name'],'mail_files')) {
                $name = explode('/',$attachment['name'])[3];
                $attchm = Attachment::fromStorageDisk('public', $attachment['name'])
                ->as($name)
                ->withMime($attachment['mime']);
            } else {
                $name = explode('/',$attachment['name'])[1];
                $attchm = Attachment::fromStorageDisk('public', '/files'.'/'.$attachment['name'])
                ->as($name)
                ->withMime($attachment['mime']);
            }
            $attachmentss[] = $attchm;
        }
        return $attachmentss;
    }
}
