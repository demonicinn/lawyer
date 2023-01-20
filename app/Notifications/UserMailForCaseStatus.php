<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserMailForCaseStatus extends Notification
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
            $this->message = 'Congratulations, your case has been accepted. We will be in touch shortly with further details.';
        } else {
            $this->message = 'We regret to inform you that your case has been declined. Thank you for contacting Prickly Pear.';
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
        if ( $this->status == 'accepted'){
            $subject = "Your case has been accepted";
        } elseif ( $this->status == 'declined' ) {
            $subject = "Your case was declined";
        } else {
            $subject = "Your case $this->status";
        }
        
        return (new MailMessage)
            ->subject($subject)
            ->greeting('Hello ' . ucwords($this->bookingInfo->first_name).',')
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
