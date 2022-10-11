<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\PaymentStatus;

class TransferAmount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer.amount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer Amount';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bookings = Booking::where('is_call','completed')
                    ->where('is_accepted', '1')
                    ->where('payment_process', '0')
                    ->get();


        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        foreach($bookings as $booking){

            if(@$booking->lawyer->bankInfo->account_id){


                try {

                    $transfer = \Stripe\Transfer::create([
                        'amount' => $booking->lawyer_amount * 100,
                        'currency' => 'usd',
                        'destination' => $booking->lawyer->bankInfo->account_id,
                    ]);

                    if(@$transfer){

                        //...
                        $booking->payment_process = '1';
                        $booking->save();

                        $store = new PaymentStatus;
                        $store->bookings_id = $booking->id;
                        $store->transaction_id = @$transfer['id'];
                        $store->status = 'succeeded';
                        $store->amount = $booking->lawyer_amount;
                        $store->save();

                    }

                } catch (\Stripe\Exception\CardException $e) {
                    $error = $e->getMessage();
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }


            }


        }

        return 'done';
    }
}
