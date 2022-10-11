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
    protected $signature = 'refund.amount';

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
        $bookings = Booking::where('is_call','completed')
                    ->where('is_accepted', '2')
                    ->where('payment_process', '0')
                    ->whereHas('payments')
                    ->get();

        foreach($bookings as $booking){

            try {
                // $stripe = new \Stripe\Stripe::StripeClient(config('services.stripe.secret'));

                $refund = $stripe->refunds->create([
                    'charge' => $booking->payments->transaction_id,
                ]);

                if(@$refund){

                    //...
                    $booking->payment_process = '1';
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
