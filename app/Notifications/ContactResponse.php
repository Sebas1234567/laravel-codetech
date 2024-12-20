<?php

namespace Code\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactResponse extends Notification
{
    use Queueable;
    public $nombre, $email, $asunto, $mensaje;

    /**
     * Create a new notification instance.
     */
    public function __construct($nombre, $email, $asunto, $mensaje)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->asunto = $asunto;
        $this->mensaje = $mensaje;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                ->subject('Contacto:  '.$this->asunto)
                ->line('Estimado CodeTech,')
                ->line('Un nuevo mensaje de contacto ha sido enviado desde la pagina web. Los detalles del mismo son los siguientes: ')
                ->line('Nombre: '.$this->nombre)
                ->line('Email: '.$this->email)
                ->line('Asunto: '.$this->asunto)
                ->line('Mensaje: '.$this->mensaje)
                ->line('No olvide responder a este solicitud para continuar con la conversación.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
