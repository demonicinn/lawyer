<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LawyerSubscription extends Notification
{
    use Queueable;
    public $user, $plan;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $plan)
    {
        $this->user = $user;
        $this->plan = $plan;
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
                    ->subject('Thank you for Purchasing Subscription')
                    ->greeting('Hello ' . $this->user->first_name.',')
                    ->line('You have Purchased the '.$this->plan->subscription->name)
                    ->line('Your Membership Expires on '. date('m-d-Y', strtotime($this->plan->to_date)));
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
