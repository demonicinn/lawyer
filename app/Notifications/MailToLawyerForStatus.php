<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailToLawyerForStatus extends Notification
{
    use Queueable;
    public $lawyer;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $action)
    {
        $this->lawyer = $data;
        $this->action = $action;
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
        if($this->action == 'accept'){
            $act = 'accepted';
        }
        else {
            $act = 'rejected';
        }

        return (new MailMessage)
            ->subject('Your request has been ' . $act)
            ->greeting('Hello '.ucwords($this->lawyer->first_name).',')
            ->line('Your request has been ' . $act . ' by the admin.');
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
