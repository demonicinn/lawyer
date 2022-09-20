<?php

namespace App\Http\Livewire;

use App\Http\Controllers\MeetingController;
use App\Models\Booking;
use App\Models\LawyerContracts;
use App\Models\Contract;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Stripe\Stripe;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\LawyerHours;
use App\Models\LawyerLitigations;
use App\Models\Litigation;
use App\Models\Leave;
use App\Models\UserCard;
use PasswordValidationRules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Notifications\BookingMail;
use Illuminate\Support\Facades\Notification;

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

    public $dateDay, $dateFormat;

    public $lawyerlitigations, $lawyerContracts, $authUser, $litigations, $contracts;


    public $day, $avaibleTime, $selDate, $lawyerDetails, $scheduletime, $bookDate, $is_booking_exits;
    public $timeSlots = [];
    public $shedulePage = true;
    public $clickConfirm = false;

    public $first_name, $last_name, $phone, $password,
        $password_confirmation, $email, $card_name, $card_number,
        $expire_month, $expire_year, $cvv, $upassword, $uemail;


    public function rules()

    {
        if (Auth::check()) {
            if ($this->lawyer->details->is_consultation_fee == "no") {
                return [
                    'first_name' => ['required', 'string', 'max:100'],
                    'last_name' => ['required', 'string', 'max:100'],
                    'phone' => ['required', 'numeric', 'digits_between:10,12'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                ];
            }

            return [
                'first_name' => ['required', 'string', 'max:100'],
                'last_name' => ['required', 'string', 'max:100'],
                'phone' => ['required', 'numeric', 'digits_between:10,12'],
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
                'phone' => ['required', 'numeric', 'digits_between:10,12'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
                'password' => 'required',
                'password_confirmation' => 'required_with:password|same:password',
            ];
        }

        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'numeric', 'digits_between:10,12'],
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



    public function mount()
    {
        $this->lawyer = User::where('id', $this->lawyerID)->with('details')->first();

        $lawyerLitigations = LawyerLitigations::where('users_id', $this->lawyerID)->with('litigations')->get();
        $litigations_id = [];
        foreach ($lawyerLitigations as $litigatinsId) {
            array_push($litigations_id, $litigatinsId->litigations_id);
        }
        $this->litigations = Litigation::whereIn('id', $litigations_id)->get();


        $lawyerContracts = LawyerContracts::where('users_id', $this->lawyerID)->with('contracts')->get();
        $contracts_id = [];
        foreach ($lawyerContracts as $contractsId) {
            array_push($contracts_id, $contractsId->contracts_id);
        }
        $this->contracts = Contract::whereIn('id', $contracts_id)->get();

        $this->authUser = auth()->user();
        $this->todayDate = Carbon::now();
        $this->getWorkingDays($this->todayDate);
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

        if (auth::user()) {
            $this->first_name = auth()->user()->first_name;
            $this->last_name = auth()->user()->last_name;
            $this->email = auth()->user()->email;
            $this->phone = auth()->user()->contact_number;
        }
    }

    public function backbtn()
    {
        $this->currentTab = "tab1";
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
        $getLeaves = Leave::where('user_id', $this->lawyerID)
            ->whereMonth('date', $Month)
            ->whereYear('date', $Year)
            ->pluck('date')->toArray();
        //   dd($getLeaves);
        foreach ($period as $date) {
            $day = $date->format('l');
            $ndate = $date->format('Y-m-d');

            // dd($ndate );

            if ($ndate > date('Y-m-d') && in_array($day, $lawyerHoursDay)) {
                array_push($dates, $ndate);
            }
        }
        //  dd($dates);
        $result = array_diff($dates, $getLeaves);
        // dd($result);
        $this->workingDates = $result;

        $this->checkIfBookingAlreadyExits($this->bookDate);

        $this->emit('fireCalender', $this->workingDates);
    }

    public function slotAvailability()
    {
        $selectDate = Carbon::parse($this->selectDate);
        $date = $selectDate->format('Y-m-d');
        $this->dateDay = $selectDate->format("l");
        $this->dateFormat = $selectDate->format("l, F j ");


        $fromDate =  $selectDate->copy()->firstOfMonth()->startOfDay();
        $toDate = $selectDate->copy()->endOfMonth()->startOfDay();
        $fDateMonth = date('Y-m-d', strtotime($fromDate));
        $lDateMonth = date('Y-m-d', strtotime($toDate));



        $lawyerHours = $this->lawyer->lawyerHours()->where('day', $this->dateDay)->first();

        $getLeaves = Leave::where('user_id', $this->lawyerID)
            ->where('date', $date)
            ->get();

        //  dd( $getLeaves);
        if (!count($getLeaves) > 0) {
            if (@$lawyerHours && $date > date('Y-m-d')) {

                $startTime = strtotime($lawyerHours->from_time);
                $endTime = strtotime($lawyerHours->to_time);
                $duration = '30';

                //...
                $time_slots = array();
                $add_mins  = $duration * 60;

                while ($startTime <= $endTime) {
                    $time_slots[] = date("H:i", $startTime);
                    $startTime += $add_mins;
                }

                $this->workingDatesTimeSlot = $time_slots;
            }
        }

        $this->checkIfBookingAlreadyExits($date);
    }

    //register and save card details
    public function saveUserInfoAndBooking()
    {

        $this->validate();

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $selectDate = Carbon::parse($this->selectDate);
        $date = $selectDate->format('Y-m-d');
        
        $ndate = $this->selectDate . ' ' . $this->selectDateTimeSlot;
        $nTimeSlot = date('H:m', strtotime($ndate));

        try {
            $dateTime = Carbon::parse($ndate);
            $meeting = new MeetingController;
            $a = $meeting->store($dateTime);

            $zoom_id = $a['data']['id'];
            $zoom_password = $a['data']['password'];
            $zoom_start_url = $a['data']['start_url'];
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

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


        $saveCardId = null;

        if ($this->lawyer->details->is_consultation_fee == "yes") {
            try {
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
                    'email' => @$authUser->email,
                    'description' => 'My name is ' . @$authUser->name,
                ]);

                $customer_id = $customer['id'];
                //save customer id in card table
                $saveCard = new UserCard;
                $saveCard->user_id = $authUser->id;
                $saveCard->customer_id = $customer_id;
                $saveCard->save();

                $saveCardId = $saveCard->id;
            } catch (\Stripe\Exception\CardException $e) {
                $error = $e->getMessage();
            }
        }


        //save booking && whenn zoom link create
        if (@$a) {
            $booking = new Booking;
            $booking->user_id = $authUser->id;
            $booking->lawyer_id = $this->lawyerID;
            $booking->user_cards_id = $saveCardId;
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
                $booking->price = $this->lawyer->details->consultation_fee;
            }

            $booking->zoom_id = @$zoom_id;
            $booking->zoom_password = @$zoom_password;
            $booking->zoom_start_url = @$zoom_start_url;
            $booking->save();

            if ($booking) {

                //send notification to User
                Notification::route('mail', $this->email)->notify(new BookingMail($booking, $authUser));
                //send notification to lawyer
                Notification::route('mail', $this->lawyer->email)->notify(new BookingMail($booking, $this->lawyer));

                //...
                if(!Auth::check()){
                    Auth::login($authUser);
                }
                
                $this->flash('success', 'Booking done successfully');
                return redirect()->route('client.dashboard');
            }
        }
    }

    public function login()
    {
        $this->validate([
            'uemail' => 'required',
            'upassword' => 'required',

        ], [
            'uemail.required' => 'email field is required.',
            'upassword.required' => 'password field is required',
        ]);

        $email = $this->uemail;
        $password = $this->upassword;

        $credentials = ['email' => $email, 'password' => $password];

        if (!Auth::attempt($credentials)) {
            $this->currentTab = "tab2";

            Session::flash('error', 'Invalid credentials');
        } else {
            $this->first_name = auth()->user()->first_name;
            $this->last_name = auth()->user()->last_name;
            $this->email = auth()->user()->email;
            $this->phone = auth()->user()->contact_number;
            $this->password = null;
            $this->password_confirmation = null;
            $this->currentTab = "tab2";
            $this->emit('loginFormClose');
            $this->resetLoginfields();
        }
    }

    public function resetLoginfields()
    {
        $this->uemail = null;
        $this->upassword = null;
    }

    // check booking already exits
    public function checkIfBookingAlreadyExits($date)
    {
        $this->is_booking_exits = Booking::where('lawyer_id', $this->lawyerID)->where('booking_date', $date)->get();
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
