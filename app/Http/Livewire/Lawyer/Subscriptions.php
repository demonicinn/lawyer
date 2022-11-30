<?php

namespace App\Http\Livewire\Lawyer;

use App\Models\AdminSetting;
use Livewire\Component;
use Stripe\Stripe;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use Illuminate\Support\Facades\Notification;
use App\Notifications\LawyerSubscription as LawyerSubscriptionNotification;

use App\Models\Subscription;
use App\Models\Payment;
use App\Models\LawyerSubscription;
use App\Models\User;
use App\Models\UserCard;

class Subscriptions extends Component
{
    use LivewireAlert;
    public $subscriptions, $user;

    public $subscription = '';
    public $type = 'monthly';

    public $card_name, $card_number, $expire_month, $expire_year, $cvv;

    public $subscriptionMonthly = 0;

    public $currentPlan;
    protected $listeners = ['confirmedSubscriptionAction', 'confirmedRenewSubscriptionAction'];

    public $trial_days = 0;

    /*public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }*/

    public function mount()
    {
        

        $this->user = auth()->user();

        $subscriptionMonthly = Subscription::where('type', 'monthly')->pluck('price')->first();

        $this->subscriptionMonthly = $subscriptionMonthly * 12;


        $subscriptionCount = $this->user->lawyerSubscription->count();
        $lawyerSubscription = $this->user->lawyerSubscriptionLast;

        $this->subscriptions = Subscription::whereStatus('1')
            ->where(function ($query) use ($subscriptionCount, $lawyerSubscription) {
                if ($subscriptionCount > 0) {
                    $query->where('type', '!=', 'free');
                }
                if (@$lawyerSubscription->subscription->type == 'monthly' || @$lawyerSubscription->subscription->type == 'yearly') {
                    $query->where('type', '!=', 'monthly');
                }
            })
            ->get();

        $this->currentPlan = $this->user->lawyerSubscription()->orderBy('id', 'desc')->first();

        $trial_days_setting = AdminSetting::where('type', 'trial_days')->first();
        if ( ! is_null( $trial_days_setting ) ){
            $this->trial_days = $trial_days_setting->value;
        }
    }

    public function setSubscription($id, $type)
    {
        $this->subscription = $id;
        $this->type = $type;
    }


    public function store()
    {
        if ($this->type == 'free') {
            $this->validate([
                'subscription' => 'required'
            ]);
        } else {
            $this->validate([
                'subscription' => 'required',
                'card_name' => 'required|max:50',
                'card_number' => 'required|numeric|digits_between:12,16',
                'expire_month' => 'required',
                'expire_year' => 'required',
                'cvv' => 'required|numeric|digits_between:3,4'
            ]);
        }

        $user = auth()->user();
        $subscription = Subscription::findOrFail($this->subscription);

        $period = $subscription->type == "yearly" ? "1 year" : "1 month";
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d', strtotime($from_date . $period));

        //Free Plans
        if ($subscription->type == "free") {
            $trial_days = AdminSetting::where('type', 'trial_days')->first()->value;
            $period =  "$trial_days days";
            $to_date = date('Y-m-d', strtotime($from_date . $period));

            //...
            $plan = new LawyerSubscription;
            $plan->users_id = $user->id;
            $plan->subscriptions_id = $subscription->id;
            $plan->from_date = $from_date;
            $plan->to_date = $to_date;
            $plan->save();

            //send Lawyer Subscription Notification
            Notification::route('mail', $user->email)->notify(new LawyerSubscriptionNotification($user, $plan));

            $this->flash('success', 'Free Plan Activated');
            return redirect()->route('lawyer.profile');
        }

        //Paid Plans
        //....
        try {
            
            Stripe::setApiKey(config('services.stripe.secret'));
            
            //create token
            $token = \Stripe\Token::create([
                "card" => array(
                    "name" => $this->card_name,
                    "number" => $this->card_number,
                    "exp_month" => $this->expire_month,
                    "exp_year" => $this->expire_year,
                    "cvc" => $this->cvv
                ),
            ]);

            $customer = \Stripe\Customer::create([
                'source' => $token['id'],
                'email' =>  $user->email,
                'description' => 'My name is ' . $user->name,
            ]);

            $customer_id = $customer['id'];

            /*if(!$user->customer_id) {
				
				
				$customer_id = $customer['id'];
				//update customer id
				$user->customer_id = $customer_id;
				$user->save();
			}*/


            //make payment

            if(!$this->currentPlan){
                $fee = $subscription->price;

                $charge = \Stripe\Charge::create([
                    'currency' => 'USD',
                    'customer' => $customer_id,
                    'amount' =>  $fee * 100,
                ]);


                //save payment transaction details
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
            }


            //save customer id in card table
            $saveCard = new UserCard();
            $saveCard->user_id = $user->id;
            $saveCard->customer_id = $customer_id ;
            $saveCard->card_name = $this->card_name;
            $saveCard->expire_month = $this->expire_month;
            $saveCard->expire_year = $this->expire_year;
            $saveCard->card_type = $token->card->brand;
            $saveCard->card_number = $token->card->last4;
            $saveCard->is_primary = '1';
            //$saveCard->card_number = $this->card_number;
            $saveCard->save();



            //...
            $plan = new LawyerSubscription;
            $plan->users_id = $user->id;
            $plan->subscriptions_id = $subscription->id;
            $plan->payments_id = @$payment->id;
            $plan->from_date = $from_date;
            $plan->to_date = $to_date;
            $plan->save();


            //...
            $user->payment_plan = $subscription->type;
            $user->save();

            //send Lawyer Subscription Notification
            Notification::route('mail', $user->email)->notify(new LawyerSubscriptionNotification($user, $plan));

            $this->flash('success', 'Payment Success');
            return redirect()->route('lawyer.profile');
        } catch (\Stripe\Exception\CardException $e) {
            $error = $e->getMessage();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        $this->alert('error', $error);
    }

    public function removeSubscription()
    {
        $this->alert('warning', 'Are you sure', [
            'toast' => false,
            'position' => 'center',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'onConfirmed' => 'confirmedSubscriptionAction',
            'allowOutsideClick' => false,
            'timer' => null
        ]);
    }

    public function confirmedSubscriptionAction()
    {
        $user = auth()->user();
        $user->auto_renew = '0';
        $user->save();

        $this->flash('success', 'Subscription Removed');
        return redirect()->route('lawyer.subscription');
    }






    public function renewSubscription()
    {
        $this->alert('warning', 'Are you sure', [
            'toast' => false,
            'position' => 'center',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'onConfirmed' => 'confirmedRenewSubscriptionAction',
            'allowOutsideClick' => false,
            'timer' => null
        ]);
    }

    public function confirmedRenewSubscriptionAction()
    {
        $user = auth()->user();
        $user->auto_renew = '1';
        $user->save();

        $this->flash('success', 'Subscription Activated');
        return redirect()->route('lawyer.subscription');
    }







    


    public function render()
    {
        return view('livewire.lawyer.subscriptions');
    }
}
