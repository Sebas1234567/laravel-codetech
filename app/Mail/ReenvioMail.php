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
use Webklex\IMAP\Facades\Client;
use Illuminate\Mail\Mailables\Attachment;

class ReenvioMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $fromt;
    public $date;
    public $tot;
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
        //Remitente
        $this->fromt = $message->from->toString();
        $this->tot = $message->to->toString();
        //Cuerpo
        $this->cuerpo = $cuerpo;
        //Fecha
        $date = $message->date[0];
        $date->timezone = 'America/Lima';
        $this->date = $date->formatLocalized('%a, %e %b %Y a las %H:%M');
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
            view: 'admin.mail.template.fordward',
            with: [
                'subject' => $this->subject,
                'from' => $this->fromt,
                'date' => $this->date,
                'to' => $this->tot,
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
        $client = Client::account('default');
        $client->connect();
        if ($this->folder == 'INBOX') {
            $folder = $client->getFolderByPath($this->folder);
        } else {
            $folder = $client->getFolderByPath('[Gmail]/'.$this->folder);
        }
        $query = $folder->query();
        $message = $query->getMessageByUid($this->uid);
        $attachmentss = [];
        if ($message->hasAttachments()) {
            foreach($message->getAttachments() as $attachment){
                $attch = Attachment::fromStorageDisk('public', '/mail_files'.'/'.$attachment->getExtension().'/'.$attachment->getName())
                ->as($attachment->getName())
                ->withMime($attachment->getMimeType());
                $attachmentss[] = $attch;
            }
        }
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
