<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RescheduleMailTOUser extends Notification
{
    use Queueable;
    public $booking, $userInfo;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($booking, $userInfo)
    {
        $this->booking = $booking;
        $this->userInfo = $userInfo;
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
        return (new MailMessage)
            ->subject('Reschedule Mail')
            ->greeting('Hello ,' . $this->userInfo->first_name)
            ->line('Booking date :' . $this->booking->booking_date)
            ->line('Booking time :' . $this->booking->booking_time)
            ->line('Please accept my sincere apologies for the inconvenience caused.')
            ->line('I was looking forward to attending the meeting and discussing the opportunity in detail with you. I request you to kindly reschedule my booking to next week as per your preferred date and timings.');
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
