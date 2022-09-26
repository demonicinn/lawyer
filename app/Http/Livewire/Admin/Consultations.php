<?php

namespace App\Http\Livewire\Admin;

use App\Models\Booking;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Consultations extends Component
{
    public $lawyerId, $upcomingConsul, $completeConsul, $acceptConsul, $tab, $search;

    public $upcomingTab = true;
    public $completeTab = false;
    public $acceptTab = false;
    public $title = [];


    public function mount($lawyerId)
    {
        $this->lawyerId = $lawyerId;
        if ($this->tab == null) {
            $this->upcomingConsultations();
        }
    }

    public function updatedSearch()
    {
        if ($this->tab == null) {
            $this->upcomingConsultations();
        } elseif ($this->tab == 'complete') {

            $this->upcomingTab = false;
            $this->completeTab = true;
            $this->acceptTab = false;
            $this->completeConsultations('complete');
        } elseif ($this->tab == 'accepted') {

            $this->upcomingTab = false;
            $this->completeTab = false;
            $this->acceptTab = true;
            $this->acceptConsultations('accepted');
        }
    }

    public function upcomingConsultations()
    {
        $this->tab == null;
        $this->title = array(
            'title' => 'Upcoming',
            'active' => 'upcoming',
        );

        $upcoming = Booking::where('lawyer_id', $this->lawyerId)
            ->where('booking_Date', '>=', date('Y-m-d'))
            ->where('is_call', 'pending')
            ->where('reschedule', '0');

        if (!empty($this->search)) {
            $search = $this->search;
            $upcoming->whereHas('user', function ($query) use ($search) {
                $query->where(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%" . $search . "%");
            });
        } else {
            $upcoming->with('user');
        }

        $upcoming = $upcoming->latest('id')->get();
        $this->upcomingConsul = $upcoming;
        $this->upcomingTab = true;
        $this->completeTab = false;
        $this->acceptTab = false;
    }

    public function completeConsultations($tab)
    {
        $this->tab = $tab;
        $this->title = array(
            'title' => 'Complete',
            'active' => 'complete',
        );
        $complete = Booking::where('lawyer_id', $this->lawyerId)
            ->where('is_call', 'completed')
            ->where('is_accepted', '0');


        if (!empty($this->search)) {
            $search = $this->search;
            $complete->whereHas('user', function ($query) use ($search) {
                $query->where(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%" . $search . "%");
            })->with('user', 'notes');
        } else {
            $complete->with('user');
        }
        $complete = $complete->latest('id')->get();
        $this->completeConsul = $complete;
        $this->completeTab = true;
        $this->upcomingTab = false;
        $this->acceptTab = false;
    }

    public function acceptConsultations($tab)
    {
        // dd($tab);
        $this->tab = $tab;
        $this->title = array(
            'title' => 'Accepted',
            'active' => 'accepted',
        );

        $accept = Booking::where('lawyer_id', $this->lawyerId)
            ->where('is_call', 'completed')
            ->where('is_accepted', '1');

        if (!empty($this->search)) {

            $search = $this->search;
            $accept->whereHas('user', function ($query) use ($search) {
                $query->where(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%" . $search . "%");
            })->with('notes');
        } else {
            $accept->with('user', 'notes');
        }
        $accept = $accept->latest('id')->get();
        $this->acceptConsul = $accept;

        $this->acceptTab = true;
        $this->completeTab = false;
        $this->upcomingTab = false;
    }

    public function render()
    {

        return view('livewire.admin.consultations');
    }
}
