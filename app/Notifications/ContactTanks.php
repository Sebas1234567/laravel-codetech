<?php

namespace Code\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactTanks extends Notification
{
    use Queueable;

    public $nombre;

    /**
     * Create a new notification instance.
     */
    public function __construct($nombre)
    {
        $this->nombre = $nombre;
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
                ->subject('Agradecimiento por tu contacto')
                ->line('Estimado/a '.$this->nombre.',')
                ->line('Gracias por ponerte en contacto con nosotros. Apreciamos sinceramente tu interés y confianza en nuestros servicios/productos.')
                ->line('Queremos que sepas que tu mensaje ha sido recibido con éxito y que estamos trabajando diligentemente para proporcionarte una respuesta completa y detallada lo antes posible.')
                ->line('Nos comprometemos a atender tu consulta con la máxima atención y eficiencia. Nuestro equipo se encuentra revisando tu mensaje y pronto recibirás una respuesta personalizada que aborde tus inquietudes de manera adecuada.')
                ->line('Si tienes alguna pregunta adicional o necesitas información adicional en el ínterin, no dudes en ponerte en contacto con nosotros nuevamente.')
                ->line('Gracias una vez más por elegirnos y por darnos la oportunidad de servirte.');
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
