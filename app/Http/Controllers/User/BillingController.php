<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use App\Models\UserCard;
use Stripe\Stripe;

class BillingController extends Controller
{
    //
    use LivewireAlert;
      
    public function index()
    {
        $title = array(
            'title' => 'Billing Information',
            'active' => 'billing',
        );

        $user = auth()->user();
        $cards = UserCard::where('user_id', $user->id)->get();

        return view('user.billing.index', compact('title', 'cards', 'user'));
    }

    public function create()
    {
        $title = array(
            'title' => 'Billing Information',
            'active' => 'billing',
        );

        return view('user.billing.create', compact('title'));
    }

	
	
	public function store(Request $request){
        $user = auth()->user();
            
            
        $request->validate([
            'card_name' => 'required',
            'expire_month' => 'required',
            'expire_year' => 'required',
            'card_number' => 'required',
            'cvv' => 'required',
        ]);

        $user = auth()->user();


        try {
            
            Stripe::setApiKey(config('services.stripe.secret'));
            
            //create token
            $token = \Stripe\Token::create([
                "card" => array(
                    "name" => $request->card_name,
                    "number" => $request->card_number,
                    "exp_month" => $request->expire_month,
                    "exp_year" => $request->expire_year,
                    "cvc" => $request->cvv
                ),
            ]);

            $customer = \Stripe\Customer::create([
                'source' => $token['id'],
                'email' =>  $user->email,
                'description' => 'My name is ' . $user->name,
            ]);

            $customer_id = $customer['id'];

            $store = new UserCard;

            $store->user_id = $user->id;
            $store->card_name = $request->card_name;
            $store->expire_month = $request->expire_month;
            $store->expire_year = $request->expire_year;
            $store->card_type = $token->card->brand;
            $store->card_number = $token->card->last4;
            $store->save();


            $this->flash('success', 'Card Added');
            return redirect()->back();

        } catch (\Stripe\Exception\CardException $e) {
            $error = $e->getMessage();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        $this->flash('error', $error);
        return redirect()->back();
    }
	
    /* public function store(Request $request)
    {
        $request->validate([
            'card_name' => 'required',
            'expire_month' => 'required',
            'expire_year' => 'required',
            'card_number' => 'required',
        ]);

        $user = auth()->user();

        $store = new UserCard;

        $store->user_id = $user->id;
        $store->card_name = $request->card_name;
        $store->expire_month = $request->expire_month;
        $store->expire_year = $request->expire_year;
        $store->card_number = $request->card_number;
        $store->save();

      
        $this->flash('success', 'New Card Added successfully');
        return redirect()->route('user.billing.index');
    } */


    public function destroy(Request $request)
    {
        $store = UserCard::findOrFail($request->id);
        $store->delete();
      
        $this->flash('success', 'Card Deleted successfully');
        return redirect()->route('user.billing.index');
    }



}