<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Lawyer_info;
use Illuminate\Http\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\UserDetails;
use App\Models\State;
use App\Models\LawyerHours;
use App\Models\BankInfo;
use App\Models\Booking;

use App\Models\StateBar;
use App\Models\LawyerStateBar;
use App\Models\UserCard;
use Stripe\Stripe;

use App\Notifications\MailToAdminForLawyerStatus;
use Illuminate\Support\Facades\Notification;

class ProfileController extends Controller
{
    use LivewireAlert;

    public function __construct()
    {
        $stripe = new \Stripe\StripeClient(
            config('services.stripe.secret')
        );
    }


    //
    public function index()
    {

        $title = array(
            'title' => 'Profile',
            'active' => 'profile',
        );

        $user = auth()->user();
        $states = State::whereStatus('1')->pluck('name', 'id');
        // dd($user);

        $categories = Category::whereStatus('1')->orderBy('id','ASC')->get();
        $categoriesMulti = Category::whereStatus('1')->orderBy('name','ASC')->get();
        
        $stateBar = StateBar::whereStatus('1')->get();


        //  dd($categoriesMulti);
        return view('lawyer.profile.index', compact('user', 'title', 'states', 'categories', 'categoriesMulti', 'stateBar'));
    }

    //
    public function update(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'bio' => 'required',
            'contingency_cases' => 'required',
            'is_consultation_fee' => 'required',
            'hourly_fee' => 'required',
            'website_url' => 'nullable|url',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            //'contact_number' => 'required|numeric|digits_between:10,12',
            'contact_number' => 'required',
            'address' => 'required',
            'school_attendent' => 'required',
            //'city' => 'required|max:100',
            //'states_id' => 'required',
            'zip_code' => 'required|max:20',
            //'bar_number' => 'required|numeric',
            //'year_admitted' => 'required|numeric',
            'year_experience' => 'required|numeric',
            // 'lawyer_info.*'=>'required|array',
        ]);


        $user = auth()->user();

        $state = State::findOrFail($request->states_id);
        $address = $request->address.', '.$request->city.', '.$state->name.', '.$request->zip_code;
        
        //dd($query);
        $res = getLatLong($address);


        if ($request->image && strpos($request->image, "data:") !== false) {
            $image = $request->image;

            $folderPath = ('storage/images/');
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0775, true);
                chown($folderPath, exec('whoami'));
            }

            $image_parts = explode(";base64,", $image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_base64 = base64_decode($image_parts[1] ?? null) ?? null;
            $file_name = $user->id . '-' . md5(uniqid() . time()) . '.png';
            $imageFullPath = $folderPath . $file_name;
            file_put_contents($imageFullPath, $image_base64);

            //...
            $user->image = $file_name;
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->contact_number = $request->contact_number;
        $user->save();


        //...
        $details = new UserDetails;
        if (@$user->details) {
            $details->id = $user->details->id;
            $details->exists = true;
        } else {
            $details->users_id = $user->id;
        }
        $details->bio = $request->bio;
        $details->contingency_cases = $request->contingency_cases;
        $details->is_consultation_fee = $request->is_consultation_fee;
        $details->hourly_fee = $request->hourly_fee;
        $details->consultation_fee = $request->consultation_fee;
        $details->website_url = $request->website_url;
        $details->address = $request->address;
        $details->city = $request->city;
        $details->states_id = $request->states_id;
        $details->zip_code = $request->zip_code;
        //$details->bar_number = $request->bar_number;
        //$details->year_admitted = $request->year_admitted;
        $details->year_experience = $request->year_experience;
        $details->school_attendent = $request->school_attendent;

        $details->latitude = @$res['latitude'];
        $details->longitude = @$res['longitude'];
        $details->full_address = @$res['address'];

        $details->save();

        //dd($request->day);
        //...Working Hours
        $daysArray = [];
        if ($request->day) {
            foreach ($request->day as $day => $daysData) {

                if(@$daysData['selected']=='on' && @$daysData['data']) {

                    array_push($daysArray, $day);
                    //dd($daysData['data']);
                    foreach(@$daysData['data'] as $data){
                        
                        if(@$data['delete']=='yes'){
                            $checkHour = LawyerHours::find($data['id']);

                            if (@$checkHour) {
                                $checkHour->delete();
                            }

                        }
                        else {
                            if (@$data['from_time'] && $data['to_time']) {
                                $hour = new LawyerHours;
                                if (@$data['id']) {
                                    $checkHour = LawyerHours::find($data['id']);
                                    if (@$checkHour) {
                                        $hour->id = $checkHour->id;
                                        $hour->exists = true;
                                    }
                                }
                                $hour->users_id = $user->id;
                                $hour->day = $day;
                                $hour->from_time = $data['from_time'];
                                $hour->to_time = $data['to_time'];
                                $hour->save();
                            }
                        }
                    }
                }
            }
        }

        if($daysArray){
            $deleteLawyersDay = LawyerHours::whereNotIn('day', $daysArray)
                        ->where('users_id', auth()->user()->id)
                        ->get();
            foreach($deleteLawyersDay as $delDays){
                $delDays->delete();
            }
        }

        //...save category and items id's
        if ($request->lawyer_info) {
            // on update
            Lawyer_info::where('user_id', auth()->user()->id)
                        ->whereHas('categories', function ($query) {
                            $query->where('is_multiselect', '0');
                        })
                        ->delete();

            foreach ($request->lawyer_info as $cat_id => $item_id) {
                if(@$item_id){
                    $storeInfo = new Lawyer_info();
                    $storeInfo->user_id = auth()->user()->id;
                    $storeInfo->category_id = $cat_id;
                    $storeInfo->item_id = $item_id;
                    $storeInfo->save();
                }
            }
        }

        //.........
        if ($request->lawyer_address) {
            // on update
            Lawyer_info::where('user_id', auth()->user()->id)->delete();

            foreach ($request->lawyer_address as $cat_id => $items) {
                foreach ($items['data'] as $itemId => $item) {
                    if(@$item['year_admitted'] && @$item['bar_number']){
                        $storeInfo = new Lawyer_info();
                        $storeInfo->user_id = auth()->user()->id;
                        $storeInfo->category_id = $cat_id;
                        $storeInfo->item_id = $itemId;
                        $storeInfo->year_admitted = @$item['year_admitted'];
                        $storeInfo->bar_number = @$item['bar_number'];
                        $storeInfo->save();
                    }
                }
            }
        }

        ///....state bar
        //lawyer_state
        if ($request->lawyer_state) {
            // on update
            LawyerStateBar::where('user_id', auth()->user()->id)->delete();

            foreach ($request->lawyer_state as $state_id => $item) {
                if(@$item['year_admitted'] && @$item['bar_number']){
                    $storeStateBar = new LawyerStateBar();
                    $storeStateBar->user_id = auth()->user()->id;
                    $storeStateBar->state_bar_id = $state_id;
                    $storeStateBar->year_admitted = @$item['year_admitted'];
                    $storeStateBar->bar_number = @$item['bar_number'];
                    $storeStateBar->save();
                }
            }
        }


        //...
        $this->flash('success', 'Profile updated successfully');
        return redirect()->back();
    }




    public function connectedAccount( Request $request ){
        $user = auth()->user();
        $record = BankInfo::where(['user_id' =>  $user->id])->first();
        
        if(@$record->account_number){
            $this->flash('error', 'Account already connected with stripe');
            return redirect()->back();
        }
        
        try {
            $accountId = '';
            
            $stripe = new \Stripe\StripeClient(
                config('services.stripe.secret')
            );
            
            if(@$record->account_id){
                $accountId = $record->account_id;
            }
            else {
                $account = $stripe->accounts->create([
                    'type' => 'custom',
                    'country' => 'US',
                    'email' => $user->email,
                    'capabilities' => [
                        'card_payments' => ['requested' => true],
                        'transfers' => ['requested' => true],
                    ],
                ]);
                
                if(@$account->id) {
                    $accountId = $account->id;   
                }
            }
            
            


            if(@$accountId) {
                //save bank account..
                $info = new BankInfo();
                if(@$record){
                    $info->id = $record->id;
                    $info->exists = true;
                }
                else {
                    $info->status = "pending";
                }
                $info->user_id = $user->id;
                $info->account_id = $accountId;
                $info->payouts_enabled = "pending";
                $info->save();
                // create link for account update and send
                $link = $stripe->accountLinks->create([
                    'account' => $accountId,
                    'refresh_url' => route('lawyer.banking.error'),
                    'return_url' => route('lawyer.banking.success.callback'),
                    'type' => 'account_onboarding',
                ]);
                //dd($link);
                return redirect($link->url);
            } else {
                $this->flash('error', 'Error in account create.');
                return redirect()->back();
            }
                
                
        } catch (\Stripe\Exception\RateLimitException $e) {
        // Too many requests made to the API too quickly
            $error = $e->getMessage();
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            $error = $e->getMessage();
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            $error = $e->getMessage();
            // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            $error = $e->getMessage();
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            $error = $e->getMessage();
            // yourself an email
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $error = $e->getMessage();
        }


        $this->flash('error', $error);
        return redirect()->back();
    }
    
    
    public function bankingInfoSuccessCallback(){
        $user = auth()->user();
        $record = BankInfo::where(['user_id' => $user->id])->first();

        if(@$record){
            $record->status = "active";
            $record->save();
        }
        
        return redirect()->route('lawyer.banking.success');
    }
    

    public function bankingInfoSuccess(){
        $user = auth()->user();
        $record = BankInfo::where(['user_id' => $user->id])->first();
        
        
        if($record) {

            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );
            
            
            
            try {
                
                $account = @$stripe->accounts->retrieve($record->account_id);
//dd($account);
                $status = ''; 
                if($account && $account->payouts_enabled) {
                    $status = 'active';              
                } else {
                    $status = 'inactive'; 
                }

                BankInfo::where('id', $record->id)->update(["payouts_enabled" => $status]);
                $record = $record->refresh(); 

                } catch (\Stripe\Exception\RateLimitException $e) {
                    $message = $e->getMessage();
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    $message = $e->getMessage();
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    $message = $e->getMessage();         
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    $message = $e->getMessage();
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $message = $e->getMessage();
                } catch (Exception $e) {
                    $message = $e->getMessage();
                }
        }
        
        
        return view('lawyer.profile.account', compact('user', 'record'));
    }




    public function cardRemove(Request $request){
        $user = auth()->user();
        $card = UserCard::findOrFail($request->id);

        if(@$card){
            
            $card->delete();
            $this->flash('success', 'Card Removed');
            return redirect()->back();

        }

        $this->flash('error', 'Server Error');
		return redirect()->back();
        //return redirect()->route('lawyer.banking.success');
    }


    public function cardPrimary(Request $request){
        $user = auth()->user();
        $card = UserCard::findOrFail($request->id);

        if(@$card){

            $acards = $user->userCards()->where('is_primary', '1')->get();
            foreach($acards as $acard){
                $acard->is_primary = '0';
                $acard->save();
            }
            
            $card->is_primary = '1';
            $card->save();
            $this->flash('success', 'Card set as primary');
            return redirect()->back();

        }

        $this->flash('error', 'Server Error');
		return redirect()->back();
        //return redirect()->route('lawyer.banking.success');
    }


    public function cardStore(Request $request){
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
            return redirect()->route('lawyer.banking.success');

        } catch (\Stripe\Exception\CardException $e) {
            $error = $e->getMessage();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        $this->flash('error', $error);
            return redirect()->route('lawyer.banking.success');
    }


    
    
    public function connectedAccountUpdate( Request $request ) 
    {
        $user = auth()->user();
        $record = BankInfo::where(['user_id' =>  $user->id])->first();
        
        try {

            if($record) {

                $stripe = new \Stripe\StripeClient(
                    env('STRIPE_SECRET')
                );

                $account = $stripe->accounts->retrieve(
                    $record->account_id
                );

                if($account) {
                    if(!$account->payouts_enabled) {
                        $link = $stripe->accountLinks->create([
                            'account' => $record->account_id,
                            'refresh_url' => route('lawyer.banking.error'),
                            'return_url' => route('lawyer.banking.success.callback'),
                            'type' => 'account_update',
                        ]);
                        return redirect($link->url);
                    } else {
                        BankInfo::where('id', $record->id)->update(["payouts_enabled" => 'active']);
                        

                        $this->flash('success', "Payouts are enabled for your account.");
                        return redirect()->back();
                    }
                }
                
            } else {
                $this->flash('error', "No record found.");
                return redirect()->back();
            }
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            $error = $e->getMessage();
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            $error = $e->getMessage();
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            $error = $e->getMessage();
            // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            $error = $e->getMessage();
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            $error = $e->getMessage();
            // yourself an email
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $error = $e->getMessage();
        }
		
		$this->flash('error', $error);

        return redirect()->back();
        
    }
    
    

    public function bankingInfoStore(Request $request)
    {

        $request->validate([
            'account_number' => 'required',
            'routing_number' => 'required|min:9',
            'account_holder_name' => 'required',
        ]);



        $user = auth()->user();
        $record = BankInfo::where(['user_id' => $user->id])->first();

        try {
            $stripe = new \Stripe\StripeClient(
                config('services.stripe.secret')
            );

            $bank = $stripe->accounts->createExternalAccount(
                $record->account_id,
                [
                    'external_account' => [
                        "currency" => "usd",
                        "country" => "us",
                        "object" => "bank_account",
                        "account_holder_name" => $request->account_holder_name,
                        "routing_number" => $request->routing_number,
                        "account_number" => $request->account_number,
                    ],
                ]
            );

            //dd($bank['id']);

            
            if($bank) {

                $record->bid = @$bank['id'];
                $record->account_holder_name = $request->account_holder_name;
                $record->routing_number = $request->routing_number;
                $record->account_number = $request->account_number;
                $record->save();
                
            }

            $this->flash('success', 'Your bank info added successfully');
            return redirect()->route('lawyer.banking.success');
            

        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            $error = $e->getMessage();
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            $error = $e->getMessage();
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            $error = $e->getMessage();
            // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            $error = $e->getMessage();
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            $error = $e->getMessage();
            // yourself an email
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $error = $e->getMessage();
        }

        //dd($error);
        $this->flash('error', $error);

        return redirect()->back();
    }

    public function bankingInfoError()
    {
        $this->flash('error', 'Try again.');
        return redirect()->route('lawyer.profile');
    }







    public function bookingConfirmData(Request $request){
        //$user = auth()->user();
        $booking = Booking::findOrFail($request->booking);

        if(@$booking){
            
            if(@$booking->lawyer_res){
                $this->flash('error', "You've already confirmed client appearance");
                return redirect()->route('lawyer.profile');
            }
            else {
                $booking->lawyer_res = $request->action;
                $booking->save();
                
                $this->flash('success', 'Client Appearance Confirmed');
                return redirect()->route('lawyer.profile');
            }
             

        }

        $this->flash('error', 'Server Error');
        return redirect()->route('lawyer.profile');
    }



    public function submit(Request $request)
    {

        $user = auth()->user();
        $details = $user->details;

        $hoursCount = $user->lawyerHours->count();

        if ($details->is_verified == 'no' && $details->address && $details->review_request == '0' && $hoursCount > 0) {

            $details->review_request = '1';
            $details->save();

            //...send mail

            Notification::route('mail', env('MAIL_FROM_ADDRESS'))->notify(new MailToAdminForLawyerStatus($user));

            $this->flash('success', 'Request Sent');
            return redirect()->back();
        }

        //...
        $this->flash('error', 'Invalid Request');
        return redirect()->back();
    }
}
