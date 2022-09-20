<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Notification;
use App\Notifications\Vendor\Case3DaysCancelNotification;

use App\Models\Booking;
use Carbon\Carbon;

class Case3DaysCancel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'case:3days';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "The lawyer will receive an email reminder to accept or deny the case 24 hours before the deadline. If they don't not accept within 72 hours then the case is denied";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date('Y-m-d');
        $date3Days = Carbon::parse($date)->subtract(3, 'days')->format('Y-m-d');


        $bookings = Booking::where('is_call', 'completed')
                ->where('is_accepted', '0')
                ->where('booking_date', '<=', $date3Days)
                ->get();

        //...
        foreach($bookings as $booking){
            $booking->is_accepted = '2';
            $booking->save();

            //send cancelation email to client and lawyer
            try{
                
                $user = $booking->user;
                $lawyer = $booking->lawyer;

                $messageClient = 'Lawyer '. $lawyer->name .' has not accepted offer, so its auto decliend.';

                $messageLawyer = 'You has not accepted offer, so its auto decliend.';

                //client email
                Notification::route('mail', $user->email)
                    ->notify(new Case3DaysCancelNotification($user, $messageClient));

                //lawyer email
                Notification::route('mail', $lawyer->email)
                    ->notify(new Case3DaysCancelNotification($lawyer, $messageLawyer));


            } catch(Exception $e) { }

        }

        return 1;
    }
}
