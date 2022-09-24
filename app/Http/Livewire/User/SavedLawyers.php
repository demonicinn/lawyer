<?php

namespace App\Http\Livewire\User;

use App\Models\Contract;
use App\Models\Litigation;
use App\Models\SavedLawyer;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class SavedLawyers extends Component
{
    use WithPagination;

    public $lawyers, $authUser, $search, $ligitions, $contracts, $practices, $practiceArea, $areaId;

    public function mount()
    {
        $this->authUser = auth()->user();
        $this->lawyers = SavedLawyer::where('user_id', $this->authUser->id)->with('lawyer')->get();
        $this->ligitions = Litigation::where('status','1')->get();
        $this->contracts = Contract::where('status','1')->get();
    }

    public function searchFilter()
    {
        $user = SavedLawyer::with('lawyer')->where('user_id', $this->authUser->id);

        if ($this->practiceArea == 'Litigations') {
            $this->practices =  $this->ligitions; 
            if ($this->areaId) {
                dd($this->areaId);
            }
        } elseif ($this->practiceArea == 'Contracts') {
            $this->practices =  $this->contracts;
            if ($this->areaId) {
                dd($this->areaId);
            }
        } else {
            $this->practices = null;
        }
    
        if (!empty($this->search)) {
            $search = $this->search;
            $this->authUser = auth()->user();
           
                $user->whereHas('lawyer', function ($query) use ($search) {
                    $query->where('contact_number', 'LIKE', "%" . $search . "%");
                    $query->orWhere(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%" . $search . "%");
                });
            $user = $user->get();
            $this->lawyers = $user;
        }
    }
    public function render()
    {
        $this->searchFilter();
        return view('livewire.user.saved-lawyers');
    }
}
