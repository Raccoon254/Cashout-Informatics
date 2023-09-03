<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalUpdatedForAdmin extends Notification
{
    use Queueable;
    protected Withdrawal $withdrawal;

    /**
     * Create a new notification instance.
     */
    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
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
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Withdrawal Request for ' . $this->withdrawal->user->name . ' Updated')
            ->line('A withdrawal request has been updated.')
            ->action('View Withdrawal Request', route('withdrawals.show', $this->withdrawal->id))
            ->line('Withdrawal details:')
            ->line('Amount: KSH' . $this->withdrawal->amount)
            ->line('Status: ' . $this->withdrawal->status)
            ->line('Contact: ' . $this->withdrawal->contact)
            ->line('Thank you for managing withdrawals!');
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
