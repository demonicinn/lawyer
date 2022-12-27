<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LawyerReminderAfterCall;

class LawyerReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lawyer:reviews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lawyer Reviews';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date('Y-m-d H:m:s');
        
        $bookings = Booking::with('user', 'lawyer')
                    ->where('is_call','completed')
                    ->where('lawyer_email', '0')
                    ->where('is_canceled', '0')
                            ->whereRaw("CONCAT(`booking_date`, ' ', `booking_time`) <= ?", [$date])
                    ->get();

        foreach($bookings as $booking){

            $user = $booking->user;
            $lawyer = $booking->lawyer;
            
            Notification::route('mail', $lawyer->email)
                    ->notify(new LawyerReminderAfterCall($user, $lawyer, $booking));
            
            
            //...
            $booking->lawyer_email = '1';
            $booking->save();
            
        }

        return 'done';
    }
}
