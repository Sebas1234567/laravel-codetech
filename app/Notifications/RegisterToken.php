<?php

namespace Code\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterToken extends Notification
{
    use Queueable;
    public $codigo;

    /**
     * Create a new notification instance.
     */
    public function __construct($codigo)
    {
        $this->codigo = $codigo;
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
                ->subject('Estás a punto de abrir tu cuenta y empezar a aprender más de la programación')
                ->line('Estás muy cerca de empezar una aventura programando con CodeTech.')
                ->line('Usa el siguiente código de confirmación para completar el registro.')
                ->vericode($this->codigo)
                ->line('Recuerda que el código solo se puede usar una vez y tiene un tiempo de expiración de 30 minutos.')
                ->line('Has recibido este correo electrónico porque te has registrado CodeTech. Puedes ignorar este mensaje si no lo has realizado.');
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
