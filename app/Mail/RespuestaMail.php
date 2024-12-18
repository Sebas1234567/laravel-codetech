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
use Webklex\IMAP\Facades\Client;


class RespuestaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $cuerpo;
    public $uid;
    public $meId;
    public $folder;
    public $attach;

    /**
     * Create a new message instance.
     */
    public function __construct($uid,$subject,$cuerpo,$folder,$attach)
    {
        $this->folder = $folder;
        $this->uid = $uid;
        $this->subject = $subject;
        $client = Client::account('default');
        $client->connect();
        if ($this->folder == 'INBOX') {
            $folder = $client->getFolderByPath($this->folder);
        } else {
            $folder = $client->getFolderByPath('[Gmail]/'.$this->folder);
        }
        $query = $folder->query();
        $message = $query->getMessageByUid($this->uid);
        $this->cuerpo = $cuerpo;
        $this->meId = $message->message_id->toString();
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
     * Get the message headers.
     *
     * @return \Illuminate\Mail\Mailables\Headers
     */
    public function headers()
    {
        return new Headers(
            messageId: $this->meId,
            references: [$this->meId],
            text: [
                'In-Reply-To' => $this->meId,
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.mail.template.reply',
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
            $name = explode('/',$attachment['name'])[1];
            $attchm = Attachment::fromStorageDisk('public', '/files'.'/'.$attachment['name'])
            ->as($name)
            ->withMime($attachment['mime']);
            $attachmentss[] = $attchm;
        }
        return $attachmentss;
    }
}
