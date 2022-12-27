<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\PaymentStatus;

class RefundAmount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refund:amount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refund Amount';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //refund when lawyer declined the request
        $bookings = Booking::with('payments')
            ->where('is_call','completed')
                    ->where('is_accepted', '2')
                    ->where('payment_process', '0')
                    ->where('is_canceled', '0')
                    ->whereHas('payments', function($query){
                        $query->whereNotNull('transaction_id');
                    })
                    ->get();

        self::refundAmount($bookings);

        //refund when user cancled the booking
        /*$bookings1 = Booking::with('payments')
            ->where('is_call','pending')
                    ->where('is_accepted', '0')
                    ->where('payment_process', '0')
                    ->where('is_canceled', '1')
                    ->whereHas('payments', function($query){
                        $query->whereNotNull('transaction_id');
                    })
                    ->get();

        self::refundAmount($bookings1);*/
        

        return 'done';
    }


    private function refundAmount($bookings){
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        foreach($bookings as $booking){

            try {
                $refund = $stripe->refunds->create([
                    'charge' => $booking->payments->transaction_id,
                ]);

                if(@$refund){

                    //...
                    $booking->payment_process = '1';
                    $booking->transfer_client = '1';
                    $booking->save();

                    $store = new PaymentStatus;
                    $store->bookings_id = $booking->id;
                    $store->transaction_id = @$refund['id'];
                    $store->status = 'succeeded';
                    $store->amount = $booking->total_amount;
                    $store->save();

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
