<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Spatie\CalendarLinks\Link;


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

        $bookingDateTime = $this->booking->booking_date." ".$this->booking->booking_time;
        $fromDateTime = Carbon::createFromFormat("Y-m-d H:i:s", $bookingDateTime );
        $toDateTime = Carbon::createFromFormat("Y-m-d H:i:s", $bookingDateTime )->addMinutes(30);
        $link       = Link::create('Appoitment at Prickly Pear', $fromDateTime, $toDateTime );
        
        return (new MailMessage)
            ->subject('Prickly Pear Consultation Confirmed')
            ->greeting('Hello ' . @$this->user->first_name.',')
            ->line('Your booking has been confirmed. Please view your consultation schedule below.')
            //->line('Please see below your consultation schedule.')
            ->line('Booking time :'. date('l, F d Y', strtotime($this->booking->booking_date)) .' | '. date('h:i a', strtotime($this->booking->booking_time)))
            ->line('
                <a href="'.$zoomUrl.'" class="button button-primary" target="_blank" rel="noopener" style="margin-right: 20px;">Meeting link</a>
                <a href="'.$reschedule.'" class="button button-primary" target="_blank" rel="noopener" style="margin-right: 20px;">Reschedule Booking</a>
                <a href="'.$upcoming.'" class="button button-primary" target="_blank" rel="noopener" style="margin-right: 20px;">Cancel Booking</a>
                <a href="'.$link->google().'" class="button button-primary" target="_blank" rel="noopener" style="margin-right: 20px;">Add to Google Calendar</a>
                <a href="'.$link->webOutlook().'" class="button button-primary" target="_blank" rel="noopener" style="margin-right: 20px;">Add to Outlook Calendar</a>
                <a href="'.$link->ics().'" class="button button-primary" target="_blank" rel="noopener" style="margin-right: 20px;">Add to Apple Calendar</a>
            ');
            
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
