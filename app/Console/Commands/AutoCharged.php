<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\PaymentStatus;
use Carbon\Carbon;

class AutoCharged extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:charge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Charged';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date('Y-m-d H:m:s');
        $date1Days = Carbon::parse($date)->add(1, 'days')->format('Y-m-d H:m:s');
        //dd($date, $date1Days);
        
        $bookings = Booking::with('payments')
                    ->where('is_call','pending')
                    ->where('is_accepted', '0')
                    ->where('is_canceled', '0')
                    ->whereHas('payments', function($query){
                        $query->where('payment_status', 'pending');
                    })
                            ->whereRaw("CONCAT(`booking_date`, ' ', `booking_time`) <= ?", [$date1Days])
                    //->where('booking_date', '<=', $date1Days)
                    ->get();

        //dd($bookings);
        
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        foreach($bookings as $booking){

                try {

                    
                    
                    $charge = \Stripe\Charge::create([
                        'currency' => 'USD',
                        'customer' => $booking->payments->customer,
                        'amount' =>  $booking->total_amount * 100,
                    ]);

                    if(@$charge){

                        //...
                        $payments = $booking->payments;
                        $payments->transaction_id = $charge->id;;
                        $payments->balance_transaction = $charge->balance_transaction;
                        $payments->payment_status = $charge->status;
                        $payments->save();

                    }

                } catch (\Stripe\Exception\CardException $e) {
                    $error = $e->getMessage();
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }


        }

        return 'done';
    }
}
