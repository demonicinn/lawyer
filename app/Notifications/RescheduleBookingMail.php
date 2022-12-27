<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RescheduleBookingMail extends Notification
{
    use Queueable;
    public $bookingInfo, $first_name, $bookingDate, $bookingTime, $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($bookingInfo, $user)
    {
        $this->bookingInfo = $bookingInfo;
        $this->user = $user;
        $this->bookingDate = $this->bookingInfo->booking_date;
        $this->bookingTime = $this->bookingInfo->booking_time;

        if (auth()->user()->role == 'user') {
            if ($this->user == "lawyer") {
                $this->first_name = $this->bookingInfo->lawyer->first_name;
                $this->message1 = 'Booking reschedule by Client.';
            } else {
                $this->first_name = auth()->user()->first_name;
                $this->message1 = 'Booking reschedule successfully.';
            }
        } else {

            if ($this->user == "user") {
                $this->first_name = $this->bookingInfo->user->first_name;
                $this->message1 = 'Please accept my sincere apologies for the inconvenience caused.
                                    Reschedule booking details give below.';
 
            
            } else {
                $this->first_name = auth()->user()->first_name;
                $this->message1 = 'Booking reschedule successfully.';
            }
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
        $zoomUrl = route('zoom', $this->bookingInfo->zoom_id);
        return (new MailMessage)
            ->subject('Booking Reschedule')
            ->greeting('Hello ' . $this->first_name.',')
            ->action('Zoom link', $zoomUrl)
            ->line($this->message1)
            // ->line('Zoom password :' . $this->bookingInfo->zoom_password)
            ->line('Booking date :' . date('d-m-Y', strtotime($this->bookingDate)))
            ->line('Booking time :' . date('g:i A', strtotime($this->bookingTime)));
            
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
