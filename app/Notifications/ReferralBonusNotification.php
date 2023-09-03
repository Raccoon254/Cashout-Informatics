<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class ReferralBonusNotification extends Notification
{
    use Queueable;
    protected User $referrer;
    protected User $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($referrer, $user)
    {
        $this->referrer = $referrer;
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
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('You Earned a Referral Bonus')
            ->line('Congratulations, you have earned a referral bonus!')
            ->line('Referrer: ' . $this->referrer->name)
            ->line('Referred User: ' . $this->user->name)
            ->line('Amount: ' . $this->referrer->referral_bonus)
            ->line('Date: ' . Carbon::now()->format('Y-m-d H:i:s'));
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
