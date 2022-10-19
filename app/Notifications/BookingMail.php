<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class BookingMail extends Notification
{
    use Queueable;
    public $booking, $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($booking, $user)
    {
        $this->booking = $booking;
        $this->user = $user;
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
        $zoomUrl = route('zoom', $this->booking->zoom_id);
        $reschedule = route('reschedule.booking', $this->booking->id);
        

        

        return (new MailMessage)
            ->subject('Prickly Pear Consultation Confirmed')
            ->greeting('Hi,' . @$this->user->name)
            ->action('Meeting link', $zoomUrl)
            ->line(new HtmlString('<a href="'.$reschedule.'" style="box-sizing: border-box;font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";position: relative;border-radius: 4px;color: rgba(255, 255, 255, 1);display: inline-block;overflow: hidden;text-decoration: none;background-color: rgba(45, 55, 72, 1);border-bottom: 8px solid rgba(45, 55, 72, 1);border-left: 18px solid rgba(45, 55, 72, 1);border-right: 18px solid rgba(45, 55, 72, 1);border-top: 8px solid rgba(45, 55, 72, 1);">Reschedule Booking</a>'))
            
            //->action('Reschedule Booking', $reschedule)
            // ->line('Zoom password :' .$this->booking->zoom_password)

            ->line('Booking date :' .date('d-m-Y', strtotime($this->booking->booking_date)))
            ->line('Booking time :' .date('g:i A', strtotime($this->booking->booking_time)))
            ->line('Your booking done successfully.');
            
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
