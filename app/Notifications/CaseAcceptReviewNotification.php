<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CaseAcceptReviewNotification extends Notification
{
    use Queueable;
    public $bookingInfo, $lawyer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($bookingInfo, $lawyer)
    {
        $this->bookingInfo = $bookingInfo;
        $this->lawyer = $lawyer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('review.lawyer', encrypt($this->bookingInfo->id));
        return (new MailMessage)
                    ->subject('Rate your consultation')
                    ->greeting('Hello ,' . $this->bookingInfo->first_name)
                    ->line('Rate your lawyer')
                    ->action('Review now', $url)
                    ->line('Thank you');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
