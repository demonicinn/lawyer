<?php

namespace App\Http\Livewire\Lawyer;

use Livewire\Component;
use App\Models\User;
use App\Models\LawyerHours;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Hours extends Component
{
    use LivewireAlert;

    public $weekdays=[], $from_time, $to_time;

    public $user;
    public $getTime = [];
    
    public $newDate;

    public $hourId;
    protected $listeners = ['confirmedDelete'];

    public function mount(){
        $this->user = auth()->user();
        $this->getTime = User::getTime();
    }


    public function resetInput(){
        $this->weekdays = [];
        $this->from_time = '';
        $this->to_time = '';
        $this->hourId = '';
    }


    public function store(){
        $this->validate([
            'weekdays' => 'required|array|min:1',
            'from_time' => 'required',
            'to_time' => 'required',
        ]);

        

        $days = array();
        foreach($this->weekdays as $day){
            if($day){
                array_push($days, $day);
            }
        }


        $store = new LawyerHours;
        $store->users_id = $this->user->id;
        $store->day = json_encode($days);
        $store->from_time = $this->from_time;
        $store->to_time = $this->to_time;
        $store->save();

        $this->alert('success', 'Weekday Added');
        $this->resetInput();
    }
    
    
    
    public function storeAvailability(){
        $this->validate([
            'from_time' => 'required',
            'to_time' => 'required',
        ]);

        

        $days = array();
        foreach($this->weekdays as $day){
            if($day){
                array_push($days, $day);
            }
        }


        $store = new LawyerHours;
        $store->users_id = $this->user->id;
        $store->date = date('Y-m-d', strtotime($this->newDate));
        $store->from_time = $this->from_time;
        $store->to_time = $this->to_time;
        $store->save();

        $this->alert('success', 'Weekday Added');
        $this->resetInput();
        $this->emit('availabilityFormClose');
    }
    
    

    public function delete($id){
        $this->resetInput();
        $this->hourId = $id;


        $this->alert('', 'Are you sure to delete?', [
            'toast' => false,
            'position' => 'center',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'onConfirmed' => 'confirmedDelete',
            'allowOutsideClick' => false,
            'timer' => null
        ]);
    }


    public function confirmedDelete()
    {
        $hour = LawyerHours::findOrFail($this->hourId);

        $hour->delete();

        $this->alert('success', 'Hour Removed');
    }

    public function render()
    {
        $hours = LawyerHours::where('users_id', $this->user->id)->get();

        return view('livewire.lawyer.hours', ['hours'=>$hours]);
    }
}
