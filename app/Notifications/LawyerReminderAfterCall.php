<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Spatie\CalendarLinks\Link;


class LawyerReminderAfterCall extends Notification
{
    use Queueable;
    public $user, $lawyer, $booking;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $lawyer, $booking)
    {
        $this->user = $user;
        $this->lawyer = $lawyer;
        $this->booking = $booking;
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
        //$zoomUrl = route('zoom', $this->booking->zoom_id);
        
        $start_time = date('g:i A', strtotime($this->booking->booking_time));
        $end_time = date('g:i A', strtotime($this->booking->booking_time. ' +30 minutes'));
        
        $time = $start_time.' - '.$end_time;
        
        
        $bdate = $this->booking->booking_date ? date('m-d-Y', strtotime($this->booking->booking_date)) : '';
        
        $message = 'Please confirm if '. $this->user->name .' appeared in the zoom call for booking on '. $bdate .' at '.$time.' ?';
        
        
        $yesAction = route('lawyer.booking.data', [$this->booking->id, '1']);
        $noAction = route('lawyer.booking.data', [$this->booking->id, '2']);
        
        return (new MailMessage)
            ->subject('Prickly Pear client appearance confirmation')
            ->greeting('Hello ' . ucwords(@$this->lawyer->first_name).',')
            ->line($message)
            ->line('
                <a href="'.$yesAction.'" class="button button-primary" target="_blank" rel="noopener" style="margin-right: 20px;">Yes</a>
                <a href="'.$noAction.'" class="button button-primary" target="_blank" rel="noopener" style="margin-right: 20px;">No</a>
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
