<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Reminder1HourNotification;

use App\Models\Booking;
use Carbon\Carbon;

class Reminder1Hour extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:1hour';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder 1 Hour before call';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date('Y-m-d');
        $time = date('Y-m-d H:i:s');
        $time1hour = Carbon::parse($time)->subtract(58, 'minutes')->format('H:i:s');

        $bookings = Booking::where('is_call', 'pending')
                ->where('is_accepted', '0')
                ->where('is_canceled', '0')
                ->where('booking_date', $date)
                ->where('booking_time', '<=', $time1hour)
                ->get();


        //...
        foreach($bookings as $booking){
            //send reminder email to lawyer

            try{
                
                $lawyer = $booking->lawyer;
                $user = $booking->user;
                $url = route('zoom', $booking->zoom_id);

                Notification::route('mail', $lawyer->email)
                    ->notify(new Reminder1HourNotification($lawyer, $url));

                Notification::route('mail', $user->email)
                    ->notify(new Reminder1HourNotification($user, $url));


            } catch(Exception $e) { }

        }

        return 1;
    }
}
