<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Notification;
use App\Notifications\Vendor\Reminder1DayNotification;

use App\Models\Booking;
use Carbon\Carbon;

class Reminder1Day extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:1day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The lawyer will receive an email reminder to accept or deny the case within 24 hours ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date('Y-m-d');
        $date1Days = Carbon::parse($date)->subtract(1, 'days')->format('Y-m-d');


        $bookings = Booking::where('is_call', 'completed')
                ->where('is_accepted', '0')
                ->where('booking_date', '<=', $date1Days)
                ->get();

        //...
        foreach($bookings as $booking){
            //send reminder email to lawyer

            try{
                
                $lawyer = $booking->lawyer;
                $url = '/'

                Notification::route('mail', $lawyer->email)
                    ->notify(new Reminder1DayNotification($lawyer, $url));
            } catch(Exception $e) { }

        }

        return 1;
    }
}
