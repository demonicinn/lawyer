<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Notification;
use App\Notifications\Vendor\Rating6MonthsNotification;

use App\Models\Booking;
use Carbon\Carbon;

class Rating6Months extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rating:6months';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "cases don't have to be completed; it's just a rating question on how the process is going. The email needs to go out 6 months after consultation no matter when the case finishes to rate the lawyer";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date('Y-m-d');
        $date6months = Carbon::parse($date)->subtract(6, 'months')->format('Y-m-d');


        $bookings = Booking::where('is_call', 'completed')
                ->where('is_accepted', '1')
                ->where('booking_date', '<=', $date6months)
                ->get();

        //...
        foreach($bookings as $booking){
            //send rating email link to client
            try{
                
                $user = $booking->user;
                $url = '/'

                Notification::route('mail', $user->email)
                    ->notify(new Rating6MonthsNotification($user, $url));
                    
            } catch(Exception $e) { }
        }

        return 1;
    }
}
