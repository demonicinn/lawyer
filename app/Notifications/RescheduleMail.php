<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RescheduleMail extends Notification
{
    use Queueable;
    public $booking, $info, $message1, $message2;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($booking, $info)
    {
        $this->booking = $booking;
        $this->info = $info;

        if (auth()->user()->role =="lawyer") {
            $this->message1 = 'Please accept my sincere apologies for the inconvenience caused.';
            $this->message2 = 'I was looking forward to attending the meeting and discussing the opportunity in detail with you. I request you to kindly reschedule my booking to next week as per your preferred date and timings.';
        } else {
            $this->message1 = 'Please accept my sincere apologies for the inconvenience caused.';
            $this->message2 = 'Booking canceled by user';
        }
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
            ->greeting('Hello ,' . $this->info->first_name)
            ->line('Booking date :' . $this->booking->booking_date)
            ->line('Booking time :' . $this->booking->booking_time)
            ->line($this->message1)
            ->line($this->message2);
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