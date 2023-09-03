<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalRequestedAdmin extends Notification
{
    use Queueable;
    protected Withdrawal $withdrawal;
    protected User $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Withdrawal $withdrawal, User $user)
    {
        $this->withdrawal = $withdrawal;
        $this->user = $user;
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
            ->line('Withdrawal Request From '.$this->user->name)
            ->action('View Requests', url('/admin/withdrawal-requests'))
            ->line('Please review and process the request.')
            ->line('Amount : ' . $this->withdrawal->amount)
            ->line('Contact: ' . $this->withdrawal->contact);
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
