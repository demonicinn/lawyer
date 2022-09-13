<?php

namespace App\Http\Livewire;

use App\Http\Controllers\MeetingController;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Stripe\Stripe;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\LawyerHours;
use App\Models\Leave;
use PasswordValidationRules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ScheduleConsultation extends Component
{





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




    public $day, $avaibleTime, $selDate, $lawyerDetails, $scheduletime;
    public $timeSlots = [];
    public $shedulePage = true;
    public $clickConfirm = false;

    public $first_name, $last_name, $phone, $password,
        $password_confirmation, $email, $card_name, $card_number,
        $expire_month, $expire_year, $cvv, $upassword, $uemail;



    public function mount()
    {
        $this->lawyer = User::findOrFail($this->lawyerID);

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




        $ndate = $this->selectDate . ' ' . $this->selectDateTimeSlot;


        $date = Carbon::parse($ndate);

        // $meeting = new MeetingController;

        // $a = $meeting->store($date);

        // dd($a);
        $this->currentTab = "tab2";
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


        $dates = [];
        $period = CarbonPeriod::create($fromDate, $toDate);

        $lawyerHoursDay = $this->lawyer->lawyerHours->pluck('day')->toArray();
        // dd($lawyerHoursDay);
        $getLeaves = Leave::where('user_id', $this->lawyerID)->pluck('date')->toArray();
        //  dd($getLeaves);
        foreach ($period as $date) {
            $day = $date->format('l');
            $ndate = $date->format('Y-m-d');


            if ($ndate > date('Y-m-d') && in_array($day, $lawyerHoursDay)) {
                array_push($dates, $ndate);
            }
        }
        // dd($dates);
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
        $this->dateFormat = $selectDate->format("l, F j ");


        $lawyerHours = $this->lawyer->lawyerHours()->where('day', $this->dateDay)->first();
        $getLeaves = Leave::where('user_id', $this->lawyerID)->where('date', $date)->get();
      

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
    }

    //register and save card details
    public function saveUserInfo()
    {

        $this->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'phone' => ['required', 'numeric', 'digits_between:10,12'],
            'password' => 'required',
            'password_confirmation' => 'required_with:password|same:password',

            'card_name' => 'required|max:50',
            'card_number' => 'required|numeric|digits_between:12,16',
            'expire_month' => 'required',
            'expire_year' => 'required',
            'cvv' => 'required|numeric|digits_between:3,4'

        ], [
            'card_name.required' => 'Name on card field is required.',
        ]);

        if (!Auth::user()) {
            $createUser = new User;
            $createUser->first_name = $this->first_name;
            $createUser->last_name = $this->last_name;
            $createUser->email = $this->email;
            $createUser->contact_number = $this->phone;
            $createUser->role = "user";
            $createUser->password = Hash::make($this->phone);
            $createUser->save();
            \Stripe\Stripe::setApiKey('sk_test_zWBOwA6y41R35yX2S2Xx549s');
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

                if ($createUser->id) {
                    $customer = \Stripe\Customer::create([
                        'source' => $token['id'],
                        'email' =>  $createUser->email,
                        'description' => 'My name is ' . $createUser->first_name,
                    ]);

                    $customer_id = $customer['id'];
                    //update customer id
                    $user = User::findOrFail($createUser->id);
                    $user->customer_id = $customer_id;
                    $user->update();
                    // dd("data saved");
                }
            } catch (\Stripe\Exception\CardException $e) {
                $error = $e->getMessage();
            }
        }
    }

    public function login()
    {
        $this->validate([
            'uemail' => 'required',
            'upassword' => 'required',

        ], [
            'uemail.required' => 'email field isrequired.',
            'upassword.required' => 'password field isrequired',
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
