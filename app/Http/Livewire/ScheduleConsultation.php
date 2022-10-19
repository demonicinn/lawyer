<?php

namespace App\Http\Livewire;

use App\Http\Controllers\MeetingController;
use App\Models\Booking;
use App\Models\User;
use App\Models\UserCard;
use App\Models\Payment;




use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Stripe\Stripe;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Validation\Rule;
use PasswordValidationRules;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Notifications\BookingMail;
use Illuminate\Support\Facades\Notification;
use Exception;


class ScheduleConsultation extends Component
{
    use LivewireAlert;
    //....

    public $currentTab = 'tab1';


    public $lawyerID, $lawyer;
    public $month, $year;
    public $todayDate;

    public $workingDates = [];
    public $workingDatesTimeSlot = [];

    public $selectDate;
    public $selectDateTimeSlot;
    public $dateFormat;

    public $authUser;

    public $first_name, $last_name, $phone, $password, $password_confirmation, $email;
    public $card_name, $card_number, $expire_month, $expire_year, $cvv, $save_card=false;
    public $upassword, $uemail;

    public $cardId = null;
    public $totalCharges = 0;
    public $searchType, $searchData;


    public function mount()
    {
        if(Auth::check()){
            $this->authUser = auth()->user();
        }

        $date = date('Y-m-d');
        $this->lawyer = User::where('id', $this->lawyerID)->first();

        $subscription = $this->lawyer->lawyerSubscription()
                        ->where('from_date', '<=', $date)
                        ->where('to_date', '>=', $date)
                        ->orderBy('id', 'desc')
                        ->first();
        if(!$subscription){


            $this->flash('error', 'Lawyer Subscription is expired');
            return redirect()->route('narrow.down');
        }



        $totalCharges = 0;
        if($this->lawyer->details->is_consultation_fee=='yes'){
            $totalCharges = $this->lawyer->details->consultation_fee;
        }

        $this->totalCharges = $totalCharges + env('CHARGES');


        $this->todayDate = Carbon::now();
        
        $this->dateFormat = $this->todayDate->format("l, F j");
        $this->getWorkingDays($this->todayDate);


        $this->searchType = session('search_type');
        $search_data = session('search_data');
        if(@$this->searchType=='litigations' && $search_data){
            $this->searchData = $this->lawyer->lawyerLitigations()
                        ->whereHas('litigation', function($query) use($search_data) {
                            $query->whereIn('id', $search_data);
                        })
                        ->get()
                        ->pluck('litigation.name');
        }
        if(@$this->searchType=='contracts' && $search_data){
            $this->searchData = $this->lawyer->lawyerContracts()
                        ->whereHas('contract', function($query) use($search_data) {
                            $query->whereIn('id', $search_data);
                        })
                        ->get()
                        ->pluck('contract.name');
        }
        //dd($search_data);
        //dd($this->searchData);
    }

    public function confirmSlot()
    {
        $this->validate([
            'selectDate' => 'required',
            'selectDateTimeSlot' => 'required',

        ], [
            'selectDate.required' => 'Please select date.',
            'selectDateTimeSlot.required' => 'Please select time slot.'
        ]);

        $this->currentTab = "tab2";
        $this->emit('scrollUp');

        if (auth::user()) {
            $this->first_name = auth()->user()->first_name;
            $this->last_name = auth()->user()->last_name;
            $this->email = auth()->user()->email;
            $this->phone = auth()->user()->contact_number;
        }
    }    

    public function monthChange()
    {
        if ($this->month && $this->year) {
            $ndate = date($this->year . '-' . $this->month . '-1');
            $date = Carbon::parse($ndate);

            //$this->workingDates = [];

            $this->getWorkingDays($date);
        }
    }

    private function getWorkingDays($today)
    {

        $fromDate = $today->copy()->firstOfMonth()->startOfDay();
        $toDate = $today->copy()->endOfMonth()->startOfDay();

        $Month = date('m', strtotime($fromDate));
        $Year = date('Y', strtotime($fromDate));

        $dates = [];
        $period = CarbonPeriod::create($fromDate, $toDate);


        $lawyerHoursDay = $this->lawyer->lawyerHours->pluck('day')->toArray();
        // dd($lawyerHoursDay);

        $getLeaves = $this->lawyer->leave()->whereMonth('date', $Month)
                        ->whereYear('date', $Year)
                        ->pluck('date')->toArray();
        
        foreach ($period as $date) {
            $day = $date->format('l');
            $ndate = $date->format('Y-m-d');

            // dd($ndate );

            ///,.....available current date
            if ($ndate >= date('Y-m-d') && in_array($day, $lawyerHoursDay)) {
                array_push($dates, $ndate);
            }
        }
        //  dd($dates);
        $result = array_diff($dates, $getLeaves);
        // dd($result);
        $this->workingDates = $result;


        $this->emit('fireCalender', $this->workingDates);
    }

    public function slotAvailability()
    {
        $selectDate = Carbon::parse($this->selectDate);
        $date = $selectDate->format('Y-m-d');
        $this->dateDay = $selectDate->format("l");
        $this->dateFormat = $selectDate->format("l, F j");


        $fromDate =  $selectDate->copy()->firstOfMonth()->startOfDay();
        $toDate = $selectDate->copy()->endOfMonth()->startOfDay();
        $fDateMonth = date('Y-m-d', strtotime($fromDate));
        $lDateMonth = date('Y-m-d', strtotime($toDate));



        $lawyerHours = $this->lawyer->lawyerHours()->where('day', $this->dateDay)->get();

        $getLeaves = $this->lawyer->booking()->whereDate('booking_date', $date)->pluck('booking_time')->toArray();


        $checkLeave = $this->lawyer->leave()->where('date', $date)->first();



        ///,.....available current date
        if(!$checkLeave){
            if (@$lawyerHours && $date >= date('Y-m-d')) {

                
                $duration = '30';

                //...
                $time_slots = array();
                $add_mins  = $duration * 60;

                foreach($lawyerHours as $lawyerHour){
                    $startTime = strtotime($lawyerHour->from_time);
                    $endTime = strtotime($lawyerHour->to_time);
                    while ($startTime <= $endTime) {
                        $timeSlot = [];
                        if(in_array(date("H:i:s", $startTime), $getLeaves)) {
                            $timeSlot['is_free'] = 'no';
                        }
                        else {
                            $timeSlot['is_free'] = 'yes';
                        }


                        $timeSlot['time'] = date("H:i", $startTime);
                        $time_slots[] = $timeSlot;

                        $startTime += $add_mins;

                    }
                }
                $this->workingDatesTimeSlot = $time_slots;
            }
        }
    }



    ////..................tab 2


    public function backbtn()
    {
        //...
        $sDate = Carbon::parse($this->selectDate);
        $this->getWorkingDays($sDate);


        $this->currentTab = "tab1";
        $this->emit('scrollUp');
    }

    public function login()
    {
        $this->validate([
            'uemail' => 'required|email',
            'upassword' => 'required|min:6',

        ], [
            'uemail.required' => 'Email field is required.',
            'upassword.required' => 'Password field is required.',
            'upassword.min' => 'The password must be at least 6 characters.',
        ]);

        $email = $this->uemail;
        $password = $this->upassword;

        $credentials = ['email' => $email, 'password' => $password];

        if (!Auth::attempt($credentials)) {
            $this->alert('error', 'Invalid credentials');
        } else {

            $this->authUser = auth()->user();

            $this->first_name = $this->authUser->first_name;
            $this->last_name = $this->authUser->last_name;
            $this->email = $this->authUser->email;
            $this->phone = $this->authUser->contact_number;
            

            $this->alert('success', 'Login successfully');
            $this->emit('loginFormClose');
            $this->resetLoginfields();
            
        }
    }

    public function resetLoginfields()
    {
        $this->uemail = null;
        $this->upassword = null;
    }




    public function rules()
    {
        if($this->cardId){
            return [
                'first_name' => ['required', 'string', 'max:100'],
                'last_name' => ['required', 'string', 'max:100'],
                'phone' => ['nullable', 'numeric', 'digits_between:10,12'],
                'email' => ['required', 'string', 'email', 'max:255'],
            ];
        }

        if (Auth::check()) {
            if ($this->lawyer->details->is_consultation_fee == "no") {
                return [
                    'first_name' => ['required', 'string', 'max:100'],
                    'last_name' => ['required', 'string', 'max:100'],
                    'phone' => ['nullable', 'numeric', 'digits_between:10,12'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                ];
            }

            return [
                'first_name' => ['required', 'string', 'max:100'],
                'last_name' => ['required', 'string', 'max:100'],
                'phone' => ['nullable', 'numeric', 'digits_between:10,12'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'card_name' => 'required|max:50',
                'card_number' => 'required|numeric|digits_between:12,16',
                'expire_month' => 'required',
                'expire_year' => 'required',
                'cvv' => 'required|numeric|digits_between:3,4',
            ];
        }

        if ($this->lawyer->details->is_consultation_fee == "no") {
            return [
                'first_name' => ['required', 'string', 'max:100'],
                'last_name' => ['required', 'string', 'max:100'],
                'phone' => ['nullable', 'numeric', 'digits_between:10,12'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
                'password' => 'required',
                'password_confirmation' => 'required_with:password|same:password',
            ];
        }

        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'numeric', 'digits_between:10,12'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => 'required',
            'password_confirmation' => 'required_with:password|same:password',
            'card_name' => 'required|max:50',
            'card_number' => 'required|numeric|digits_between:12,16',
            'expire_month' => 'required',
            'expire_year' => 'required',
            'cvv' => 'required|numeric|digits_between:3,4'
        ];
    }

    protected $messages = [
        'card_name.required' => 'Name on card field is required.',
    ];


    //register and save card details
    public function saveUserInfoAndBooking()
    {
        $this->validate();

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $selectDate = Carbon::parse($this->selectDate);
        $date = $selectDate->format('Y-m-d');
        $ndate = $this->selectDate . ' ' . $this->selectDateTimeSlot;
        $nTimeSlot = date('H:i:s', strtotime($this->selectDateTimeSlot));


        $authUser = '';
        if (Auth::check()) {
            $authUser = auth()->user();
        } else {
            $createUser = new User;
            $createUser->first_name = $this->first_name;
            $createUser->last_name = $this->last_name;
            $createUser->email = $this->email;
            $createUser->contact_number = $this->phone;
            $createUser->role = "user";
            $createUser->password = Hash::make($this->password);
            $createUser->save();

            $authUser = User::find($createUser->id);
        }

        //...
        if (!Auth::check()) {
            Auth::login($authUser);
        }


        $dateTime = Carbon::parse($ndate);

        
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

            $customer = \Stripe\Customer::create([
                'source' => $token['id'],
                'email' =>  $authUser->email,
                'description' => 'My name is ' . $authUser->name,
            ]);

            $customer_id = $customer['id'];


            $fee = $this->totalCharges;

            $charge = \Stripe\Charge::create([
                'currency' => 'USD',
                'customer' => $customer_id,
                'amount' =>  $fee * 100,
            ]);


            if(@$charge){

                //save customer id in card table

                if($this->save_card){
                    $checkCard = UserCard::where('user_id', $authUser->id)
                                    ->where('card_number', $this->card_number)
                                    ->first();

                    $saveCard = new UserCard;
                    if(@$checkCard){
                        $saveCard->id = $checkCard->id;
                        $saveCard->exists = true;
                    }
                    $saveCard->user_id = $authUser->id;
                    $saveCard->customer_id = $customer_id;
                    $saveCard->card_name = $this->card_name;
                    $saveCard->expire_month = $this->expire_month;
                    $saveCard->expire_year = $this->expire_year;
                    $saveCard->card_type = $token->card->brand;
                    //$saveCard->card_number = $token->card->last4;
                    $saveCard->card_number = $this->card_number;
                    $saveCard->save();

                    $saveCardId = $saveCard->id;
                }

                /// generate meeting
                $meeting = new MeetingController;
                $a = $meeting->store($dateTime);
                // dd($a);


                if (@$a) {
                    $zoom_id = $a['data']['id'];
                    $zoom_password = @$a['data']['password'];
                    $zoom_start_url = @$a['data']['start_url'];


                    $lawyer_amount = 0;
                    if ($this->lawyer->details->is_consultation_fee == "yes") {
                        $calAmount = $this->lawyer->details->consultation_fee;
                        $calAmountPercentage = $calAmount / env('ADMIN_PERCENTAGE');

                        $lawyer_amount = $calAmount - $calAmountPercentage;
                    }

                    //...
                    $paymentStore = new Payment;
                    $paymentStore->users_id = $authUser->id;
                    $paymentStore->transaction_id = $charge->id;;
                    $paymentStore->balance_transaction = $charge->balance_transaction;
                    $paymentStore->customer = $customer_id;
                    $paymentStore->currency = 'usd';
                    $paymentStore->amount = $fee;
                    $paymentStore->payment_status = $charge->status;
                    $paymentStore->payment_type = 'booking';
                    $paymentStore->save();
                    

                    //...
                    $booking = new Booking;
                    $booking->user_id = $authUser->id;
                    $booking->lawyer_id = $this->lawyerID;
                    $booking->user_cards_id = @$saveCardId;
                    $booking->payment_id = @$paymentStore->id;
                    $booking->first_name = $this->first_name;
                    $booking->last_name = $this->last_name;
                    $booking->user_email = $this->email;
                    $booking->user_contact = $this->phone;
                    $booking->booking_date = $date;
                    $booking->booking_time = $nTimeSlot;

                    if ($this->lawyer->details->is_consultation_fee == "no") {
                        $booking->appointment_fee = "free";
                    } else {
                        $booking->appointment_fee = "paid";
                        $booking->consultation_fee = $this->lawyer->details->consultation_fee;
                    }

                    $booking->deposit_amount = env('CHARGES');
                    $booking->lawyer_amount = @$lawyer_amount;
                    $booking->total_amount = $fee;

                    $booking->zoom_id = @$zoom_id;
                    $booking->zoom_password = @$zoom_password;
                    $booking->zoom_start_url = @$zoom_start_url;
                    $booking->save();

                    if ($booking) {

                        //send notification to User
                        Notification::route('mail', $this->email)->notify(new BookingMail($booking, $authUser));
                        //send notification to lawyer
                        Notification::route('mail', $this->lawyer->email)->notify(new BookingMail($booking, $this->lawyer));

                        $this->flash('success', 'Appointment scheduled successfully');

                        return redirect()->route('thankYou');
                        //return redirect()->route('consultations.upcoming');
                    }
                }
                ///...........
            }
            else {
                $this->alert('error', 'Charge error');
            }

        } catch (\Stripe\Exception\CardException $e) {
            $error = $e->getMessage();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        $this->alert('error', $error);

    }



    public function useSavedCard($id)
    {
        $this->resetCardInfo();

        $getCard = UserCard::findOrFail($id);
        
        $this->card_name = $getCard->card_name;
        $this->card_number = $getCard->card_number;
        $this->expire_month = $getCard->expire_month;
        $this->expire_year = $getCard->expire_year;
        $this->cvv = $getCard->cvv;

        //$this->saveUserInfoAndBooking();
    }

    public function resetCardInfo()
    {
        $this->card_name = '';
        $this->card_number = '';
        $this->expire_month = '';
        $this->expire_year = '';
        $this->cvv = '';
    }


    public function render()
    {
        //$this->resetValidation();
        $this->workingDatesTimeSlot = [];
        //...
        $this->monthChange();

        //...
        if ($this->selectDate) {
            $this->slotAvailability();
        }

        return view('livewire.schedule-consultation');
    }


}
