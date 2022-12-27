<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OfferNotification extends Notification
{
    use Queueable;
    public $user;
    public $subscription;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $subscription)
    {
        $this->user = $user;
        $this->subscription = $subscription;
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
        $message = '';
        
        if($this->user->payment_plan=='monthly'){
            $message = 'Your monthly subscription prices is modified from $'.$this->subscription->price.' to $'.$this->user->offer_price;
        }
        if($this->user->payment_plan=='yearly'){
            $message = 'Your yearly subscription prices is modified from $'.$this->subscription->price.' to $'.$this->user->offer_price_yearly;
        }
        
        return (new MailMessage)
            ->subject('Prickly Pear Subscription Offer')
            ->greeting('Hello ' . @$this->user->first_name.',')
            ->line($message);
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
