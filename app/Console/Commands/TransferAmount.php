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
    protected $signature = 'transfer:amount';

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
        $bookingsL = Booking::where('is_call','completed')
                    ->where('is_accepted', '1')
                    ->where('is_canceled', '0')
                    //->where('payment_process', '0')
                    ->where('transfer_lawyer', '0')
                    ->get();

        self::transferAmount($bookingsL);




        $bookingsCc = Booking::where('is_call','completed')
                    ->where('is_accepted', '1')
                    ->where('is_canceled', '0')
                    //->where('payment_process', '0')
                    ->where('transfer_client', '0')
                    ->get();

        self::refundAmount($bookingsCc);



        //............
        $bookingsClient = Booking::where('is_call','pending')
                    ->where('is_accepted', '0')
                    ->where('is_canceled', '0')
                    //->where('payment_process', '0')
                    ->where('lawyer_res', '2')
                    ->where('transfer_client', '0')
                    ->get();
    
    
        self::refundAmount($bookingsClient);
            
            
        return 'done';
    }







    private function refundAmount($bookings){
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        foreach($bookings as $booking){
            if(@$booking->payments->transaction_id){
                try {

                    $refund = \Stripe\Refund::create([
                        'charge' => $booking->payments->transaction_id,
                        'amount' => $booking->consultation_fee * 100,
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
        }

        return 'done';
    }


    private function transferAmount($bookings){
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        foreach($bookings as $booking){

            if(@$booking->payments->transaction_id && $booking->lawyer->bankInfo->account_id){
                try {

                    $transfer = \Stripe\Transfer::create([
                        'amount' => $booking->lawyer_amount * 100,
                        'currency' => 'usd',
                        'destination' => $booking->lawyer->bankInfo->account_id,
                    ]);
//dd($transfer);
                    if(@$transfer){
            
                        //...
                        $booking->transfer_lawyer = '1';
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
