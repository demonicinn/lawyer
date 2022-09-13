<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\LawyerHours;

class ScheduleConsultation extends Component
{
    public $lawyerID, $lawyer, $day, $avaibleTime, $selDate, $lawyerDetails, $scheduletime;
    public $timeSlots = [];
    public $shedulePage = true;
    public $clickConfirm = false;

    public function availability()
    {

        // $this->day = 'monday';
        $this->day = Carbon::now()->format("l");

        $this->avaibleTime = Carbon::now()->format("l, F j ");


        if ($this->selDate) {

            $seleted_date = date('l, F j', strtotime($this->selDate . ' +1 day'));
            $this->avaibleTime = $seleted_date;
            $this->day  = date('l', strtotime($this->selDate . ' +1 day'));
        }
        $user = LawyerHours::where('users_id', $this->lawyerID)->where('day', $this->day)->first();
        $this->lawyer = $user;

        if ($this->lawyer != null) {
            $starttime = $user->from_time; // your start time
            $endtime = $user->to_time;  // End time
            $duration = '30';  // split by 30 mins
            $time_slots = array();
            $start_time    = strtotime($starttime); //change to strtotime
            $end_time      = strtotime($endtime); //change to strtotime

            $add_mins  = $duration * 60;

            while ($start_time <= $end_time) // loop between time
            {
                $time_slots[] = date("H:i", $start_time);
                $start_time += $add_mins; // to check endtime
            }

            $this->timeSlots = $time_slots;
            // dd($this->timeSlots);
        }
    }

    public function confirm()
    {
        $this->validate([
            'scheduletime' => 'required|max:255',

        ], [
            'scheduletime.required' => 'please select time.'
        ]);

       

        $this->clickConfirm = true;
        $this->shedulePage = false;
        $this->lawyerDetails = User::where('id', $this->lawyerID)->first();
    }

    public function backbtn()
    {
        $this->clickConfirm = false;
        $this->shedulePage = true;
    }


    public function render()
    {
        $this->availability();

        return view('livewire.schedule-consultation');
    }
}
