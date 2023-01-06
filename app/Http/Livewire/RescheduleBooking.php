<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Booking;
use App\Models\Leave;
use App\Models\User;
use App\Notifications\RescheduleMail;
use Illuminate\Support\Facades\Notification;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Http\Controllers\MeetingController;

class RescheduleBooking extends Component
{

    use LivewireAlert;

    public $clicked = '0';
    public $bookingId, $lawyerId, $userId, $todayDate, $authUser,
        $workingDates, $bookDate, $selectDate, $selectDateTimeSlot;
    public $workingDatesTimeSlot = [];
    public $month, $year;

    public $dateDay, $dateFormat;

    public function rules()
    {
        return [
            'selectDate' => 'required',
            'selectDateTimeSlot' => 'required',
        ];
    }

    protected $messages = [
        'selectDate.required' => 'Please select date.',
        'selectDateTimeSlot.required' => 'Please select time slot.'
    ];



    public function monthChange()
    {
        if ($this->month && $this->year) {
            $ndate = date($this->year . '-' . $this->month . '-1');
            $date = Carbon::parse($ndate);
            $this->getWorkingDays($date);
        }
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



        //$lawyerHours = $this->lawyer->lawyerHours()->where('day', $this->dateDay)->get();
        //$lawyerHours = $this->lawyer->lawyerHours()->where('day', 'like', '%'.$this->dateDay.'%')->get();
        
        $lawyerHoursDay = $this->lawyer->lawyerHours()->where('day', 'like', '%'.$this->dateDay.'%')
                        ->where('date', null)
                        ->get();
                        
                        
                        
        $lawyerHoursDate = $this->lawyer->lawyerHours()->where('day', null)
                        ->where('date', $date)
                        ->get();
        
        
        $lawyerHours = $lawyerHoursDate->push(...$lawyerHoursDay);
        

        $getLeaves = $this->lawyer->booking()->whereDate('booking_date', $date)->where('is_canceled', '0')->pluck('booking_time')->toArray();


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
                
                
                $temp = array_unique(array_column($time_slots, 'time'));
                $unique_arr = array_intersect_key($time_slots, $temp);
                
                $this->workingDatesTimeSlot = $unique_arr;
            }
        }

        $this->checkIfBookingAlreadyExits($date);
    }
    private function getWorkingDays($today)
    {

        $fromDate = $today->copy()->firstOfMonth()->startOfDay();
        $toDate = $today->copy()->endOfMonth()->startOfDay();

        $Month = date('m', strtotime($fromDate));
        $Year = date('Y', strtotime($fromDate));

        $dates = [];
        $period = CarbonPeriod::create($fromDate, $toDate);
        

        //$lawyerHoursDayAll = $this->lawyer->lawyerHours()->get()->pluck('days_array')->toArray();
        $lawyerHoursDayAll = $this->lawyer->lawyerHours()->where('day', '!=', '')->get()->pluck('days_array')->toArray();

        $lawyerHoursDates = $this->lawyer->lawyerHours()->where('day', null)
                                ->where(function($query) use ($fromDate, $toDate) {
                                    $query->where('date', '>=', $fromDate);
                                    $query->where('date', '<=', $toDate);
                                })->get()->pluck('date')->toArray();
                                
                                
        $lawyerHoursDayArray = [];
        foreach($lawyerHoursDayAll as $days){
            foreach($days as $day){
            array_push($lawyerHoursDayArray, $day);
            }
        }

        $lawyerHoursDay = array_values(array_unique($lawyerHoursDayArray));
        
        $getLeaves = Leave::where('user_id', $this->lawyerId)
            ->whereMonth('date', $Month)
            ->whereYear('date', $Year)
            ->pluck('date')->toArray();
        // dd($getLeaves);
        foreach ($period as $date) {
            $day = $date->format('l');
            $ndate = $date->format('Y-m-d');

            //  dd($ndate );

            if ($ndate > date('Y-m-d') && in_array($day, $lawyerHoursDay)) {
                array_push($dates, $ndate);
            }
        }
        // dd($dates);
        
        $nDates = array_merge($dates, $lawyerHoursDates);
        
        $result = array_diff($nDates, $getLeaves);
        
        $result = array_unique($result);
        // dd($result);
        $this->workingDates = $result;

        $this->checkIfBookingAlreadyExits($this->bookDate);

        $this->emit('fireCalender', $this->workingDates);
    }

    // check booking already exits
    public function checkIfBookingAlreadyExits($date)
    {
        $this->is_booking_exits = Booking::where('lawyer_id', $this->lawyerId)->where('booking_date', $date)->get();
        // dd( $this->is_booking_exits);
    }

    public function mount($bookingId)
    {
        $this->bookingId = $bookingId;
        $bookingDetails = Booking::where('id', $bookingId)->first();
        $this->lawyerId = $bookingDetails->lawyer_id;
        $this->lawyer = User::where('id', $this->lawyerId)->with('details')->first();
        $this->authUser = auth()->user();
        $this->todayDate = Carbon::now();
        $this->dateFormat = $this->todayDate->format("l, F j ");
        $this->getWorkingDays($this->todayDate);
    }

    public function confirmSlot()
    {
        $this->validate();

        $selectDate = Carbon::parse($this->selectDate);
        $date = $selectDate->format('Y-m-d');
        $ndate = $this->selectDate . ' ' . $this->selectDateTimeSlot;
        $nTimeSlot = date('H:i:s', strtotime($this->selectDateTimeSlot));

        // $ndate = $this->selectDate . ' ' . date('H:i', strtotime($this->selectDateTimeSlot));

        // $nTimeSlot = date('H:i', strtotime($this->selectDateTimeSlot));
        // update zoom meeting
        try {
            $dateTime = Carbon::parse($ndate);
            $meeting = new MeetingController;
            $a = $meeting->store($dateTime);

            $zoom_id = $a['data']['id'];
            $zoom_password = @$a['data']['password'];
            $zoom_start_url = @$a['data']['start_url'];
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        $rescheduleBooking = Booking::where('id', $this->bookingId)->with('lawyer', 'user')->first();
        $rescheduleBooking->booking_date = $date;
        $rescheduleBooking->booking_time = $nTimeSlot;
        $rescheduleBooking->zoom_id = @$zoom_id;
        $rescheduleBooking->zoom_password = @$zoom_password;
        $rescheduleBooking->zoom_start_url = @$zoom_start_url;
        $rescheduleBooking->update();


        if ($rescheduleBooking) {
            $user = $rescheduleBooking->user;
            $lawyer = $rescheduleBooking->lawyer;
            //send notification to User
            Notification::route('mail', $rescheduleBooking->user_email)->notify(new RescheduleMail($rescheduleBooking, $user));
            //send notification to lawyer
            Notification::route('mail', $rescheduleBooking->lawyer->email)->notify(new RescheduleMail($rescheduleBooking, $lawyer));

            //...
            $this->flash('success', 'Booking reschedule successfully.');
            return redirect()->route('consultations.upcoming');
        }
    }

    public function render()
    {

        // $this->workingDatesTimeSlot = [];
        //...
        $this->monthChange();

        //...
        if ($this->selectDate) {
            $this->slotAvailability();
        }
        return view('livewire.reschedule-booking');
    }
}
