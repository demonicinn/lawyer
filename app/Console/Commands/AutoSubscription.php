<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LawyerSubscription;
use App\Models\Subscription;
use App\Models\Payment;
use Carbon\Carbon;
use Stripe\Stripe;


class AutoSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto subscription renewal';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date('Y-m-d');
        //$date6months = Carbon::parse($date)->subtract(6, 'months')->format('Y-m-d');

        $lawyers = LawyerSubscription::whereHas('user', function($query){
                            $query->where('auto_renew', '1');
                            $query->where('payment_plan', '!=', null);
                        })
                        ->where('to_date', '<=', $date)
                        ->orderBy('id', 'desc')
                        ->get();

        //...
        Stripe::setApiKey(config('services.stripe.secret'));

        foreach($lawyers as $lawyer){
            $user = $lawyer->user;

            $card = $user->userCards()->where('is_primary', '1')->first();

            $subscription = Subscription::where('type', $user->payment_plan)->first();


            if(@$card){
                $fee = $subscription->price;

                $charge = \Stripe\Charge::create([
                    'currency' => 'USD',
                    'customer' => $card->customer_id,
                    'amount' =>  $fee * 100,
                ]);



                $payment = new Payment;
                $payment->users_id = $user->id;
                $payment->transaction_id = $charge->id;
                $payment->balance_transaction = $charge->balance_transaction;
                $payment->customer = $charge->customer;
                $payment->currency = $charge->currency;
                $payment->amount = $fee;
                $payment->payment_status = $charge->status;
                $payment->payment_type = 'subscription';
                $payment->save();


                //...
                $plan = new LawyerSubscription;
                $plan->users_id = $user->id;
                $plan->subscriptions_id = $subscription->id;
                $plan->payments_id = @$payment->id;
                $plan->from_date = $from_date;
                $plan->to_date = $to_date;
                $plan->save();
            }

        }
        

        return 1;
    }
}
