<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Booking;
use App\Models\Leave;
use App\Models\User;

class RescheduleBooking extends Component
{
    public $bookingId, $lawyerId, $userId, $todayDate, $authUser,
           $workingDates, $bookDate ,$selectDate,$selectDateTimeSlot;
    public $workingDatesTimeSlot = [];
    public $month, $year;

    public $dateDay, $dateFormat;

  


    public function monthChange()
    {
        // dd('monthchange');
        if ($this->month && $this->year) {
            $ndate = date($this->year . '-' . $this->month . '-1');
            $date = Carbon::parse($ndate);

            //$this->workingDates = [];

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



        $lawyerHours = $this->lawyer->lawyerHours()->where('day', $this->dateDay)->first();

        $getLeaves = Leave::where('user_id',$this->lawyerId)
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
                // dd( $this->workingDatesTimeSlot );
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
        $lawyerHoursDay = $this->lawyer->lawyerHours->pluck('day')->toArray();
        // dd($lawyerHoursDay);
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
        $result = array_diff($dates, $getLeaves);
        // dd($result);
        $this->workingDates = $result;

        $this->checkIfBookingAlreadyExits($this->bookDate);

        $this->emit('fireCalender', $this->workingDates);
    }

    // check booking already exits
    public function checkIfBookingAlreadyExits($date)
    {
        $this->is_booking_exits = Booking::where('lawyer_id', $this->lawyerId)->where('booking_date', $date)->get();
    }

    public function mount($bookingId)
    {
        $this->bookingId = $bookingId;

        $bookingDetails = Booking::where('id', $bookingId)->first();

        $this->lawyerId = $bookingDetails->lawyer_id;

        $this->lawyer = User::where('id', $this->lawyerId)->with('details')->first();
        $this->authUser = auth()->user();
        $this->todayDate = Carbon::now();

        $this->dateFormat=$this->todayDate->format("l, F j ");
        $this->getWorkingDays($this->todayDate);
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
