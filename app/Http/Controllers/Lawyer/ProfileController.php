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

        $categories = Category::whereStatus('1')->where('is_multiselect', '0')->get();
        $categoriesMulti = Category::whereStatus('1')->where('is_multiselect', '1')->orderBy('name','ASC')->get();
        


        //  dd($categoriesMulti);
        return view('lawyer.profile.index', compact('user', 'title', 'states', 'categories', 'categoriesMulti'));
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
            'contact_number' => 'required|numeric|digits_between:10,12',
            'address' => 'required',
            'city' => 'required|max:100',
            'state' => 'required',
            'zip_code' => 'required|max:20',
            //'bar_number' => 'required|numeric',
            //'year_admitted' => 'required|numeric',
            'year_experience' => 'required|numeric',
            // 'lawyer_info.*'=>'required|array',
        ]);


        $user = auth()->user();

        $state = State::findOrFail($request->state);
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
        $details->states_id = $request->state;
        $details->zip_code = $request->zip_code;
        //$details->bar_number = $request->bar_number;
        //$details->year_admitted = $request->year_admitted;
        $details->year_experience = $request->year_experience;

        $details->latitude = @$res['latitude'];
        $details->longitude = @$res['longitude'];
        $details->full_address = @$res['address'];

        $details->save();


        //...Working Hours
        if ($request->day) {
            foreach ($request->day as $day => $daysData) {

                foreach($daysData as $data){
                    
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
            Lawyer_info::where('user_id', auth()->user()->id)
                        ->whereHas('categories', function ($query) {
                            $query->where('is_multiselect', '1');
                        })
                        ->delete();

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


        //...
        $this->flash('success', 'Profile updated successfully');
        return redirect()->back();
    }




    public function connectedAccount( Request $request ){
        $user = auth()->user();
        $record = BankInfo::where(['user_id' =>  $user->id])->first();
        
        try {
            if(!$record) {
                $stripe = new \Stripe\StripeClient(
                    config('services.stripe.secret')
                );
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
                    //save bank account..
                    $info = new BankInfo();
                    $info->user_id = $user->id;
                    $info->account_id = $account->id;
                    $info->status = "pending";
                    $info->payouts_enabled = "pending";
                    $info->save();
                    // create link for account update and send
                    $link = $stripe->accountLinks->create([
                        'account' => $account->id,
                        'refresh_url' => route('lawyer.banking.error'),
                        'return_url' => route('lawyer.banking.success'),
                        'type' => 'account_onboarding',
                    ]);
                    //dd($link);
                    return redirect($link->url);
                } else {
                    $this->flash('error', 'Error in account create.');
                    return redirect()->back();
                }
            }else {
                $this->flash('error', 'Account has already connected with stripe.');
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

    public function bankingInfoSuccess()
    {
        $user = auth()->user();
        $record = BankInfo::where(['user_id' => $user->id])->first();


        try {
            if($record) {
                $stripe = new \Stripe\StripeClient(
                    config('services.stripe.secret')
                );
                $account = $stripe->accounts->retrieve($record->account_id);

                if(@$account && $account->payouts_enabled) {
                    $record->payouts_enabled = 'active';              
                } else {
                    $record->payouts_enabled = 'inactive'; 
                }
                
                $record->save();

                $this->flash('success', 'Account added successfully');
            }

        } catch (\Exception $e) {
            $this->flash('error', $e->getMessage());
        }
        

        return redirect()->route('lawyer.profile');
    }

    public function bankingInfoError()
    {
        $this->flash('error', 'Try again.');
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

            $this->flash('success', 'Request Send');
            return redirect()->back();
        }

        //...
        $this->flash('error', 'Invalid Request');
        return redirect()->back();
    }
}
