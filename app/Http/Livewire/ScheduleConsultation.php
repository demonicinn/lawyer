<?php

namespace App\Http\Livewire;

use App\Http\Controllers\MeetingController;

use Livewire\Component;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Models\User;
use App\Models\LawyerHours;

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

        
        $ndate = $this->selectDate.' '.$this->selectDateTimeSlot;
        

        $date = Carbon::parse($ndate);

        $meeting = new MeetingController;

        $a = $meeting->store($date);

        dd($a);
        $this->currentTab = "tab2";
    }

    public function backbtn()
    {
        $this->currentTab = "tab1";
    }

    


    public function monthChange()
    {
        if($this->month && $this->year)
        {
            $ndate = date($this->year.'-'.$this->month.'-1');
            $date = Carbon::parse($ndate);

            //$this->workingDates = [];

            $this->getWorkingDays($date);
        }
    }


    private function getWorkingDays($today){

        $fromDate = $today->copy()->firstOfMonth()->startOfDay();
        $toDate = $today->copy()->endOfMonth()->startOfDay();
        

        $dates = [];
        $period = CarbonPeriod::create($fromDate, $toDate);

        $lawyerHoursDay = $this->lawyer->lawyerHours->pluck('day')->toArray();

        foreach ($period as $date) {
            $day = $date->format('l');
            $ndate = $date->format('Y-m-d');

            if($ndate > date('Y-m-d') && in_array($day, $lawyerHoursDay)){
                array_push($dates, $ndate);
            }
        }
        //dd($dates);
        $this->workingDates = $dates;

        $this->emit('fireCalender', $this->workingDates);
    }

    public function slotAvailability()
    {
        $selectDate = Carbon::parse($this->selectDate);

        $date = $selectDate->format('Y-m-d');
        //dd($this->selectDate);
        $this->dateDay = $selectDate->format("l");
        $this->dateFormat = $selectDate->format("l, F j ");

        //...
        $lawyerHours = $this->lawyer->lawyerHours()->where('day', $this->dateDay)->first();


        if(@$lawyerHours && $date > date('Y-m-d')) {
            $startTime = strtotime($lawyerHours->from_time);
            $endTime = strtotime($lawyerHours->to_time);
            $duration = '30';

            //...
            $time_slots = array();
            $add_mins  = $duration * 60;

            while ($startTime <= $endTime)
            {
                $time_slots[] = date("H:i", $startTime);
                $startTime += $add_mins;
            }

            $this->workingDatesTimeSlot = $time_slots;
        }

        //dd($day);
    }

    public function render()
    {
        //$this->resetValidation();
        $this->workingDatesTimeSlot = [];
        //...
        $this->monthChange();

        //...
        if($this->selectDate){
            $this->slotAvailability();
        }

        return view('livewire.schedule-consultation');
    }
}
