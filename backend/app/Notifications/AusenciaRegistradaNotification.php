<?php

namespace App\Notifications;

use App\Models\Ausencia;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AusenciaRegistradaNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Ausencia $ausencia
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $profesor = $this->ausencia->user;
        return (new MailMessage)
            ->subject('Nueva ausencia registrada - ' . $profesor->nombre)
            ->line('Se ha registrado una nueva ausencia.')
            ->line('Profesor: ' . $profesor->nombre)
            ->line('Fecha inicio: ' . $this->ausencia->fecha_inicio)
            ->line('Fecha fin: ' . $this->ausencia->fecha_fin)
            ->line('Motivo: ' . $this->ausencia->motivo)
            ->salutation('Sistema de Gestión de Horarios');
    }
}
