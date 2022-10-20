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
        $upcoming = route('consultations.upcoming');
        

        return (new MailMessage)
            ->subject('Prickly Pear Consultation Confirmed')
            ->greeting('Hi,' . @$this->user->name)
            //->action('Meeting link', $zoomUrl)

            ->line(new HtmlString('
                <a href="'.$zoomUrl.'" class="button button-primary" target="_blank" rel="noopener" style="margin-right: 20px;">Meeting link</a>
                <a href="'.$reschedule.'" class="button button-primary" target="_blank" rel="noopener" style="margin-right: 20px;">Reschedule Booking</a>
                <a href="'.$upcoming.'" class="button button-primary" target="_blank" rel="noopener" style="margin-right: 20px;">Cancel Booking</a>
            '))
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
