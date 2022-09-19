<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LawyerMailForCaseStatus extends Notification
{
    use Queueable;
    public $bookingInfo, $status, $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($bookingInfo, $status)
    {
        $this->bookingInfo = $bookingInfo;
        $this->status = $status;

        if ($this->status == 'accepted') {
            $this->message = 'Case accepted successfully.';
        } else {
            $this->message = 'Case declined successfully.';
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
            ->subject('Case ' . $this->status . ' by You')
            ->greeting('Hi ,' . auth()->user()->first_name)
            ->line($this->message);
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
