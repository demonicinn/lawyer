<?php

namespace App\Http\Livewire\Lawyer;

use Livewire\Component;
use Stripe\Stripe;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\LawyerSubscription;

class Subscriptions extends Component
{
	use LivewireAlert;
    public $subscriptions, $user;

    public $subscription = '';
    public $type = 'monthly';

    public $card_name, $card_number, $expire_month, $expire_year, $cvv;

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret')); 
    }

    public function mount()
    {
        $this->user = auth()->user();

        $subscriptionCount = $this->user->lawyerSubscription->count();

		$this->subscriptions = Subscription::whereStatus('1')
                        ->where(function ($query) use ($subscriptionCount) {
                            if($subscriptionCount > 0 ){
                                $query->where('type', '!=', 'free');
                            }
                        }) 
                        ->get();
    }

    public function setSubscription($id, $type){
        $this->subscription = $id;
        $this->type = $type;
    }


    public function store()
	{
        if($this->type == 'free'){
            $this->validate([
                'subscription' => 'required'
            ]);
        }
        else {
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

        $period = $subscription->type=="yearly" ? "1 year" : "1 month";
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d', strtotime($from_date . $period));

        //Free Plans
        if($subscription->type == "free"){
            //...
            $plan = new LawyerSubscription;
			$plan->users_id = $user->id;
			$plan->subscriptions_id = $subscription->id;
			$plan->from_date = $from_date;
			$plan->to_date = $to_date;
			$plan->save();

            $this->flash('success', 'Free Plan Activated');
			return redirect()->route('lawyer.profile');
        }

        //Paid Plans
        //....
        try {
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


            if(!$user->customer_id) {
				$customer = \Stripe\Customer::create([
					'source' => $token['id'],
					'email' =>  $user->email,
					'description' => 'My name is '. $user->name,
				]);
				
				$customer_id = $customer['id'];
				//update customer id
				$user->customer_id = $customer_id;
				$user->save();
			}


            //make payment
			$fee = $subscription->price;
			
			$charge = \Stripe\Charge::create([
				'currency' => 'USD',
				'customer' => $user->customer_id,
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
			$payment->save();


            //...
            $plan = new LawyerSubscription;
			$plan->users_id = $user->id;
			$plan->subscriptions_id = $subscription->id;
			$plan->payments_id = $payment->id;
			$plan->from_date = $from_date;
			$plan->to_date = $to_date;
			$plan->save();

            $this->flash('success', 'Payment Success');
			return redirect()->route('lawyer.profile');

        } catch (\Stripe\Exception\CardException $e) {
            $error = $e->getMessage();
        } catch (Exception $e) {
			$error = $e->getMessage();
		}
		
        $this->alert('error', $error);
    }


    public function render()
    {
        return view('livewire.lawyer.subscriptions');
    }
}
