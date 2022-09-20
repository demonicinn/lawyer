<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RescheduleBookingMail extends Notification
{
    use Queueable;
    public $bookingInfo, $first_name, $bookingDate, $bookingTime,$user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($bookingInfo,$user)
    {
        $this->bookingInfo = $bookingInfo;
        $this->user=$user;
        $this->bookingDate = $this->bookingInfo->booking_date;
        $this->bookingTime = $this->bookingInfo->booking_time;

        if ($this->user== "lawyer") {
            $this->first_name = auth()->user()->first_name;
            $this->message1 = 'Booking reschedule successfully.';
         
        } else {
            $this->first_name = $this->bookingInfo->lawyer->first_name;
            $this->message1 = 'Booking reschedule by Client';
     
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
            ->subject('Booking Reschedule')
            ->greeting('Hello ,' . $this->first_name)
            ->line('Booking date :' . $this->bookingDate)
            ->line('Booking time :' . $this->bookingTime)
            ->line($this->message1);
  
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
