<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SupportNotification extends Notification
{
    use Queueable;

    public $contact;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($contact)
    {
        $this->contact = $contact;
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
            ->subject('Support Notification')
            ->greeting('Hi, Admin')
            ->from($this->contact->email)
            ->line(new HtmlString('<a href="/" style="box-sizing: border-box;font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";position: relative;border-radius: 4px;color: rgba(255, 255, 255, 1);display: inline-block;overflow: hidden;text-decoration: none;background-color: rgba(45, 55, 72, 1);border-bottom: 8px solid rgba(45, 55, 72, 1);border-left: 18px solid rgba(45, 55, 72, 1);border-right: 18px solid rgba(45, 55, 72, 1);border-top: 8px solid rgba(45, 55, 72, 1);">Reschedule Booking</a>'))
            
            ->line('You have new message from : ' . $this->contact->first_name)
            ->line('Reason : ' . $this->contact->reason)
            ->line('Message : ' . $this->contact->message);
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
