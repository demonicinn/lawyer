<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\LawyerHours;

class ScheduleConsultation extends Component
{
    public $lawyerID, $lawyer, $day, $avaibleTime, $selDate;

    public function availability()
    {
        $this->day = Carbon::now()->format("l");
        $this->avaibleTime = Carbon::now()->format("l, F j ");


        if ($this->selDate) {

            $seleted_date = date('l, F j', strtotime($this->selDate . ' +1 day'));
            $this->avaibleTime = $seleted_date;
            $this->day  = date('l', strtotime($this->selDate . ' +1 day'));
        }
        $user = LawyerHours::where('users_id', $this->lawyerID)->where('day', $this->day)->first();

        $this->lawyer = $user;
    }

    public function render()
    {
        $this->availability();

        return view('livewire.schedule-consultation');
    }
}
