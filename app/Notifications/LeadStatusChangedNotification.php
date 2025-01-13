<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeadStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $lead;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $lead)
    {
        $this->user = $user;
        $this->lead = $lead;
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
                    ->subject('Status do lead ' . ' ' . $this->lead->name . ' ' . ' mudou!')
                    ->greeting('Olá ' . $this->user->name . '!')
                    ->line('Estamos informando que o status do seu lead foi alterado para' . ' ' . $this->lead->status)
                    ->line('Acesse mais informações no aplicativo!');
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
